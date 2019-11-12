<?php

class TRP_SP_Slug_Manager {

    protected $settings;
    protected $translated_slug_meta = '_trp_translated_slug_';
    protected $url_converter;
	protected $translation_manager;

    public function __construct( $settings ){
        $this->settings = $settings;

        $trp = TRP_Translate_Press::get_trp_instance();
        $this->url_converter = $trp->get_component( 'url_converter' );
    }

	/**
	 * Echo page slug as meta tag in preview window.
	 *
	 * Hooked to wp_head
	 */
	public function add_slug_as_meta_tag() {
		if ( isset( $_REQUEST['trp-edit-translation'] ) && ( $_REQUEST['trp-edit-translation'] === 'preview' ) ) {
			global $post;
			$trp = TRP_Translate_Press::get_trp_instance();
			if ( ! $this->translation_manager ) {
				$this->translation_manager = $trp->get_component( 'translation_manager' );
			}
			if ( method_exists ( $this->translation_manager, 'string_groups' ) ) {
				$string_groups = $this->translation_manager->string_groups();
				if ( isset( $post->ID ) && ! empty( $post->ID ) && isset( $post->post_name ) && ! empty( $post->post_name ) && ! is_home() && ! is_front_page() && ! is_archive() && ! is_search() ) {
					echo '<meta data-trp-post-slug=' . (int) $post->ID . ' data-trp-node-type="' . esc_attr( $string_groups['slugs'] ) . '" data-trp-node-description="' . esc_attr__( 'Post Slug', 'translatepress-multilingual' ) . '"/>' . "\n";
				}
			}
		}
	}

	/*
	 * Not used in TP
	 */
    public function get_translated_slug_filter( $original, $post_id, $language ){
        return $this->get_translated_slug( $post_id, $language );
    }

    /**
     * When we have the permalink structure set to postname we need an extra filter for pages with translated slugs. In this case
     * we need to change the slug of the page to the original one before the query in the get_page_by_path function. In this permalink setting
     * there is no difference between post links and page links so WP uses get_page_by_path in the parse_request function to determine if it is a page or not and if we don't
     * check the original slug it will think it is a post.
     * @param $title
     * @param $raw_title
     * @param $context
     * @return string
     */
    public function change_query_for_page_by_page_slug( $title, $raw_title, $context ){
        global $TRP_LANGUAGE;
        if( !empty($TRP_LANGUAGE) && $this->settings["default-language"] != $TRP_LANGUAGE ){
            if( !empty( $context ) && $context == 'query' ) {
                if (!empty($GLOBALS['wp_rewrite']->permalink_structure) && strpos($GLOBALS['wp_rewrite']->permalink_structure, '%postname%') !== false ) {
                    global $wp_current_filter;
                    if ( ( !empty($wp_current_filter[0]) && $wp_current_filter[0] == 'sanitize_title' ) || apply_filters( 'trp_seo_change_query_for_page_slug_condition', false ) ) {
                        $callstack_functions = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
                        $callstack_functions_functions = array();
                        foreach( $callstack_functions as $callstack_function ){
                            $callstack_functions_functions[] = $callstack_function['function'];
                        }
                        if ( in_array( 'get_page_by_path', $callstack_functions_functions ) ) {
                            $title = $this->get_original_slug($title, 'page');
                        }
                    }
                }
            }
        }

        return $title;
    }

    /**
     * Change the query_vars inside of a query if we find a translated slug in the database
     * This is needed for the url_to_post_id() function to return the correct ID for translated slugs.
     */
    public function change_slug_var_in_query( $query ){
        $new_query_vars = $this->change_slug_var_in_request( $query->query_vars );
        $query->query_vars = $new_query_vars;
        return $query;
    }

