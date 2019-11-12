<?php
/*
	Plugin Name: Dynamic URL SEO
	Plugin URI: https://brainvire.com/
	Version: 1.0
	Description: This plugin is used to add meta title, keywords and description for dynamic URLs which are not available in database.
	Author: Brainvireinfo
	Author URI: https://www.brainvire.com/
	License: GPL2
*/

if ( !defined( 'ABSPATH' ) )
    exit;

if ( ! defined( 'DUS_PLUGIN_PATH' ) ) {
	define( 'DUS_PLUGIN_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) . '/' );
}

include_once plugin_dir_path ( __FILE__ ) . '/dynamic-url-listing-page.php';
include_once plugin_dir_path ( __FILE__ ) . '/dynamic-url-schema-markup-page.php';


add_action( 'admin_enqueue_scripts', 'dus_admin_enqueue_scripts' );
function dus_admin_enqueue_scripts() {
    wp_enqueue_style('dus_admin_css', DUS_PLUGIN_PATH . 'css/admin.css');
	wp_enqueue_style('dus_jquery_ui_css', DUS_PLUGIN_PATH . 'css/jquery-ui.min.css');
    wp_enqueue_script('dus_admin_js', DUS_PLUGIN_PATH . 'js/admin.js');
	wp_enqueue_script('jquery-ui-tabs');
}


function dus_plugin_action_redirect_link( $redirect_links ) {
    
   $redirect_links[] = '<a href="'. esc_url( get_admin_url(null, 'admin.php?page=dynamic_url_seo_listing_page') ) .'">Settings</a>';
   return $redirect_links;
}
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'dus_plugin_action_redirect_link' );


/*
 *  Auto-Create table and pages while active plugin
 */
register_activation_hook( __FILE__, 'dus_custom_plugin_activation' );
function dus_custom_plugin_activation() {
    
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    global $wpdb;
    $dynamic_custom_url_seo = $wpdb->prefix . 'dynamic_custom_url_seo';
    $dynamic_custom_url_seo_schema = $wpdb->prefix . 'dynamic_custom_url_seo_schema';

    if ( $wpdb->get_var( "SHOW TABLES LIKE '$dynamic_custom_url_seo'" ) != $dynamic_custom_url_seo ) {
        
        if ( !empty( $wpdb->charset ) )
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        
        if ( !empty( $wpdb->collate ) )
            $charset_collate .= " COLLATE $wpdb->collate";

        $sql_rp = "CREATE TABLE " . $dynamic_custom_url_seo . " (
                         id int(10) unsigned NOT NULL AUTO_INCREMENT,
                         url varchar(500) NOT NULL,
                         meta_title varchar(500) NOT NULL,
                         meta_keyword varchar(1000) NOT NULL,
		 				 meta_description varchar(1000) NOT NULL,
                         canonical_url varchar(1000) NOT NULL,
                         meta_robots_index varchar(1000) NOT NULL,
                         meta_robots_follow varchar(1000) NOT NULL,
                         meta_robots_noodp varchar(1000) NOT NULL,
                         meta_robots_noydir varchar(1000) NOT NULL,
                         PRIMARY KEY (id)
					) $charset_collate;";
        dbDelta($sql_rp);
    }
    
    if ( $wpdb->get_var( "SHOW TABLES LIKE '$dynamic_custom_url_seo_schema'" ) != $dynamic_custom_url_seo_schema ) {
        
        if ( !empty( $wpdb->charset ) )
            $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
        
        if ( !empty( $wpdb->collate ) )
            $charset_collate .= " COLLATE $wpdb->collate";

        $sql_cu = "CREATE TABLE " . $dynamic_custom_url_seo_schema . " (
                         id int(10) unsigned NOT NULL AUTO_INCREMENT,
                         schema_key varchar(1000) NOT NULL,
                         schema_value varchar(1000) NOT NULL,
                         PRIMARY KEY (id)
					) $charset_collate;";
        dbDelta($sql_cu);
    }
}
add_action( 'admin_menu', 'dus_admin_add_new_menu' );



/**
 * Add menu in admin side.
 */
function dus_admin_add_new_menu()
{
    add_submenu_page(
        "dynamic_url_seo_listing_page", 
        "Add New", 
        "Add New", 
        "manage_options", 
        "dynamic_url_seo_add_new",
        "dus_add_new_callback"
    ); 
	
	add_submenu_page(
        "dynamic_url_seo_listing_page", 
        "Schema Markup Generator", 
        "Schema Markup Generator", 
        "manage_options", 
        "dynamic_url_seo_schema_markup",
        "dus_schema_markup_callback"
    ); 
}



