<?php
/**
 * WPSEO plugin file.
 *
 * @package WPSEO\XML_Sitemaps
 */

/**
 * Renders XML output for sitemaps.
 */
class WPSEO_Sitemaps_Renderer {

	/**
	 * XSL stylesheet for styling a sitemap for web browsers.
	 *
	 * @var string
	 */
	protected $stylesheet = '';

	/**
	 * Holds the get_bloginfo( 'charset' ) value to reuse for performance.
	 *
	 * @var string
	 */
	protected $charset = 'UTF-8';

	/**
	 * Holds charset of output, might be converted.
	 *
	 * @var string
	 */
	protected $output_charset = 'UTF-8';

	/**
	 * If data encoding needs to be converted for output.
	 *
	 * @var bool
	 */
	protected $needs_conversion = false;

	/**
	 * Timezone.
	 *
	 * @var WPSEO_Sitemap_Timezone
	 */
	protected $timezone;

	/**
	 * Set up object properties.
	 */
	public function __construct() {
		$stylesheet_url       = preg_replace( '/(^http[s]?:)/', '', $this->get_xsl_url() );
		$this->stylesheet     = '<?xml-stylesheet type="text/xsl" href="' . esc_url( $stylesheet_url ) . '"?>';
		$this->charset        = get_bloginfo( 'charset' );
		$this->output_charset = $this->charset;
		$this->timezone       = new WPSEO_Sitemap_Timezone();

		if (
			'UTF-8' !== $this->charset
			&& function_exists( 'mb_list_encodings' )
			&& in_array( $this->charset, mb_list_encodings(), true )
		) {
			$this->output_charset = 'UTF-8';
		}

		$this->needs_conversion = $this->output_charset !== $this->charset;
	}

	/**
	 * @param array $links Set of sitemaps index links.
	 *
	 * @return string
	 */
	public function get_index( $links ) {

		$xml = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

		foreach ( $links as $link ) {
			$xml .= $this->sitemap_index_url( $link );
		}

		/**
		 * Filter to append sitemaps to the index.
		 *
		 * @param string $index String to append to sitemaps index, defaults to empty.
		 */
		$xml .= apply_filters( 'wpseo_sitemap_index', '' );
		$xml .= '</sitemapindex>';

		return $xml;
	}

	/**
	 * @param array  $links        Set of sitemap links.
	 * @param string $type         Sitemap type.
	 * @param int    $current_page Current sitemap page number.
	 *
	 * @return string
	 */
	public function get_sitemap( $links, $type, $current_page ) {

		$urlset = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" '
			. 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd '
			. 'http://www.google.com/schemas/sitemap-image/1.1 http://www.google.com/schemas/sitemap-image/1.1/sitemap-image.xsd" '
			. 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="https://www.w3.org/1999/xhtml">' . "\n";

		/**
		 * Filters the `urlset` for a sitemap by type.
		 *
		 * @api string $urlset The output for the sitemap's `urlset`.
		 */


		$xml = apply_filters( "wpseo_sitemap_{$type}_urlset", $urlset );
		/*----------------------------- Delears page -----------------------------*/
		if($type == "author") {
			$links = array();
			$delears = $this->getUsersWithRole( array("stm_dealer") );
			foreach ($delears as $delear) {
				$links[] = $delear;
			}

		}
		/*----------------------------- Make page -----------------------------*/
		if($type == "make") {
			$links = array();
			$car_list = $this->get_cars_data_make("");
			$car_new_list = $this->get_cars_data_make("new");
			$car_used_list = $this->get_cars_data_make("used");
			$links = array_merge($links, $car_list, $car_new_list, $car_used_list);
			//special links
	    	$links[] = array("loc"=>$this->get_current_link("domain")."/inventory", 
	    					 "mod"=>date("Y-m-d h:i:s", time()) );
	    	$links[] = array("loc"=>$this->get_current_link("domain")."/inventory/?condition=used-cars", 
	    					 "mod"=>date("Y-m-d h:i:s", time()) );
	    	$links[] = array("loc"=>$this->get_current_link("domain")."/inventory/?condition=new-cars", 
	    					 "mod"=>date("Y-m-d h:i:s", time()) );
		}

		/*----------------------------- Serie pages -----------------------------*/
		if($type == "serie") {
			$links = array();
			$car_list = $this->get_cars_data("");
			$car_new_list = $this->get_cars_data("new");
			$car_used_list = $this->get_cars_data("used");
			$links = array_merge($links, $car_list, $car_new_list, $car_used_list);
		}

		foreach ( $links as $url ) {
			$xml .= $this->sitemap_url( $url, $type );
		}

		/**
		 * Filter to add extra URLs to the XML sitemap by type.
		 *
		 * Only runs for the first page, not on all.
		 *
		 * @param string $content String content to add, defaults to empty.
		 */
		if ( $current_page === 1 ) {
			$xml .= apply_filters( "wpseo_sitemap_{$type}_content", '' );
		}

		$xml .= '</urlset>';

		return $xml;
	}

