<?php

class TRP_Seo_Pack{

    protected $loader;
    protected $slug_manager;
    protected $settings;
    protected $url_converter;
    /* @var TRP_Editor_Api_Slugs */
    protected $editor_api_post_slug;

    public function __construct() {

    	// This is needed in the TP core version to show message if Seo Pack needs update
    	define( 'TRP_SP_PLUGIN_VERSION', '1.1.6' );

        define( 'TRP_SP_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        define( 'TRP_SP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

        require_once TRP_SP_PLUGIN_DIR . 'includes/class-slug-manager.php';
        require_once TRP_SP_PLUGIN_DIR . 'includes/class-editor-api-post-slug.php';

        $trp = TRP_Translate_Press::get_trp_instance();
        $this->loader = $trp->get_component( 'loader' );
        $this->url_converter =  $trp->get_component( 'url_converter' );
        $trp_settings = $trp->get_component( 'settings' );
        $this->settings = $trp_settings->get_settings();


        $this->slug_manager = new TRP_SP_Slug_Manager( $this->settings );
        $this->editor_api_post_slug = new TRP_Editor_Api_Post_Slug( $this->settings, $this->slug_manager );

        $this->loader->add_filter( 'trp_node_accessors', $this, 'add_seo_node_accessor_details', 10, 1 );

        // not used in TP
	    $this->loader->add_filter( 'trp_translate_slug', $this->slug_manager, 'get_translated_slug_filter', 10, 3 );

	    $this->loader->add_action( 'wp_head', $this->slug_manager, 'add_slug_as_meta_tag', 1 );
        $this->loader->add_filter( 'request', $this->slug_manager, 'change_slug_var_in_request' );
        $this->loader->add_filter( 'pre_get_posts', $this->slug_manager, 'change_slug_var_in_query' );

        $this->loader->add_filter( 'sanitize_title', $this->slug_manager, 'change_query_for_page_by_page_slug', 10, 3 );
        $this->loader->add_filter( 'post_link', $this->slug_manager, 'translate_slug_for_posts', 10, 3 );
        $this->loader->add_filter( 'post_type_link', $this->slug_manager, 'translate_slug_for_posts', 10, 3 );
        $this->loader->add_filter( 'get_page_uri', $this->slug_manager, 'translate_slugs_for_pages', 10, 2 );
        $this->loader->add_action( 'trp_translateable_information', $this->slug_manager, 'save_machine_translated_slug', 10, 3 );

	    $this->loader->add_action( 'wp_ajax_trp_get_translations_postslug', $this->editor_api_post_slug, 'postslug_get_translations' );
	    $this->loader->add_action( 'wp_ajax_trp_save_translations_postslug', $this->editor_api_post_slug, 'postslug_save_translations' );

        $this->loader->add_filter( 'template_redirect', $this->slug_manager, 'redirect_to_translated_slug', 100, 2 );

        require_once(  TRP_SP_PLUGIN_DIR . 'includes/class-plugin-updater.php' );
        $this->plugin_updater = new TRP_SP_Plugin_Updater();        
        $this->loader->add_action( 'admin_init', $this->plugin_updater, 'activate_license' );
        $this->loader->add_action( 'admin_init', $this->plugin_updater, 'deactivate_license' );
        $this->loader->add_action( 'admin_notices', $this->plugin_updater, 'admin_notices' );

        global $trp_license_page;
        if( !isset( $trp_license_page )  ) {
            $trp_license_page = new TRP_LICENSE_PAGE();
            $this->loader->add_action('admin_menu', $trp_license_page, 'license_menu');
            $this->loader->add_action( 'admin_init', $trp_license_page, 'register_option' );
        }

        // Yoast SEO Sitemap Support
        if ( !apply_filters('trp_disable_languages_in_yoast_sitemap', false)){
            $this->loader->add_action( 'pre_get_posts', $this, 'wpseo_init_sitemap', 1 );
            $this->loader->add_action( 'wpseo_sitemap_url', $this, 'wpseo_google_xml_sitemap_add_language_urls', 10, 2 );
            $this->loader->add_action( 'trp_subdirectory_for_default_language_info', $this, 'wpseo_notice_subdirectory_for_default_language');
            // clear sitemap when saving TP settings.
            $this->loader->add_filter( 'trp_extra_sanitize_settings', $this, 'wpseo_clear_sitemap', 10 );
        }
		
		//Pagebuilder by SiteOrigin compatibility
        $this->loader->add_filter( 'trp_seo_change_query_for_page_slug_condition', $this, 'page_builder_siteorigin_compatibility' );

    }

    public function wpseo_init_sitemap(){
        global $wp_query;
        if( !empty($wp_query) ){
            $type = get_query_var( 'sitemap', '' );
            add_filter( "wpseo_sitemap_{$type}_urlset",  array( $this, 'wpseo_urlset' ) );
        }
    }

    public function wpseo_urlset( $urlset ){
        $urlset = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" '
            . 'xmlns:xhtml="http://www.w3.org/1999/xhtml" '
            . 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd '
            . 'http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" '
            . 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        return $urlset;
    }

    public function wpseo_google_xml_sitemap_add_language_urls( $output, $url ){
        $date = null;

        if ( ! empty( $url['mod'] ) && class_exists("WPSEO_Sitemap_Timezone") ) {
            // Create a DateTime object date in the correct timezone.
            $timezone = new WPSEO_Sitemap_Timezone();
            $date = $timezone->format_date( $url['mod'] );
        }

        $trp = TRP_Translate_Press::get_trp_instance();
        $url_converter =  $trp->get_component( 'url_converter' );
        $settings = $this->settings;
        $languages = $settings['publish-languages'];

        $alternate = '';
        $other_lang_urls = array();

        foreach ( $languages as $language ) {
        	$add_language = apply_filters( 'trp_add_language_url_to_sitemap', true, $language, $url, $output );
        	if ( ! $add_language ){
        		continue;
	        }
            // hreflang should have - instead of _ . For example: en-EN, not en_EN like the locale
            $hreflang = str_replace('_', '-', $language);
            $alternate .= "\t\t\t<xhtml:link rel='alternate' hreflang='" . $hreflang . "' href='" . $url_converter->get_url_for_language( $language, $url["loc"] ) . "' />\n";

            if( $language != $settings['default-language']) {
                $lastmod = '';
                if (!empty( $date )){
                    $lastmod = "<lastmod>" . $date . "</lastmod>\n";
                }
                $other_lang_urls[] = "\n\t<url>\n\t\t\t<loc>" . $url_converter->get_url_for_language($language, $url["loc"]) . "</loc>\n\t\t\t" . $lastmod ;
            }
        }

        foreach ( $other_lang_urls as &$value){
            $value .= $alternate . "\t</url>\n";
        }
        $all_lang_urls = implode('', $other_lang_urls);

        $new_output = str_replace("</url>", $alternate . "\t</url>" . $all_lang_urls , $output);
        return apply_filters( 'trp_xml_sitemap_output_for_url', $new_output, $output, $settings, $alternate, $all_lang_urls );
    }

    public function wpseo_notice_subdirectory_for_default_language(){
        echo '<p class="description">';
        _e( 'The Yoast SEO Sitemaps will now contain the default language slug: example.com/en/sitemap_index.xml <br/> This works perfectly, just take it into account when you submit the sitemap to Google.', 'translatepress-multilingual' );
        echo "</p>";
    }

    static function wpseo_clear_sitemap($settings){
        global $wpdb;
        // delete all "yst_sm" transients
        $sql = "
            DELETE 
            FROM {$wpdb->options}
            WHERE option_name like '\_transient\_yst\_sm%'
            OR option_name like '\_transient\_timeout\_yst\_sm%'
        ";

        $wpdb->query($sql);
        return $settings;
    }

    /*Pagebuilder by SiteOrigin compatibility function. With Sidebars Emulator the global wp_current_filter changes in our
    change_query_for_page_by_page_slug function. the init and widgets_init hooks get added before sanitize_title for some reason. */
	function page_builder_siteorigin_compatibility( $bool ){
        if( class_exists( 'SiteOrigin_Panels_Sidebars_Emulator' ) ) {
            global $wp_current_filter;
            if( in_array( 'sanitize_title', $wp_current_filter ) )
                return true;
        }

        return $bool;
    }

    public function add_seo_node_accessor_details( $node_accessor_array ){
	    $node_accessor_array['image_alt'] = array(
		    'selector' => 'img[alt]',
		    'accessor' => 'alt',
		    'attribute' => true
	    );


	    $node_accessor_array['meta_desc'] = array(
		    'selector' => 'meta[name="description"],meta[property="og:title"],meta[property="og:description"],meta[property="og:site_name"],meta[name="twitter:title"],meta[name="twitter:description"]',
		    'accessor' => 'content',
		    'attribute' => true
	    );

	    $node_accessor_array['page_title'] = array(
		    'selector' => 'title',
		    'accessor' => 'innertext',
		    'attribute' => false
	    );

	    return $node_accessor_array;
    }
}