function dus_add_new_callback()
{

	if (isset($_POST["seo_submit"]) && !empty($_POST["seo_submit"]) && wp_verify_nonce($_POST['dus_insert_url_form'], 'dus-insert-url-form')) 
	{
		if(is_user_logged_in())
		{
			if(current_user_can('administrator'))
			{
				global $wpdb;
				$table_name = $wpdb->prefix .'dynamic_custom_url_seo';

				$url = isset($_POST['url_field_name']) ? sanitize_text_field($_POST['url_field_name']) : site_url();
				$url = rtrim($url,"/");
				$current_post_id = url_to_postid( $url );
				$metatitle = isset($_POST['metatitle_field_name']) ? sanitize_text_field($_POST['metatitle_field_name']) : '';
				$metatitle = str_replace('\\','',$metatitle);
				$keyword = isset($_POST['keyword_field_name']) ?  sanitize_text_field($_POST['keyword_field_name']) : '';
				$keyword = str_replace('\\','',$keyword);
				$metades = isset($_POST['metades_field_name']) ? sanitize_text_field($_POST['metades_field_name']) : '';
				$metades = str_replace('\\','',$metades);
				$canonical_url = isset($_POST['canonical_url_field_name']) ? sanitize_text_field($_POST['canonical_url_field_name']) : '';
				$canonical_url = str_replace('\\','',$canonical_url);
				$meta_robots_index = isset($_POST['meta_robots_index']) ? sanitize_text_field($_POST['meta_robots_index']) : '';
				$meta_robots_index = str_replace('\\','',$meta_robots_index);
				$meta_robots_follow = isset($_POST['meta_robots_follow']) ? sanitize_text_field($_POST['meta_robots_follow']) : '';
				$meta_robots_follow = str_replace('\\','',$meta_robots_follow);
				$meta_robots_noodp = isset($_POST['meta_robots_noodp']) ? sanitize_text_field($_POST['meta_robots_noodp']) : '';
				$meta_robots_noodp = str_replace('\\','',$meta_robots_noodp);
				$meta_robots_noydir = isset($_POST['meta_robots_noydir'])? sanitize_text_field($_POST['meta_robots_noydir']) : '';
				$meta_robots_noydir = str_replace('\\','',$meta_robots_noydir);
			   
			   
				$check_url = $wpdb->get_row( "SELECT url FROM $table_name WHERE url = '".$url."' ", ARRAY_A);
				$check_url = esc_attr($check_url['url']);
				
				if(!empty($check_url)) {
					echo '<div id="message" class="notice notice-error is-dismissible"><p>This "'.$url.'" URL is already exist in database.</p></div>';
				} else {
					/****************** Insert custom URL for SEO in database ****************** */
					$inserted_id = dus_insert_custom_url( $url, $metatitle, $keyword, $metades, $canonical_url, $meta_robots_index, $meta_robots_follow, $meta_robots_noodp, $meta_robots_noydir);
					
					if(!empty($inserted_id)) {
						echo dus_url_redirect($inserted_id);
					}
				}
			}
		}
	}
	
	if( (isset($_GET["id"]) && !empty($_GET["id"])) || (isset($_POST["seo_update"]) && !empty($_POST["seo_update"])) && wp_verify_nonce($_POST['dus_update_url_form'], 'dus-update-url-form')) 
	{
		if(is_user_logged_in())
		{
			if(current_user_can('administrator'))
			{
				global $wpdb;
				$custom_url_id = sanitize_text_field($_GET["id"]);
				
				if(isset($_POST["seo_update"])) {
					$seo_hidden_update_id = sanitize_text_field($_POST['seo_hidden_update_id']);
					$url = sanitize_text_field($_POST['url_field_name']);
					$url = rtrim($url,"/");
					$current_post_id = url_to_postid( $url );
					$metatitle = sanitize_text_field($_POST['metatitle_field_name']);
					$metatitle = str_replace('\\','',$metatitle);
					
					$keyword = sanitize_text_field($_POST['keyword_field_name']);
					$keyword = str_replace('\\','',$keyword);
					
					$metades = sanitize_text_field($_POST['metades_field_name']);
					$metades = str_replace('\\','',$metades);
					
					$canonical_url = sanitize_text_field($_POST['canonical_url_field_name']);
					$canonical_url = str_replace('\\','',$canonical_url);
					
					$meta_robots_index = sanitize_text_field($_POST['meta_robots_index']);
					$meta_robots_index = str_replace('\\','',$meta_robots_index);
					
					$meta_robots_follow = sanitize_text_field($_POST['meta_robots_follow']);
					$meta_robots_follow = str_replace('\\','',$meta_robots_follow);
					
					$meta_robots_noodp = isset($_POST['meta_robots_noodp']) ? sanitize_text_field($_POST['meta_robots_noodp']) : '';
					$meta_robots_noodp = str_replace('\\','',$meta_robots_noodp);
					
					$meta_robots_noydir = isset($_POST['meta_robots_noydir']) ? sanitize_text_field($_POST['meta_robots_noydir']) : '';
					$meta_robots_noydir = str_replace('\\','',$meta_robots_noydir);
						

					/****************** Update custom URL for SEO in database ****************** */
					$chk_id = dus_check_id_already_exist_or_not($custom_url_id);
					
					if(empty($chk_id)) {
						echo '<div id="message" class="notice notice-error is-dismissible"><p>This ID is not exist in database.</p></div>';
					} else {
						$update_url = dus_update_custom_url( $url, $metatitle, $keyword, $metades, $canonical_url, $meta_robots_index, $meta_robots_follow, $meta_robots_noodp, $meta_robots_noydir, $seo_hidden_update_id );
					}
				}
				
				$dynamic_custom_url_seo = $wpdb->prefix . 'dynamic_custom_url_seo'; // do not forget about tables prefix
				$result = $wpdb->get_row ( $wpdb->prepare ( "SELECT * FROM $dynamic_custom_url_seo WHERE `id` = %d", absint($_GET["id"])));

				$get_url = !empty($result->url) ? esc_attr($result->url) : '';
				$get_metatitle = !empty($result->meta_title) ? esc_attr($result->meta_title) : '';
				$get_keyword = !empty($result->meta_keyword) ? esc_attr($result->meta_keyword) : '';
				$get_metades = !empty($result->meta_description) ? esc_attr($result->meta_description) : '';
				$get_canonical = !empty($result->canonical_url) ? esc_attr($result->canonical_url) : '';
				$get_robots_index = !empty($result->meta_robots_index) ? esc_attr($result->meta_robots_index) : '';
				$get_robots_follow = !empty($result->meta_robots_follow) ? esc_attr($result->meta_robots_follow) : '';
				$get_robots_noodp = !empty($result->meta_robots_noodp) ? esc_attr($result->meta_robots_noodp) : '';
				$get_robots_noydir = !empty($result->meta_robots_noydir) ? esc_attr($result->meta_robots_noydir) : '';
			}
		}
	}
?>
    <div class="wrap">
        <?php 
		if(!empty($custom_url_id)) { 
			$custom_url_id = intval($custom_url_id);
			$action = site_url('/wp-admin/admin.php?page=dynamic_url_seo_add_new&id='.$custom_url_id.'');
			echo "<h1 class='wp-heading-inline'>Edit Form</h1>";
			echo '<a href="'.site_url('/wp-admin/admin.php?page=dynamic_url_seo_add_new').'" class="page-title-action">Add New</a>';
			if(isset($_REQUEST['action'])){
				if(sanitize_text_field($_GET["action"]) == 'edit_url') {
					echo '<hr class="wp-header-end">';
					echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Page/Post URL published</p></div>';
				}
			}
			if(!empty($chk_id)) {
				echo '<hr class="wp-header-end">';
				do_action( 'dus_admin_notices' );
			}
			?>
            <form method="post" id="" action="<?php echo site_url('/wp-admin/admin.php?page=dynamic_url_seo_add_new&id='.$custom_url_id.''); ?>" novalidate="novalidate" enctype="multipart/form-data" onsubmit="return dus_updateContinueOrNot()">
		<?php
			wp_nonce_field('dus-update-url-form','dus_update_url_form'); 
        } else { 
            echo "<h1>Add New Dynamic URL</h1>"; 
			echo '<hr class="wp-header-end">';
		?>
                <form method="post" id="" action="<?php echo site_url('/wp-admin/admin.php?page=dynamic_url_seo_add_new'); ?>" novalidate="novalidate" enctype="multipart/form-data" onsubmit="return dus_continueOrNot()">
		<?php
				wp_nonce_field('dus-insert-url-form','dus_insert_url_form'); 
        }
        ?><table class="dyanmic-url-seo form-table">
					<tbody>
						<tr>
							<th scope="row"><?php echo __('Page/Post URL'); ?></th>
							<td>
								<input name="url_field_name" type="text" id="url_field_name" value="<?php echo !empty($get_url)? $get_url : site_url('/'); ?>" class="regular-text">
								<p class="description" id="tagline-description"><?php echo __('Eg.'); ?> <?php echo site_url('/about-us/'); ?></p>
							</td>
							
						</tr>
						<tr>
							<th scope="row"><?php echo __('Meta Title'); ?></th>
							<td><input name="metatitle_field_name" type="text" id="metatitle_field_name" class="metatitle_field_name" value="<?php echo !empty($get_metatitle) ? $get_metatitle : ''; ?>" class="regular-text">
								<p class="description" id="meta-title-description"><?php echo __('Google typically displays the first 50–60 characters of a title tag. If you keep your titles under 60 characters, our research suggests that you can expect about 90% of your titles to display properly.'); ?></p>
							</td>
						</tr>
						<tr>
							<th scope="row"><?php echo __('Meta Keyword'); ?></th>
							<td><input name="keyword_field_name" type="text" id="keyword_field_name" value="<?php echo !empty ($get_keyword) ? $get_keyword : ''; ?>" class="regular-text"></td>
						</tr>
						<tr>
							<th scope="row"><?php echo __('Meta Description'); ?></th>
							<td><textarea name="metades_field_name" rows="6" cols="150" class="metades_field_name"><?php echo !empty($get_metades) ? $get_metades : '' ; ?></textarea>
							<p class="description" id="meta-description"><?php echo __(
							"Meta descriptions can be any length, but search engines generally truncate snippets longer than 160 characters. It's best to keep meta descriptions long enough that they're sufficiently descriptive, but shorter than the 160-character limit."); ?></p>
							</td>
						</tr>
                        <tr>
                            <th scope="row"><?php echo __('Canonical URL'); ?></th>
                            <td>
                                <input name="canonical_url_field_name" type="text" id="canonical_url_field_name" value="<?php echo !empty($get_canonical)? $get_canonical : '' ; ?>" class="regular-text">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo __('Meta robots index'); ?></th>
                            <td>
								<?php $get_robots_index = !empty($get_robots_index)? $get_robots_index: ''; ?>
                                <select name="meta_robots_index" id="meta_robots_index">
                                    <option value="index" <?php echo ( $get_robots_index ) == 'index' ? 'selected' : ''; ?>>index</option>
                                    <option value="noindex" <?php echo ( $get_robots_index ) == 'noindex' ? 'selected' : ''; ?>>noindex</option>
                                </select>
								<p class="description" id="tagline-description"><?php echo __("<strong>Warning:</strong> even though you can set the meta robots setting here, the entire site is set to noindex in the sitewide privacy settings, so these settings won't have an effect."); ?></p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?php echo __('Meta robots follow'); ?></th>
                            <td>
								<?php $get_robots_follow = !empty($get_robots_follow)? $get_robots_follow: ''; ?>
                                <select name="meta_robots_follow" id="meta_robots_follow">
                                    <option value="follow" <?php echo ( $get_robots_follow ) == 'follow' ? 'selected' : ''; ?>>follow</option>
                                    <option value="nofollow" <?php echo ( $get_robots_follow ) == 'nofollow' ? 'selected' : ''; ?>>nofollow</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row"><?php echo __('Meta robots advanced'); ?></th>
                            <td>
                                <fieldset>
									<?php 
									$get_robots_noodp = !empty($get_robots_noodp)? $get_robots_noodp: ''; 
									$get_robots_noydir = !empty($get_robots_noydir)? $get_robots_noydir: ''; 
									?>
                                    <legend class="screen-reader-text"><span><?php echo __('Meta robots advanced'); ?></span></legend>
                                    <label for="comments_notify">
                                        <input name="meta_robots_noodp" type="checkbox" id="meta_robots_noodp" value="noodp" <?php echo ( $get_robots_noodp ) == 'noodp' ? 'checked' : ''; ?>>
                                        <?php echo __('Robots Meta NOODP'); ?>
                                    </label>
                                    <br>
                                    <label for="moderation_notify">
                                        <input name="meta_robots_noydir" type="checkbox" id="meta_robots_noydir" value="noydir" <?php echo ( $get_robots_noydir ) == 'noydir' ? 'checked' : ''; ?>>
                                        <?php echo __('Robots Meta NOYDIR'); ?>
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
					</tbody>
				</table>
                        <?php
                            if( isset($_GET["id"]) && !empty($_GET["id"])) {
                                echo '<input type="hidden" name="seo_hidden_update_id" id="seo_hidden_update_id" class="button button-primary" value="'.$custom_url_id.'">';
								echo '<input type="hidden" name="seo_update_siteURL" id="seo_update_siteURL" class="button button-primary" value="'.site_url('/').'">';
                                echo '<input type="hidden" name="seo_hidden_update_msg" id="seo_hidden_update_msg" class="button button-primary" value="url_update">';
                                echo '<p class="submit">';
                                    echo '<input type="submit" name="seo_update" id="seo_update" class="button button-primary" value="Update">';
                                echo '</p>';
                            } else {
								echo '<input type="hidden" name="seo_submit_msg" id="seo_submit_msg" class="button button-primary" value="url_submit">';
								echo '<input type="hidden" name="seo_siteURL" id="seo_siteURL" class="button button-primary" value="'.site_url('/').'">';
                                echo '<p class="submit">';
                                    echo '<input type="submit" name="seo_submit" id="seo_submit" class="button button-primary" value="Save Changes">';
                                echo '</p>';
                            }
                        ?>
			</form>
                <div class="wrap">
</div>
	</div>
<?php
}
function dus_url_redirect($id)
{
 	$addnew =  site_url('/wp-admin/admin.php?page=dynamic_url_seo_add_new&id='.$id.'&action=edit_url');
	print("<script>window.location.href='".$addnew."'</script>");
	die;
}

