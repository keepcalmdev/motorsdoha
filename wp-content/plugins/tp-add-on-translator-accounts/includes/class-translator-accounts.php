<?php
/**
 * Main Class For Translator Accounts
 *
 * @link       https://translatepress.com
 * @since      1.0.0
 *
 * @package    TranslatePress - Translator Accounts Add-on
 * @subpackage TranslatePress - Translator Accounts Add-on/includes
 */
/**
 * Main functionality for the translator accounts addon.
 *
 * This allows the administrator to create users with the translator role or assign the translator role to existing users, except those who can manage options.
 *
 * @since      1.0.0
 * @package    TranslatePress - Translator Accounts Add-on
 * @subpackage TranslatePress - Translator Accounts Add-on/includes
 * @author     Cristian Antohe
 */
class TRP_Translator_Accounts{
    protected $loader;

    /**
     * Init all the hooks and filters.
     *
     * @since    1.0.0
     */
    public function __construct() {

        define( 'TRP_TA_PLUGIN_DIR', plugin_dir_path( __DIR__ ) );
        define( 'TRP_TA_PLUGIN_URL', plugin_dir_url( __DIR__ ) );

        $trp = TRP_Translate_Press::get_trp_instance();
        $this->loader = $trp->get_component( 'loader' );
        $this->loader->add_action( 'show_admin_bar', $this, 'show_admin_bar', 80, 1 );
        $this->loader->add_action( 'admin_bar_menu', $this, 'remove_settings_link', 999, 1 );
        $this->loader->add_filter( 'trp_translating_capability', $this, 'translator_account_permissions' );

        $this->loader->add_action( 'show_user_profile', $this, 'translator_profile_field', 10, 1 );
        $this->loader->add_action( 'edit_user_profile', $this, 'translator_profile_field', 10, 1 );
        $this->loader->add_action( 'profile_update', $this, 'translator_save_profile_field', 20, 1 );


        require_once(  TRP_TA_PLUGIN_DIR . 'includes/class-plugin-updater.php' );
        $this->plugin_updater = new TRP_TA_Plugin_Updater();
        $this->loader->add_action( 'admin_init', $this->plugin_updater, 'activate_license' );
        $this->loader->add_action( 'admin_init', $this->plugin_updater, 'deactivate_license' );
        $this->loader->add_action( 'admin_notices', $this->plugin_updater, 'admin_notices' );

        global $trp_license_page;
        if( !isset( $trp_license_page )  ) {
            $trp_license_page = new TRP_LICENSE_PAGE();
            $this->loader->add_action('admin_menu', $trp_license_page, 'license_menu');
            $this->loader->add_action( 'admin_init', $trp_license_page, 'register_option' );
        }

    }

    /**
     * Always show the admin bar if the user has the translate_strings capability.
     *
     * @since    1.0.0
     */
    public function show_admin_bar($show){
        if (current_user_can('translate_strings'))
            return true;

        return $show;
    }

    /**
     * Anyone who can't manage_options should not see the TranslatePress Settings page link.
     *
     * @since    1.0.0
     */
    public function remove_settings_link( $wp_admin_bar ){
        if ( !current_user_can('manage_options') )
            $wp_admin_bar->remove_node( 'trp_settings_page' );
    }

    /**
     * Allow users with the translate_strings to translate the website, besides those with manage_options.
     *
     * @since    1.0.0
     */
    public function translator_account_permissions(){
        // Return manage_options for admins
        if (current_user_can('manage_options'))
            return 'manage_options';

        return 'translate_strings';
    }

    /**
     * Add a checkbox to user profile page to add the translator role to it.
     *
     * If the user is an administrator the checkbox is always checked and disabled. We're also modifying the default WordPress role select to be named trp_role so WordPress does not overwrite our checkbox.
     *
     * @since    1.0.0
     */
    public function translator_profile_field( $user ){
        // users with translate_strings can translate the website
        $checked = "";
        if ( user_can( $user,'translate_strings' ) ){
            $checked = ' checked="checked" ';
        }

        // administrators can translate the website
        $disabled = '';
        if ( user_can( $user,'manage_options' ) ){
            $checked = ' checked="checked" ';
            $disabled = ' disabled="disabled" ';
        }

        // only show this setting to the administrator. Translators can not make themselves a translator.
        if (current_user_can('manage_options')) :
            ?>
            <h3><?php _e(" TranslatePress Settings", "translatepress-multilingual"); ?></h3>

            <table class="form-table">
                <tr class="">
                    <th scope="row"><?php _e('Translator', 'translatepress-multilingual');?></th>
                    <td><fieldset><legend class="screen-reader-text"><span><?php _e('Translator', 'translatepress-multilingual');?></span></legend>
                            <label for="trp_translator">
                                <input name="trp_translator" id="trp_translator_hidden" value="0" type="hidden">
                                <input name="trp_translator" id="trp_translator" value="1" <?php echo $checked . $disabled; ?> type="checkbox">
                                <?php _e('Allow this user to translate the website.', 'translatepress-multilingual');?></label><br>
                        </fieldset>
                    </td>
                </tr>
            </table>
        <?php endif;
    }

    /**
     * Save the user translator role if needed the case.
     *
     * @since    1.0.0
     */
    public function translator_save_profile_field( $user_id ){
        // First Take into account the WordPress Role
        $user = new WP_User($user_id);

        // Next add the extra translator user role if needed.
        // only an administrator can make a translator and an administrator doesn't need to be a translator.
        if ( !current_user_can( 'edit_users' ) || user_can($user_id, 'manage_options') ) {
            return;
        }

        if( isset( $_POST['trp_translator'] ) && $_POST['trp_translator'] == '1' ) {
            $user ->add_role('translator');
        } elseif(isset( $_POST['trp_translator'] ) && $_POST['trp_translator'] == '0') {
            $user ->remove_role('translator');
        }
}
}