	public function get_condition_param($type){
		if($type === "new") return "condition=new-cars&";
		if($type === "used") return "condition=used-cars&";
		return "";
	}

	public function get_add_def_params() {
		return 'min_price=0&max_price=2000000&stm_lat=0&stm_lng=0&max_search_radius=100&ajax_action=listings-result';
	}

	public function get_inventory_url($type){
		$condition = $this->get_condition_param($type);
		return site_url().'/inventory/?'.$condition;
	}

	public function get_xml_tag_data($link){
		return array("loc"=>$link, 
					 "mod"=>date("Y-m-d h:i:s", time())
					);
	}

	//for make pages
	public function get_cars_data_make($type) {
		$links = array();
		$base_url = $this->get_inventory_url($type);
	    $filter = $this->stm_mra_get_filter();
	    $make_list = $filter["make"];
	    while(list($make, $value) = each($make_list)){
	    	if( $value["count"] !== 0) {
	    		$link = urldecode($base_url."make=".$value["slug"]);
		    	$links[] = $this->get_xml_tag_data($link);
	    	}
	    }
	    return $links;
	}

	//for serie pages
	public function get_cars_data($type) {
		$links = array();
		$car_list = array();
		$base_url = $this->get_inventory_url($type);
		$filter = $this->stm_mra_get_filter();
	    $make_list = $filter["make"];
	    $serie_list = $filter["serie"];
	    $make_arr = array();

	    while(list($key, $value) = each($make_list)){
	    	if( $value["count"] > 0) {
	    		$make_arr[] = $value["slug"];
	    	}
	    }

	    foreach ($make_arr as $make) {
		    foreach($serie_list as $s_key => $s_val){
		    	if($s_val["parent"] === $make && $s_val["count"] > 0) {
		    		if( !$car_list[$s_val["parent"]] ) {
		    			$car_list[$s_val["parent"]] = array($s_val["slug"]);
		    		} else {
					    array_push($car_list[$s_val["parent"]], $s_val["slug"]);
		    		}
				}
			}
	    }

		while(list($make, $serie) = each($car_list)){
			foreach ($serie as $s) {
				$link = urldecode($base_url."make=".$make."&serie=".$s);
		    	$links[] = $this->get_xml_tag_data($link);  
			}
		}
	    return $links;
	}