/*
 * Insert custom URL for SEO in database
 */
function dus_insert_custom_url( $url, $metatitle, $keyword, $metades, $canonical_url, $meta_robots_index, $meta_robots_follow, $meta_robots_noodp, $meta_robots_noydir) {
    
    global $wpdb;
    $insert_url = $wpdb->insert(
            $wpdb->prefix . 'dynamic_custom_url_seo', array(
        "url" => $url,
        "meta_title" => $metatitle,
        "meta_keyword" => $keyword,
        "meta_description" => $metades,
        "canonical_url" => $canonical_url,
        "meta_robots_index" => $meta_robots_index,
        "meta_robots_follow" => $meta_robots_follow,
        "meta_robots_noodp" => $meta_robots_noodp,
        "meta_robots_noydir" => $meta_robots_noydir ), array(
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s',
        '%s'
            )
    );
    if ( $insert_url > 0 ) {
        
        return $wpdb->insert_id;
    
    } else {
        
        return false;
        
    }
}

/*
 * Insert schema for SEO in database
 */
function dus_insert_schema( $schema_key, $schema_value ) 
{
    global $wpdb;
    $insert = $wpdb->insert(
            $wpdb->prefix . 'dynamic_custom_url_seo_schema', array(
        "schema_key" => $schema_key,
        "schema_value" => $schema_value ), array(
        '%s',
        '%s'
            )
    );
	
	
    if ( $insert > 0 ) {
        
        return $wpdb->insert_id;
    
    } else {
        
        return false;
        
    }
}