    /**
     * Change the query_vars if we find a translated slug in the database
     */
    public function change_slug_var_in_request( $query_vars ){
        global $TRP_LANGUAGE;
        if ( $query_vars == null ){
            return $query_vars;
        }

        if( !empty($TRP_LANGUAGE) && $this->settings["default-language"] != $TRP_LANGUAGE ){
            if (!empty($query_vars['name'])) {
                if (!empty($query_vars['post_type'])) {
                    /* we can have an hierarchical structure for post types */
                    $postnames = explode( '/', $query_vars['name'] );
                    $translated_postnames = array();
                    foreach( $postnames as $postname ){
                        $translated_postnames[] = $this->get_original_slug( $postname );
                    }
                    $query_vars['name'] = implode( '/', $translated_postnames );
                    $query_vars[$query_vars['post_type']] = implode( '/', $translated_postnames );
                } else {
                    $query_vars['name'] = $this->get_original_slug($query_vars['name']);
                }
            } else if (!empty($query_vars['pagename'])) {
                /* we can have an hierarchical structure for pages */
                $translated_pagenames = array();
                $pagenames = explode( '/', $query_vars['pagename'] );
                foreach ( $pagenames as $pagename ){
                    $translated_pagenames[] = $this->get_original_slug( $pagename );
                }
                $query_vars['pagename'] = implode( '/', $translated_pagenames );
                //we need to set this for pages because the default is for posts and if it is not set it won't return results
                $callstack_functions = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
                $callstack_functions_functions = array();
                foreach( $callstack_functions as $callstack_function ){
                    $callstack_functions_functions[] = $callstack_function['function'];
                }
                if ( in_array( 'get_url_for_language', $callstack_functions_functions ) ) {
                    $query_vars['post_type'] = 'page';
                }
            }
        }

        return $query_vars;
    }

    /* change the slug in permalinks for posts and post types */
    public function translate_slug_for_posts( $permalink, $post, $leavename ){
        if( $post->post_parent == 0 ){
            $translated_slug = $this->get_translated_slug( $post );
            if( !empty( $translated_slug ) ){
                // we're adding a slash in case the actual permalink doesn't have one and fails the replace
                $permalink = str_replace('/'.$post->post_name.'/', '/'.$translated_slug.'/', $permalink . '/' );
                return substr( $permalink, 0, -1 );
            }
        }
        else{
            $posts_hierarchy = get_post_ancestors( $post->ID );
            $posts_hierarchy[] = $post->ID;
            foreach( $posts_hierarchy as $post_id ){
                $translated_slug = $this->get_translated_slug( $post_id );
                if( !empty( $translated_slug ) ){
                    $post_object = get_post( $post_id );
                    // we're adding a slash in case the actual permalink doesn't have one and fails the replace
                    $permalink = str_replace('/'.$post_object->post_name.'/', '/'.$translated_slug.'/', $permalink . '/' );
                    return substr( $permalink, 0, -1 );
                }
            }
        }

        return $permalink;
    }

    /* change the slug for pages in permalinks */
    public function translate_slugs_for_pages( $uri, $page ){
        global $TRP_LANGUAGE;
        if( !empty($TRP_LANGUAGE) && $this->settings["default-language"] == $TRP_LANGUAGE )
            return $uri;

        $old_uri = $uri;
        if( strpos( $uri, '/' ) === false ){//means we do not have any page ancestors in the link so proceed
            $uri = $this->get_translated_slug( $page );
        }
        else{
            $uri_parts = explode( '/', $uri );
            $page_ancestors = array_reverse( get_post_ancestors( $page->ID ) );//this returns an array of ancestors the first element in the array is the closest ancestor so we need it reversed
            $translated_uri_parts = array();
            if( !empty( $uri_parts ) && !empty( $page_ancestors ) ) {
                foreach ($uri_parts as $key => $uri_part) {
                    if( !empty( $page_ancestors[$key] ) )
                        $translated_slug = $this->get_translated_slug($page_ancestors[$key]);
                    else
                        $translated_slug = $this->get_translated_slug($page);

                    if (!empty($translated_slug))
                        $translated_uri_parts[] = $translated_slug;
                    else
                        $translated_uri_parts[] = $uri_part;
                }

                if (!empty($translated_uri_parts))
                    $uri = implode('/', $translated_uri_parts);
            }
        }
        if ( empty ( $uri ) ){
            $uri = $old_uri;
        }

        return $uri;
    }