	public function stm_mra_get_filter() {
	    $filterParams = explode( ',', get_option( 'filter_params', 'make,serie,ca-year,price' ) );

	    $forApp = array();

	    foreach ( $filterParams as $filter ) {
	        if ( $filter == 'search_radius' ) {
	            $forApp[$filter] = array(
	                'label' => 'Search radius',
	            );
	            continue;
	        }

	        $getTerms = get_terms( array( 'taxonomy' => $filter, 'hide_empty' => false, 'update_term_meta_cache' => false ) );

	        if ( $filter != 'price' && $filter != 'ca-year' ) {
	            $newFilter = array();
	            foreach ( $getTerms as $term ) {
	                $image = get_term_meta( $term->term_id, 'stm_image', true );
	                $image = wp_get_attachment_image_src( $image, 'stm-img-190-132' );
	                $category_image = $image[0];

	                if ( !$category_image ) {
	                    $plchldr_id = get_option( 'plchldr_attachment_id', 0 );
	                    $category_image = ( $plchldr_id == 0 ) ? STM_MOTORS_APP_URL . '/assets/img/car_plchldr.png' : wp_get_attachment_image_url( $plchldr_id );
	                }

	                if ( strpos( $category_image, 'motors.loc' ) ) {
	                    $category_image = stm_ma_replace_host( $category_image );
	                }

	                $newFilter[] = array(
	                    'label' => $term->name,
	                    'slug' => $term->slug,
	                    'count' => $term->count,
	                    'logo' => ( $category_image ) ? $category_image : '',
	                    'parent' => get_term_meta( $term->term_id, 'stm_parent', true )
	                );

	            }

	            $forApp[$filter] = $newFilter;
	        } else {
	            $newFilter = array();
	            foreach ( $getTerms as $term ) {
	                $newFilter[] = array(
	                    'label' => $term->name,
	                    'value' => $term->slug,
	                );

	            }

	            $filter = ( $filter == 'ca-year' ) ? 'year' : $filter;
	            if ( $filter == 'year' || $filter == 'price' ) {
	                asort( $newFilter );
	                $newFilter = array_values( $newFilter );
	            }
	            $forApp[$filter] = $newFilter;
	        }
	    }
	    return $forApp;
	}
	
	/**
	 * Produce final XML output with debug information.
	 *
	 * @param string  $sitemap   Sitemap XML.
	 * @param boolean $transient Transient cache flag.
	 *
	 * @return string
	 */
	public function get_output( $sitemap, $transient ) {

		$output = '<?xml version="1.0" encoding="' . esc_attr( $this->output_charset ) . '"?>';

		if ( $this->stylesheet ) {
			/**
			 * Filter the stylesheet URL for the XML sitemap.
			 *
			 * @param string $stylesheet Stylesheet URL.
			 */
			$output .= apply_filters( 'wpseo_stylesheet_url', $this->stylesheet ) . "\n";
		}

		$output .= $sitemap;
		$output .= "\n<!-- XML Sitemap generated by Yoast SEO -->";
		$output .= $this->get_debug( $transient );

		return $output;
	}

	/**
	 * Get charset for the output.
	 *
	 * @return string
	 */
	public function get_output_charset() {
		return $this->output_charset;
	}

	/**
	 * Set a custom stylesheet for this sitemap. Set to empty to just remove the default stylesheet.
	 *
	 * @param string $stylesheet Full XML-stylesheet declaration.
	 */
	public function set_stylesheet( $stylesheet ) {
		$this->stylesheet = $stylesheet;
	}

	/**
	 * Build the `<sitemap>` tag for a given URL.
	 *
	 * @param array $url Array of parts that make up this entry.
	 *
	 * @return string
	 */
	protected function sitemap_index_url( $url ) {

		$date = null;

		if ( ! empty( $url['lastmod'] ) ) {
			$date = $this->timezone->format_date( $url['lastmod'] );
		}

		$url['loc'] = htmlspecialchars( $url['loc'] );

		$output  = "\t<sitemap>\n";
		$output .= "\t\t<loc>" . $url['loc'] . "</loc>\n";
		$output .= empty( $date ) ? '' : "\t\t<lastmod>" . htmlspecialchars( $date ) . "</lastmod>\n";
		$output .= "\t</sitemap>\n";

		return $output;
	}

	public function set_priority($type) {
		$priority = array(
						  "page"     => 0.9, 
						  "post"     => 0.7,
						  "listings" => 0.8,
						  "author"   =>	0.7,
						  "make"     => 0.9,
						  "serie"    => 0.9
		);
		return $priority[$type];
	}