function dus_update_schema( $schema_key, $schema_value ) 
{
    global $wpdb;
    $custom_schema = $wpdb->prefix .'dynamic_custom_url_seo_schema';
	
    $update_schema = $wpdb->query( $wpdb->prepare( "
            UPDATE `$custom_schema`
            SET `schema_key` = %s,
            `schema_value` = %s
                WHERE `schema_key` = %s ",
            $schema_key,
            $schema_value,
			$schema_key

    ) );
    
    if( $update_schema ) {
        return true;
    }
    else {
        return false;
    }
}


function dus_get_schema( $schema_key ) 
{
	global $wpdb;
    $custom_schema = $wpdb->prefix . 'dynamic_custom_url_seo_schema'; // do not forget about tables prefix
	
	$get_schema = $wpdb->get_row ($wpdb->prepare("SELECT * FROM $custom_schema WHERE `schema_key` = %s", $schema_key));
	if(!empty($get_schema)) 
	{
		return esc_attr($get_schema->schema_value);
	}
}


function dus_get_single_schema_by_type( $schema_key ) 
{
	global $wpdb;
    $custom_schema = $wpdb->prefix . 'dynamic_custom_url_seo_schema'; // do not forget about tables prefix
	
	$get_schema = $wpdb->get_row ($wpdb->prepare("SELECT * FROM $custom_schema WHERE `schema_key` = %s", $schema_key));
	if(!empty($get_schema)) 
	{
		return esc_attr($get_schema->schema_value);
	}
}