    /**
     * Function that redirects the url to the url with the translated slug so you can't access the original url
     */
    public function redirect_to_translated_slug(){
        global $post;
        if( !empty( $post->ID ) ){
            $translated_slug = $this->get_translated_slug( $post->ID );
            if( !empty( $translated_slug ) ){
                // treats URL's like: something.com/my-slug/
                $location = str_replace('/'.$post->post_name.'/', '/'.$translated_slug.'/', $this->url_converter->cur_page_url() );
                if( $location != $this->url_converter->cur_page_url() ) {
                    wp_redirect($location, 301);
                    exit;
                }

                // treats URL's like something.com/my-slug?param=no
                $location = str_replace('/'.$post->post_name.'?', '/'.$translated_slug.'?', $this->url_converter->cur_page_url() );
                if( $location != $this->url_converter->cur_page_url() ) {
                    wp_redirect($location, 301);
                    exit;
                }

                // treats URL's like something.com/my-slug    -   aka no trailingslash
                $location = str_replace('/'.$post->post_name.'TRPURLEND', '/'.$translated_slug.'TRPURLEND', $this->url_converter->cur_page_url() . 'TRPURLEND' );
                if( $location != $this->url_converter->cur_page_url().'TRPURLEND' ) {
                    wp_redirect( str_replace('TRPURLEND', '', $location ), 301 );
                    exit;
                }

            }
        }
    }

    /**
     * @param $post the post object or post id
     * @param string $language optional parameter for language. if it's not present it will grab it from the $TRP_LANGUAGE global
     * @return mixed|string an empty string or the translated slug
     */
    public function get_translated_slug( $post, $language = null ){
        if( $language == null ){
            global $TRP_LANGUAGE;
            if( !empty( $TRP_LANGUAGE ) )
                $language = $TRP_LANGUAGE;
        }

        if( is_object( $post ) )
            $post = $post->ID;

        $translated_slug = get_post_meta( $post, $this->translated_slug_meta.$language, true );
        if( !empty( $translated_slug ) )
            return $translated_slug;
        else
            return '';
    }

    /**
     * @param $slug the translated slug
     * @return string the original slug if we can find it
     */
    protected function get_original_slug( $slug, $post_type = '' ){
        global $TRP_LANGUAGE, $wpdb;

        if( !empty( $TRP_LANGUAGE ) ){

            $translated_slug = $wpdb->get_results($wpdb->prepare(
                "
                SELECT * 
                FROM $wpdb->postmeta
                WHERE meta_key = '%s' 
                    AND meta_value = '%s'
                ", $this->translated_slug_meta.$TRP_LANGUAGE, $slug
            ) );

            if( !empty( $translated_slug ) ){
                $post_id = $translated_slug[0]->post_id;
                if( empty( $post_type ) ){
                    $post = get_post( $post_id );
                    if( !empty( $post ) )
                        $slug = $post->post_name;
                }
                elseif( $post_type == 'page' ){
                    if( get_post_type( $post_id ) == 'page' ){
                        $post = get_post( $post_id );
                        if( !empty( $post ) )
                            $slug = $post->post_name;
                    }
                }
            }
        }

        return $slug;
    }


    /**
     * Function on trp_translated_strings to save the slug translation.
     * Runs on every translated page. It's used to save the page slug from google translate into the proper slug meta
     */
    public function save_machine_translated_slug($translateable_information, $translated_strings, $language_code){

        if( !apply_filters('trp_machine_translate_slug', false)){
            return;
        }

        foreach($translateable_information['nodes'] as $key => $value){
            if ($value['type'] == 'post_slug'){
                $post_id = $value['node']->attr['post-id'];

                $translated_slug = $translated_strings[$key];

                if(!empty($post_id) && is_numeric($post_id)){

                    if( get_post_meta($post_id, $this->translated_slug_meta.$language_code, true) ){
                        return;
                    }
                    $post = get_post($post_id);
                    if( is_object($post)){
                        $translated_slug = sanitize_title_with_dashes( wp_unique_post_slug($translated_slug, $post_id, $post->post_status, $post->post_type, $post->post_parent) );
                        update_post_meta( $post_id, $this->translated_slug_meta.$language_code, $translated_slug );
                        return;
                    }
                }

            }
        }

    }
}