	public function get_hreflang($url) {
		$host = $this->get_current_link("domain");
		$clean_link = str_replace($host, "", $url);

		$lang_links = "\t\t<xhtml:link rel='alternate' hreflang='en' href='".$host.$clean_link."' />\n";
		$lang_links .= "\t\t<xhtml:link rel='alternate' hreflang='ar' href='".$host."/ar".$clean_link."' />\n";
		return $lang_links;
	}

	public function get_current_link($type) {
	    $base_url = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'];
	    if($type === "domain") return $base_url;
	    return $base_url . $_SERVER["REQUEST_URI"];
	}

	public function getUsersWithRole( $roles ) {
	    global $wpdb;
	    if ( ! is_array( $roles ) )
	        $roles = array_walk( explode( ",", $roles ), 'trim' );
	    $sql = '
	        SELECT  ID, display_name
	        FROM        ' . $wpdb->users . ' INNER JOIN ' . $wpdb->usermeta . '
	        ON          ' . $wpdb->users . '.ID             =       ' . $wpdb->usermeta . '.user_id
	        WHERE       ' . $wpdb->usermeta . '.meta_key        =       \'' . $wpdb->prefix . 'capabilities\'
	        AND     (
	    ';
	    $i = 1;
	    foreach ( $roles as $role ) {
	        $sql .= ' ' . $wpdb->usermeta . '.meta_value    LIKE    \'%"' . $role . '"%\' ';
	        if ( $i < count( $roles ) ) $sql .= ' OR ';
	        $i++;
	    }
	    $sql .= ' ) ';
	    $sql .= ' ORDER BY display_name ';
	    $userIDs = $wpdb->get_col( $sql );

	    foreach ( $userIDs as $id ) {
	    	$user = get_userdata($id);
	    	$u_mod = $user->user_registered;
	    	$u_login_name = strtolower($user->user_login);
	    	$u_link = $this->get_current_link("domain")."/author/".$u_login_name;
	    	$u_login[] = array("loc"=>$u_link, 
	    						"mod"=>$u_mod);
	    }

	    return $u_login;
	}

	/**
	 * Build the `<url>` tag for a given URL.
	 *
	 * Public access for backwards compatibility reasons.
	 *
	 * @param array $url Array of parts that make up this entry.
	 *
	 * @return string
	 */
	public function sitemap_url( $url, $type ) {
		
		$date = null;

		if ( ! empty( $url['mod'] ) ) {
			// Create a DateTime object date in the correct timezone.
			$date = $this->timezone->format_date( $url['mod'] );
		}

		$url['loc'] = htmlspecialchars( $url['loc'] );

		$output  = "\t<url>\n";
		$output .= "\t\t<loc>" . $this->encode_url_rfc3986( $url['loc'] ) . "</loc>\n";
		$output .= empty( $date ) ? '' : "\t\t<lastmod>" . htmlspecialchars( $date ) . "</lastmod>\n";
		$output .= "\t\t<priority>".$this->set_priority($type)."</priority>\n";
		$output .= $this->get_hreflang($url['loc']);


		if ( empty( $url['images'] ) ) {
			$url['images'] = array();
		}

		foreach ( $url['images'] as $img ) {

			if ( empty( $img['src'] ) ) {
				continue;
			}

			$output .= "\t\t<image:image>\n";
			$output .= "\t\t\t<image:loc>" . esc_html( $this->encode_url_rfc3986( $img['src'] ) ) . "</image:loc>\n";

			if ( ! empty( $img['title'] ) ) {

				$title = $img['title'];

				if ( $this->needs_conversion ) {
					$title = mb_convert_encoding( $title, $this->output_charset, $this->charset );
				}

				$title   = _wp_specialchars( html_entity_decode( $title, ENT_QUOTES, $this->output_charset ) );
				$output .= "\t\t\t<image:title><![CDATA[{$title}]]></image:title>\n";
			}

			if ( ! empty( $img['alt'] ) ) {

				$alt = $img['alt'];

				if ( $this->needs_conversion ) {
					$alt = mb_convert_encoding( $alt, $this->output_charset, $this->charset );
				}

				$alt     = _wp_specialchars( html_entity_decode( $alt, ENT_QUOTES, $this->output_charset ) );
				$output .= "\t\t\t<image:caption><![CDATA[{$alt}]]></image:caption>\n";
			}

			$output .= "\t\t</image:image>\n";
		}
		unset( $img, $title, $alt );

		$output .= "\t</url>\n";

		/**
		 * Filters the output for the sitemap URL tag.
		 *
		 * @api   string $output The output for the sitemap url tag.
		 *
		 * @param array $url The sitemap URL array on which the output is based.
		 */
		return apply_filters( 'wpseo_sitemap_url', $output, $url );
	}

	/**
	 * Apply some best effort conversion to comply with RFC3986.
	 *
	 * @param string $url URL to encode.
	 *
	 * @return string
	 */
	protected function encode_url_rfc3986( $url ) {

		if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
			return $url;
		}

		$path = wp_parse_url( $url, PHP_URL_PATH );

		if ( ! empty( $path ) && '/' !== $path ) {
			$encoded_path = explode( '/', $path );

			// First decode the path, to prevent double encoding.
			$encoded_path = array_map( 'rawurldecode', $encoded_path );

			$encoded_path = array_map( 'rawurlencode', $encoded_path );
			$encoded_path = implode( '/', $encoded_path );
			$encoded_path = str_replace( '%7E', '~', $encoded_path ); // PHP < 5.3.

			$url = str_replace( $path, $encoded_path, $url );
		}

		$query = wp_parse_url( $url, PHP_URL_QUERY );

		if ( ! empty( $query ) ) {

			parse_str( $query, $parsed_query );

			if ( defined( 'PHP_QUERY_RFC3986' ) ) { // PHP 5.4+.
				$parsed_query = http_build_query( $parsed_query, null, '&amp;', PHP_QUERY_RFC3986 );
			}
			else {
				$parsed_query = http_build_query( $parsed_query, null, '&amp;' );
				$parsed_query = str_replace( '+', '%20', $parsed_query );
				$parsed_query = str_replace( '%7E', '~', $parsed_query );
			}

			$url = str_replace( $query, $parsed_query, $url );
		}

		return $url;
	}

