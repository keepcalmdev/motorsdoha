<?php

	// error_reporting(E_ALL);
	// ini_set("display_errors", 1);

    if(is_admin()) {
        require_once get_template_directory() . '/admin/admin.php';
		/* Phone Number Patch */
		require_once(get_template_directory() . '/inc/autoload.php');
    }

	define( 'STM_TEMPLATE_URI', get_template_directory_uri() );
	define( 'STM_TEMPLATE_DIR', get_template_directory() );
	define( 'STM_THEME_SLUG', 'stm' );
	define( 'STM_INC_PATH', get_template_directory() . '/inc' );
	define( 'STM_CUSTOMIZER_PATH', get_template_directory() . '/inc/customizer' );
	define( 'STM_CUSTOMIZER_URI', get_template_directory_uri() . '/inc/customizer' );


	wp_enqueue_style( 'phonevalid', get_template_directory_uri() . '/assets/css/intlTelInput.css', array(), '1.1', 'all');

	wp_enqueue_script( 'phonevalidscript', get_template_directory_uri() . '/assets/js/intlTelInput-jquery.min.js', array ( 'jquery' ), 1.1, true);


	//	Include path
	$inc_path = get_template_directory() . '/inc';

	//	Widgets path
	$widgets_path = get_template_directory() . '/inc/widgets';


	define('motors', 'motors');

		// Theme setups
		require_once STM_CUSTOMIZER_PATH . '/customizer.class.php';

        // Custom code and theme main setups
		require_once( $inc_path . '/setup.php' );

		// Enqueue scripts and styles for theme
		require_once( $inc_path . '/scripts_styles.php' );

        // Multiple Currency
        require_once( $inc_path . '/multiple_currencies.php' );

		// Custom code for any outputs modifying
		require_once( $inc_path . '/custom.php' );

		// Required plugins for theme
		require_once( $inc_path . '/tgm/tgm-plugin-registration.php' );

		// Visual composer custom modules
		if ( defined( 'WPB_VC_VERSION' ) ) {
			require_once( $inc_path . '/visual_composer.php' );
		}

		// Custom code for any outputs modifying with ajax relation
		require_once( $inc_path . '/stm-ajax.php' );

		// Custom code for filter output
		//require_once( $inc_path . '/listing-filter.php' );
		require_once( $inc_path . '/user-filter.php' );

		//User
		if(is_listing()) {
			require_once( $inc_path . '/user-extra.php' );
		}

		require_once( $inc_path . '/stm_single_dealer.php' );

		//email template manager
		require_once( $inc_path . '/email_template_manager/email_template_manager.php' );

		//value my car
        if(is_listing(array('listing_two', 'listing_three'))) require_once ($inc_path . '/value_my_car/value_my_car.php');

		// Custom code for woocommerce modifying
		if( class_exists( 'WooCommerce' ) ) {
		    require_once( $inc_path . '/woocommerce_setups.php' );
            if(stm_is_rental()) {
                require_once( $inc_path . '/woocommerce_setups_rental.php' );
            }

            if((get_theme_mod('dealer_pay_per_listing', false) || get_theme_mod('dealer_payments_for_featured_listing', false)) && is_listing()) {
                require_once $inc_path . '/perpay.php';
            }
		}

		if(class_exists('\\STM_GDPR\\STM_GDPR')) {
            if (stm_is_use_plugin('stm-gdpr-compliance/stm-gdpr-compliance.php')) {
                require_once($inc_path . '/motors-gdpr.php');
            }
        }



add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}


function change_menu($items){
  foreach($items as $item){
    if( $item->title == "Logout"){
         $item->url = $item->url . "&_wpnonce=" . wp_create_nonce( 'log-out' );
    }
  }
  return $items;

}
add_filter('wp_nav_menu_objects', 'change_menu');



add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result) {
    /**
     * Allow logout without confirmation
     */
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));;
        header("Location: $location");
        die;
    }
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'car/v1', '/marksold/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'mark_car_sold_api',
	));
});

function mark_car_sold_api(WP_REST_Request $request) {
	return update_post_meta($request->get_param('id'), 'car_mark_as_sold', 'on');
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'car/v1', '/unmarksold/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'unmark_car_sold_api',
	));
});

function unmark_car_sold_api(WP_REST_Request $request) {
	return delete_post_meta($request->get_param('id'), 'car_mark_as_sold', 'on');
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'car/v1', '/enable/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'car_enable_api',
	));
});

function car_enable_api(WP_REST_Request $request) {
	$car = $request->get_param('id');
    $status = get_post_status( $car );
    if ( $status == 'draft' ) {
        $enabled_car = array(
            'ID' => $car,
            'post_status' => 'publish'
        );

        wp_update_post( $enabled_car );
    }
	return true;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'car/v1', '/disable/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'car_disable_api',
	));
});