function dus_check_id_already_exist_or_not( $id ) 
{
	global $wpdb;
    $custom_schema = $wpdb->prefix . 'dynamic_custom_url_seo'; // do not forget about tables prefix
	
	$get_schema = $wpdb->get_row ($wpdb->prepare("SELECT * FROM $custom_schema WHERE `id` = %d", $id));
	
	if(!empty($get_schema)) {
	     return true;
    }
    else {
        return false;
    }
}



/*
 * Update custom URL for SEO in database
 */
function dus_update_custom_url( $url, $metatitle, $keyword, $metades, $canonical_url, $meta_robots_index, $meta_robots_follow, $meta_robots_noodp, $meta_robots_noydir, $custom_url_id ) {
    
    global $wpdb;
    $table_name = $wpdb->prefix .'dynamic_custom_url_seo';											
												
	$update_url = $wpdb->query( $wpdb->prepare( "
            UPDATE `$table_name`
            SET `url` = %s,
			`meta_title` = %s,
			`meta_keyword` = %s,
			`meta_description` = %s,
			`canonical_url` = %s,
			`meta_robots_index` = %s,
			`meta_robots_follow` = %s,
			`meta_robots_noodp` = %s,
            `meta_robots_noydir` = %s
                WHERE `id` = %d ",
            $url,
            $metatitle,
			$keyword,
            $metades,
			$canonical_url,
			$meta_robots_index,
            $meta_robots_follow,
			$meta_robots_noodp,
            $meta_robots_noydir,
			$custom_url_id

    ) );
	
    if( $update_url ) {
        return true;
    }
    else {
        return false;
    }
}


function dus_single_url_delete_redirect()
{
	$redirect_url = site_url('/wp-admin/admin.php?page=dynamic_url_seo_listing_page&action=delete_url');
	print("<script>window.location.href='".$redirect_url."'</script>");
	die;
}

function dus_admin_init() {

    dus_check_current_url();
}
add_Action('init', 'dus_admin_init');


function dus_siteURL()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    return $protocol.$domainName;
}
if ( ! defined( 'DUS_SITE_URL' ) ) {
	define( 'DUS_SITE_URL', dus_siteURL() );
}