	/**
	 * Retrieves the XSL URL that should be used in the current environment
	 *
	 * When home_url and site_url are not the same, the home_url should be used.
	 * This is because the XSL needs to be served from the same domain, protocol and port
	 * as the XML file that is loading it.
	 *
	 * @return string The XSL URL that needs to be used.
	 */
	protected function get_xsl_url() {
		if ( home_url() !== site_url() ) {
			return home_url( 'main-sitemap.xsl' );
		}

		/*
		 * Fallback to circumvent a cross-domain security problem when the XLS file is
		 * loaded from a different (sub)domain.
		 */
		if ( strpos( plugins_url(), home_url() ) !== 0 ) {
			return home_url( 'main-sitemap.xsl' );
		}

		return plugin_dir_url( WPSEO_FILE ) . 'css/main-sitemap.xsl';
	}

	/**
	 * Adds debugging information to the output.
	 *
	 * @param bool $transient Transient cache was used or not.
	 *
	 * @return string Information about the functionality used to build the sitemap.
	 */
	protected function get_debug( $transient ) {
		$debug = defined( 'YOAST_SEO_DEBUG_SITEMAPS' ) && YOAST_SEO_DEBUG_SITEMAPS === true;
		if ( ! $debug ) {
			return '';
		}

		$memory_used = number_format( ( memory_get_peak_usage() / 1048576 ), 2 );
		$queries_run = ( $transient ) ? 'Served from transient cache' : 'Queries executed ' . absint( $GLOBALS['wpdb']->num_queries );

		$output = "\n<!-- {$memory_used}MB | {$queries_run} -->";

		if ( defined( 'SAVEQUERIES' ) && SAVEQUERIES ) {
			$queries = print_r( $GLOBALS['wpdb']->queries, true );
			$output .= "\n<!-- {$queries} -->";
		}

		return $output;
	}
}