function car_disable_api(WP_REST_Request $request) {
	$car = $request->get_param('id');
    $status = get_post_status( $car );
    if ( $status == 'publish' ) {
        $disabled_car = array(
            'ID' => $car,
            'post_status' => 'draft'
        );

        wp_update_post( $disabled_car );
    }
	return true;
}


add_action( 'rest_api_init', function () {
	register_rest_route( 'car/v1', '/details/(?P<id>\d+)', array(
		'methods' => 'GET',
		'callback' => 'car_details_api',
	));
});

function car_details_api(WP_REST_Request $request) {
	$allDetails = get_post_meta($request->get_param('id'));
	unset($allDetails['gallery']);
	return $allDetails;
}



add_action( 'rest_api_init', function () {
	register_rest_route( 'car/v1', '/getcardetails', array(
		'methods' => 'GET',
		'callback' => 'getCarDetailsParams',
	));
});

function getCarDetailsParams(WP_REST_Request $request) {
    $ch = curl_init();
	
	$model = str_replace('-', '%20', str_replace(' ', '%20', $request->get_param('model')));
	$make = str_replace('-', '%20', str_replace(' ', '%20', $request->get_param('make')));
	if ($request->get_param('make') == 'mercedes-benz') {
		$make = str_replace(' ', '%20', $request->get_param('make'));
	}

    curl_setopt($ch, CURLOPT_URL, 'https://dohamotorsapi.azurewebsites.net/api/vehicles/getmodelinfo?make='.$make.'&year='.$request->get_param('year').'&model='.$model);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Accept: */*';
    $headers[] = 'Authorization: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6IjAiLCJuYmYiOjE1NzE5MDcxODYsImV4cCI6MTU3MjA3OTk4NiwiaWF0IjoxNTcxOTA3MTg2fQ.d6elIUJ0pfzHhuQcnyigoAVqxOqLDAXDxy-vvuZ10Uc';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        // echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return json_decode($result);
    // $contentcar = json_decode($result);
	// print_r($request);
	// die;
}


if(strpos($actual_link , 'http://qprcar01.kinsta.cloud/ar/qprlogin/?action=logout') !== false){


		add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
		function logout_without_confirm($action, $result)
		{
		    /**
		     * Allow logout without confirmation
		     */
		    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
		        $redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
		        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));;
		        header("Location: $location");
		        die;
		    }

		function change_menu($items){
		  foreach($items as $item){
		    if( $item->title == "Logout"){
		         $item->url = $item->url . "&_wpnonce=" . wp_create_nonce( 'log-out' );
		    }
		  }
		  return $items;

		}
		add_filter('wp_nav_menu_objects', 'change_menu');



		    
		}



}

// $filter = stm_listings_filter();
// echo var_export($filter, true);

//SEO snippets
function get_car_make() {
	global $wp_query;
    $post_id = $wp_query->get_queried_object_id();
	$data_meta = get_post_meta($post_id, 'make', true);
	$car_make = "";
	$filter = stm_listings_filter();
	$car_make = $filter["options"]["make"][$data_meta]["label"];
    return $car_make;
}

function get_car_model() {
	global $wp_query;
    $post_id = $wp_query->get_queried_object_id();
	$data_meta = get_post_meta($post_id, 'serie', true);
	$car_model = "";
	$filter = stm_listings_filter();
	$car_model = $filter["options"]["serie"][$data_meta]["label"];
    return $car_model;
}
function get_car_year() {
	global $wp_query;
    $post_id = $wp_query->get_queried_object_id();
	$data_meta = get_post_meta($post_id, 'ca-year', true);
    return ucfirst($data_meta);
}

function get_car_price() {
	global $wp_query;
    $post_id = $wp_query->get_queried_object_id();
	$data_meta = get_post_meta($post_id, 'price', true);
    return $data_meta;
}

function get_car_condition() {
	global $wp_query;
    $post_id = $wp_query->get_queried_object_id();
	$data_meta = get_post_meta($post_id, 'condition', true);
	$condition = "";
	if($data_meta == "new-cars"){
		$condition = "New";
	} else {
		$condition = "Used";
	}
    return $condition;
}
// define the action for register yoast_variable replacments
function register_custom_yoast_variables() {
    wpseo_register_var_replacement( '%%make%%', 'get_car_make', 'advanced', 'some help text' );
    wpseo_register_var_replacement( '%%model%%', 'get_car_model', 'advanced', 'some help text' );
    wpseo_register_var_replacement( '%%year%%', 'get_car_year', 'advanced', 'some help text' );
    wpseo_register_var_replacement( '%%price%%', 'get_car_price', 'advanced', 'some help text' );
    wpseo_register_var_replacement( '%%condition%%', 'get_car_condition', 'advanced', 'some help text' );
}

// Add action
add_action('wpseo_register_extra_replacements', 'register_custom_yoast_variables');