function dus_check_current_url() 
{

	if( !function_exists('is_plugin_active') ) {
		
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
	}
    global $wpdb;

    $dynamic_custom_url_seo = $wpdb->prefix . 'dynamic_custom_url_seo'; // do not forget about tables prefix
	    
    $current_url = DUS_SITE_URL.$_SERVER['REQUEST_URI'];
	$current_url = rtrim($current_url,"/");
    
    $result = $wpdb->get_row ( $wpdb->prepare ( "SELECT * FROM $dynamic_custom_url_seo WHERE url = %s", $current_url ) );
	
    global $metaTitle, $metaKeyword, $metaDes, $canonicalUrl, $metaRobotsIndex, $metaRobotsFollow, $metaRobotsNoodp, $metaRobotsNoydir;

    $metaTitle = !empty($result->meta_title) ? esc_attr($result->meta_title) : '';
    $metaKeyword = !empty($result->meta_keyword) ? esc_attr($result->meta_keyword) : '';
    $metaDes = !empty($result->meta_description) ? esc_attr($result->meta_description) : '';
    $canonicalUrl = !empty($result->canonical_url) ? esc_attr($result->canonical_url) : '';
    $metaRobotsIndex = !empty($result->meta_robots_index) ? esc_attr($result->meta_robots_index) : '';
    $metaRobotsFollow = !empty($result->meta_robots_follow) ? esc_attr($result->meta_robots_follow) : '';
    $metaRobotsNoodp = !empty($result->meta_robots_noodp) ? esc_attr($result->meta_robots_noodp) : '';
    $metaRobotsNoydir = !empty($result->meta_robots_noodp) ? esc_attr($result->meta_robots_noydir) : '';
        
        /**
         * Prints the generated metadata for the head area.
         */
        function dus_print_head_block() {

            global $metaTitle, $metaKeyword, $metaDes, $canonicalUrl, $metaRobotsIndex, $metaRobotsFollow, $metaRobotsNoodp, $metaRobotsNoodp, $metaRobotsNoydir;
            
            $metaDes_array = '';
            $metaKeyword_array = '';
            $canonical_array = '';
            $robots_array = ''; 
            $robotsIndex = '';
            $robotsFollow = '';
            $robotsNoodp = '';
            $robotsNoydir = '';
            $current_url = DUS_SITE_URL.$_SERVER['REQUEST_URI'];
            $postid = url_to_postid( $current_url );
			
			
			$website_name = (dus_get_single_schema_by_type('-website_name'));
			$website_name = ! empty( $website_name) ? '"name": "'.dus_get_single_schema_by_type('-website_name').'"' : '';
			$website_alt_name = (dus_get_single_schema_by_type('-website_alt_name'));
			$website_alt_name = ! empty( $website_alt_name) ? '"alternateName": "'.dus_get_single_schema_by_type('-website_alt_name').'"' : '';
			$website_url = (dus_get_single_schema_by_type('-website_url'));
			$website_url = ! empty( $website_url) ? '"url": "'.dus_get_single_schema_by_type('-website_url').'"' : '';
			
			$website_schema_array = array($website_name, $website_alt_name, $website_url);
			$website_schema_array = array_filter($website_schema_array);
			$website_schema_array = implode(',', $website_schema_array);
			
			
			$org_name = (dus_get_single_schema_by_type('-org_name'));
			$org_name = ! empty( $org_name) ? '"name": "'.dus_get_single_schema_by_type('-org_name').'"' : '';
			$org_website_url = (dus_get_single_schema_by_type('-org_website_url'));
			$org_website_url = ! empty( $org_website_url) ? '"url": "'.dus_get_single_schema_by_type('-org_website_url').'"' : '';
			$org_logo = (dus_get_single_schema_by_type('-org_logo'));
			$org_logo = ! empty( $org_logo) ? '"image": "'.dus_get_single_schema_by_type('-org_logo').'"' : '';
			
			$org_address = (dus_get_single_schema_by_type('-org_address'));
			$org_address = ! empty( $org_address) ? '"streetAddress": "'.dus_get_single_schema_by_type('-org_address').'"' : '';
			$org_city = (dus_get_single_schema_by_type('-org_city'));
			$org_city = ! empty( $org_city) ? '"addressLocality": "'.dus_get_single_schema_by_type('-org_city').'"' : '';
			$org_state = (dus_get_single_schema_by_type('-org_state'));
			$org_state = ! empty( $org_state) ? '"addressRegion": "'.dus_get_single_schema_by_type('-org_state').'"' : '';
			$org_zip_code = (dus_get_single_schema_by_type('-org_zip_code'));
			$org_zip_code = ! empty( $org_zip_code) ? '"postalCode": "'.dus_get_single_schema_by_type('-org_zip_code').'"' : '';
			$org_country = (dus_get_single_schema_by_type('-org_country'));
			$org_country = ! empty( $org_country) ? '"addressCountry": "'.dus_get_single_schema_by_type('-org_country').'"' : '';
			
			$org_full_address = array($org_address, $org_city, $org_state, $org_zip_code, $org_country);
			$org_full_address = array_filter($org_full_address);
			$org_full_address = implode(',', $org_full_address);
			
			$org_add = '';
			//if(dus_get_single_schema_by_type('-org_address') != '' || !empty(dus_get_single_schema_by_type('-org_city')) || !empty(dus_get_single_schema_by_type('-org_state')) || !empty(dus_get_single_schema_by_type('-org_zip_code')) || !empty(dus_get_single_schema_by_type('-org_country'))) 
			if(dus_get_single_schema_by_type('-org_address') != '' || dus_get_single_schema_by_type('-org_city') != '' || dus_get_single_schema_by_type('-org_state') != '' || dus_get_single_schema_by_type('-org_zip_code') != '' || dus_get_single_schema_by_type('-org_country') != '') 
			{
				$org_add = '"address": { "@type": "PostalAddress", '.$org_full_address.' }';
				
			}
			
			$org_latitude = (dus_get_single_schema_by_type('-org_latitude'));
			$org_latitude = ! empty( $org_latitude) ? '"latitude": "'.dus_get_single_schema_by_type('-org_latitude').'"' : '';
			$org_longitude = (dus_get_single_schema_by_type('-org_longitude'));
			$org_longitude = ! empty( $org_longitude) ? '"longitude": "'.dus_get_single_schema_by_type('-org_longitude').'"' : '';
			
			
			$organization_lat_long = array($org_latitude, $org_longitude);
			$organization_lat_long = array_filter($organization_lat_long);
			$organization_lat_long = implode(',', $organization_lat_long);
			
			$org_lat_long = '';
			//if(!empty(dus_get_single_schema_by_type('-org_latitude')) || !empty(dus_get_single_schema_by_type('-org_longitude'))) 
			if(dus_get_single_schema_by_type('-org_latitude') != '' || dus_get_single_schema_by_type('-org_longitude') != '')
			{
				$org_lat_long = '"geo": { "@type": "GeoCoordinates", '.$organization_lat_long.' }';
			}
			
			$org_phone_number = (dus_get_single_schema_by_type('-org_phone_number'));
			$org_phone_number = ! empty( $org_phone_number) ? '"telephone": "'.dus_get_single_schema_by_type('-org_phone_number').'"' : '';
			$org_contact_type = (dus_get_single_schema_by_type('-org_contact_type'));
			$org_contact_type = ! empty( $org_contact_type) ? '"contactType": "'.dus_get_single_schema_by_type('-org_contact_type').'"' : '';
			
			$organization_full_contact = array($org_phone_number, $org_contact_type);
			$organization_full_contact = array_filter($organization_full_contact);
			$organization_full_contact = implode(',', $organization_full_contact);
			
			$org_full_contact = '';
			//if(!empty(dus_get_single_schema_by_type('-org_phone_number')) || !empty(dus_get_single_schema_by_type('-org_contact_type')))
			if(dus_get_single_schema_by_type('-org_phone_number') != '' || dus_get_single_schema_by_type('-org_contact_type') != '')
			{
				$org_full_contact = '"contactPoint": { "@type": "ContactPoint", '.$organization_full_contact.' }';
			}
			
			$organization_schema_array = array($org_name, $org_website_url, $org_logo, $org_add, $org_lat_long, $org_full_contact);
			$organization_schema_array = array_filter($organization_schema_array);
			$organization_schema_array = implode(',', $organization_schema_array);
 
 
			$lb_type = (dus_get_single_schema_by_type('-org_location_type'));
			$lb_type = ! empty( $lb_type) ? '"@type": "'.dus_get_single_schema_by_type('-org_location_type').'"' : '';
			$lb_description = (dus_get_single_schema_by_type('-lb_description'));
			$lb_description = ! empty( $lb_description) ? '"description": "'.dus_get_single_schema_by_type('-lb_description').'"' : '';
			$lb_main_phone = (dus_get_single_schema_by_type('-org_main_number'));
			$lb_main_phone = ! empty( $lb_main_phone) ? '"telephone": "'.dus_get_single_schema_by_type('-org_main_number').'"' : '';
			
			
			$local_business_schema_array = array($lb_type, $org_name, $org_website_url, $lb_main_phone, $org_logo, $lb_description, $org_add, $org_lat_long, $org_full_contact);
			$local_business_schema_array = array_filter($local_business_schema_array);
			$local_business_schema_array = implode(',', $local_business_schema_array);
			

$check_org = dus_get_single_schema_by_type('-org_type');
			
if(!empty($website_schema_array)) {
	echo '<script type="application/ld+json"> 
	{
	  "@context": "http://www.schema.org",
	  "@type": "WebSite",
	  '.$website_schema_array.'
	}
	 </script>';
 }
 if(!empty($organization_schema_array) && $check_org == 'organization') {
	echo '<script type="application/ld+json"> 
	{
	  "@context": "http://www.schema.org",
	  "@type": "Organization",
	  '.$organization_schema_array.'
	}
	 </script>';	
 } else {
	if(!empty($local_business_schema_array)) {
		echo '<script type="application/ld+json"> 
		{
		  "@context": "http://www.schema.org",
		  '.$local_business_schema_array.'
		}
		 </script>';
	 }
 }
			
            if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) 
			{
				$wpseo_metadesc = get_post_meta( $postid, '_yoast_wpseo_metadesc', true );
				$aioseop_description = get_post_meta( $postid, '_aioseop_description', true );
				if(is_plugin_active( 'wordpress-seo/wp-seo.php' )) 
				{
					if(empty($wpseo_metadesc) && empty($aioseop_description)) 
					{
						$metaDes_array = !empty($metaDes) ? '<meta name="description" content="'.$metaDes.'" />' : '';
					}
				}
				elseif(is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ))
				{
					if(empty($wpseo_metadesc) && empty($aioseop_description)) 
					{
						$metaDes_array = !empty($metaDes) ? '<meta name="description" content="'.$metaDes.'" />' : '';
					}
				}
				else 
				{
					$metaDes_array = !empty($metaDes) ? '<meta name="description" content="'.$metaDes.'" />' : '';
				}
			} 
			else 
			{
				$metaDes_array = !empty($metaDes) ? '<meta name="description" content="'.$metaDes.'" />' : '';
			}
			
			
			
			if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) 
			{
				$wpseo_focuskw_text_input = get_post_meta( $postid, '_yoast_wpseo_focuskw_text_input', true );
				if(empty($wpseo_focuskw_text_input)) 
				{
					$metaKeyword_array = !empty($metaKeyword) ? '<meta name="keywords" content="'.$metaKeyword.'" />' : '';
				}
			} 
			else 
			{
				$metaKeyword_array = !empty($metaKeyword) ? '<meta name="keywords" content="'.$metaKeyword.'" />' : '';
			}
			
			
			if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) 
			{
				$wpseo_canonical = get_post_meta( $postid, '_yoast_wpseo_canonical', true );
				$aioseop_custom_link = get_post_meta( $postid, '_aioseop_custom_link', true );
				if(is_plugin_active( 'wordpress-seo/wp-seo.php' )) 
				{
					if(empty($wpseo_canonical) || empty($aioseop_custom_link)) 
					{
						$canonical_array = !empty($canonicalUrl) ? '<link rel="canonical" href="'.$canonicalUrl.'" />' : '';
					}
				}
				elseif(is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ))
				{
					if(empty($wpseo_canonical) || empty($aioseop_custom_link))
					{
						$canonical_array = !empty($canonicalUrl) ? '<link rel="canonical" href="'.$canonicalUrl.'" />' : '';
					}
				}
				else 
				{
					$canonical_array = !empty($canonicalUrl) ? '<link rel="canonical" href="'.$canonicalUrl.'" />' : '';
				}
			} 
			else 
			{
				$canonical_array = !empty($canonicalUrl) ? '<link rel="canonical" href="'.$canonicalUrl.'" />' : '';
			}
			
			
			if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) 
			{
				$wpseo_meta_robots_noindex = get_post_meta( $postid, '_yoast_wpseo_meta-robots-noindex', true );
				$aioseop_noindex = get_post_meta( $postid, '_aioseop_noindex', true );
				if(is_plugin_active( 'wordpress-seo/wp-seo.php' )) 
				{
					if(empty($wpseo_meta_robots_noindex) || empty($aioseop_noindex)) 
					{
						$robotsIndex = !empty($metaRobotsIndex) ? $metaRobotsIndex : '';
					}
				}
				elseif(is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ))
				{
					if(empty($wpseo_meta_robots_noindex) || empty($aioseop_noindex)) 
					{
						$robotsIndex = !empty($metaRobotsIndex) ? $metaRobotsIndex : '';
					}
				}
				else 
				{
					$robotsIndex = !empty($metaRobotsIndex) ? $metaRobotsIndex : '';
				}
			} 
			else 
			{
				$robotsIndex = !empty($metaRobotsIndex) ? $metaRobotsIndex : '';
			}
			
			
			
			if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) 
			{
				$wpseo_meta_robots_nofollow = get_post_meta( $postid, '_yoast_wpseo_meta-robots-nofollow', true );
				$aioseop_nofollow = get_post_meta( $postid, '_aioseop_nofollow', true );
				if(is_plugin_active( 'wordpress-seo/wp-seo.php' )) 
				{
					if(empty($wpseo_meta_robots_nofollow) || empty($aioseop_nofollow)) 
					{
						$robotsFollow = !empty($metaRobotsFollow) ? $metaRobotsFollow : '';
					}
				}
				elseif(is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ))
				{
					if(empty($wpseo_meta_robots_nofollow) || empty($aioseop_nofollow)) 
					{
						$robotsFollow = !empty($metaRobotsFollow) ? $metaRobotsFollow : '';
					}
				}
				else 
				{
					$robotsFollow = !empty($metaRobotsFollow) ? $metaRobotsFollow : '';
				}
			} 
			else 
			{
				$robotsFollow = !empty($metaRobotsFollow) ? $metaRobotsFollow : '';
			}
            
            
			
			if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) || is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) 
			{
				$wpseo_meta_robots_adv = get_post_meta( $postid, '_yoast_wpseo_meta-robots-adv', true );
				$aioseop_noodp = get_post_meta( $postid, '_aioseop_noodp', true );
				if(is_plugin_active( 'wordpress-seo/wp-seo.php' )) 
				{
					if(empty($wpseo_meta_robots_adv) || empty($aioseop_noodp)) 
					{
						$robotsNoodp = !empty($metaRobotsNoodp) ? $metaRobotsNoodp : '';
					}
				}
				elseif(is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ))
				{
					if(empty($wpseo_meta_robots_adv) || empty($aioseop_noodp)) 
					{
						$robotsNoodp = !empty($metaRobotsNoodp) ? $metaRobotsNoodp : '';
					}
				}
				else 
				{
					$robotsNoodp = !empty($metaRobotsNoodp) ? $metaRobotsNoodp : '';
				}
			} 
			else 
			{
				$robotsNoodp = !empty($metaRobotsNoodp) ? $metaRobotsNoodp : '';
			}
			
			
			
			if ( is_plugin_active( 'all-in-one-seo-pack/all_in_one_seo_pack.php' ) ) 
			{
				$aioseop_noydir = get_post_meta( $postid, '_aioseop_noydir', true );
				if(empty($aioseop_noydir)) 
				{
					$robotsNoydir = !empty($metaRobotsNoydir) ? $metaRobotsNoydir : '';
				}
			} 
			else 
			{
				$robotsNoydir = !empty($metaRobotsNoydir) ? $metaRobotsNoydir : '';
			}
			
			if( esc_attr( get_option( 'blog_public' ) ) == 1 ) 
			{
				$robots_array = array($robotsIndex, $robotsFollow, $robotsNoodp, $robotsNoydir);
				$robots_array = array_filter($robots_array);
				$robots_array = implode(',', $robots_array);
				$robots_array = !empty($robots_array) ? '<meta name="robots" content="'.$robots_array.'" />' : '';
			}
			
			if(!is_404()) 
			{
				if(!empty($metaKeyword_array) || !empty($metaDes_array) || !empty($canonical_array) || !empty($robots_array)) {
					$metadata_block_head = array('<!-- BEGIN Metadata added by the Dynamic URL SEO - Brainvire -->',
												$metaKeyword_array,
												$metaDes_array,
												$canonical_array,
												$robots_array,
												'<!-- END Metadata added by the Dynamic URL SEO - Brainvire -->');
					$metadata_block_head = array_filter($metadata_block_head);
					// Print the metadata block
					echo PHP_EOL . implode( PHP_EOL, $metadata_block_head ) . PHP_EOL . PHP_EOL;
				}
			}
        }
        add_action('wp_head', 'dus_print_head_block', 2); 


        /**
         * Main title function.
         */
        function dus_print_title_head_block($metaTitle) {
            global $metaTitle;
            return $metaTitle;
        }
        add_filter( 'pre_get_document_title', 'dus_print_title_head_block', 15 );
        add_filter( 'wp_title', 'dus_print_title_head_block', 15, 3 );
}


/* Misc */

add_action( 'dus_admin_notices', 'dus_admin_updated_message' );

function dus_admin_updated_message() {
    if ( empty( $_REQUEST['seo_hidden_update_msg'] ) ) {
        return;
    }

    if ( 'url_update' == $_REQUEST['seo_hidden_update_msg'] ) {
        $updated_message = __( "Update succesfully.", 'dynamic-url-seo' );
    }

    if ( ! empty( $updated_message ) ) {
        echo sprintf( '<div id="message" class="updated notice notice-success is-dismissible"><p>%s</p></div>', esc_html( $updated_message ) );
        return;
    }
}