// override core function
if ( !function_exists('wp_authenticate') ) :
function wp_authenticate($username, $password) {
    $username = sanitize_user($username);
    $password = trim($password);

    $user = apply_filters('authenticate', null, $username, $password);

    if ( $user == null ) {
        // TODO what should the error message be? (Or would these even happen?)
        // Only needed if all authentication handlers fail to return anything.
        $user = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Invalid username or incorrect password.'));
    } elseif ( get_user_meta( $user->ID, 'has_to_be_activated', true ) != false ) {
        $user = new WP_Error('activation_failed', __('<strong>ERROR</strong>: User is not activated.'));
    }

    $ignore_codes = array('empty_username', 'empty_password');

    if (is_wp_error($user) && !in_array($user->get_error_code(), $ignore_codes) ) {
        do_action('wp_login_failed', $username);
    }

    return $user;
}
endif;




add_action( 'template_redirect', 'wpse8170_activate_user' );
function wpse8170_activate_user() {
    if ( is_page() && get_the_ID() == 3533 ) {
        $user_id = filter_input( INPUT_GET, 'user', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
        if ( $user_id ) {
            // get user meta activation hash field
            $code = get_user_meta( $user_id, 'has_to_be_activated', true );
            if ( $code == filter_input( INPUT_GET, 'key' ) ) {
                delete_user_meta( $user_id, 'has_to_be_activated' );
            }
        }
    }
}


add_filter( 'get_search_form', 'custom_html5_search_form' );
function custom_html5_search_form(){
    if( is_404() ) {
        $form = '<form role="search" method="get" class="search-form" action="' . home_url( '/' ) . '">
            <input type="search" class="search-field" placeholder="' . esc_attr_x( 'Search our website', 'placeholder' ) . '" value="' . get_search_query() . '" name="s" />
            <input type="submit" class="search-submit" value="' . esc_attr_x( 'Search', 'submit button' ) . '" />
        </form>';
        return $form;
    }
}


add_filter('wpseo_title', 'filter_product_wpseo_title');
function filter_product_wpseo_title($title) {
	if( get_locale() != "en_US") {
		$apiKey = "AIzaSyDcyyYqhqGyd65gSP1CMYPV_hRsTSAGWN0";	
		$url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q='.rawurlencode($title).'&source=en&target=ar';

		$handle = curl_init($url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($handle);                 
		$responseDecoded = json_decode($response, true);
		curl_close($handle);

		//var_dump($responseDecoded['data']['translations'][0]['translatedText']);

		return $responseDecoded['data']['translations'][0]['translatedText'];
	}  else {
		return $title;
	}
}

// define the wpseo_metadesc callback 
// add the filter 
add_filter( 'wpseo_metadesc', 'filter_wpseo_metadesc'); 
function filter_wpseo_metadesc( $wpseo_replace_vars ) { 
    if( get_locale() != "en_US") {
		$apiKey = "AIzaSyDcyyYqhqGyd65gSP1CMYPV_hRsTSAGWN0";	
		$url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q='.rawurlencode($wpseo_replace_vars).'&source=en&target=ar';

		$handle = curl_init($url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($handle);                 
		$responseDecoded = json_decode($response, true);
		curl_close($handle);

		//var_dump($responseDecoded['data']['translations'][0]['translatedText']);
		return $responseDecoded['data']['translations'][0]['translatedText'];
	}  else {
		return $wpseo_replace_vars;
	}
}; 

//check if user email exist
add_action( 'wp_ajax_check_user_email', 'check_user_email_func' );
add_action( 'wp_ajax_nopriv_check_user_email', 'check_user_email_func' );
function check_user_email_func(){
	$result = array('result' => false);
  	if(isset($_GET["email"]) && !empty($_GET["email"])) {
		$email = $_GET["email"]; //aalsalahi@gmail.com
		 if ( email_exists($email) ){
			$result["result"] = true;
		 
		$user = get_user_by( 'email', $email );
		$user_login = $user->user_login;
		add_filter('wp_mail_content_type', 'stm_set_html_content_type_mail');
        $headers = array('From: Motorsdoha <admin@motorsdoha.com>');
        $link = site_url()."/change-password/?email=".$email; 
        $to = $email;
        $subject = generateSubjectView('password_recovery', array('password_content' => $link, "user_login"=>$user_login));
        $body = generateTemplateView('password_recovery', array('password_content' => $link, "user_login"=>$user_login));
        wp_mail($to, $subject, $body, $headers); 
	  }  
	}
	echo json_encode($result);
	wp_die();	
}

//change password
add_action( 'wp_ajax_change_user_pass', 'change_user_pass_func' );
add_action( 'wp_ajax_nopriv_change_user_pass', 'change_user_pass_func' );
function change_user_pass_func(){
	$result = array('result' => false);
  	if(isset($_GET["pass"]) && !empty($_GET["pass"]) && isset($_GET["email"]) && !empty($_GET["email"]) ) {

		$user = get_user_by('email', $_GET["email"]);
		$user_id = $user->ID; //get user id
		wp_set_password( $_GET["pass"], $user_id );
		$result["result"] = true;
		
	}
	echo json_encode($result);
	wp_die();	
}