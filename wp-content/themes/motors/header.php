<?php 
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  //echo $actual_link;

// $a = 'How are you?';

// if (strpos($a, 'are') !== false) {
//     echo 'true';
// }

    if(strpos($actual_link , ''.get_bloginfo('url').'qprlogin/?action=logout') !== false){

       header('Location: '.str_replace('/ar/', '/', get_bloginfo('url')).'/qprlogin/?action=logout&_wpnonce='.wp_create_nonce( 'log-out').'&redirect_to='.get_bloginfo('url').'' , true, 301); 
       exit();

    }
    if (is_page('add-a-car-page')) {
        if (!is_user_logged_in()) {
            wp_redirect(get_bloginfo('url').'/login-register');
            exit();
        }
    }

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, <?php echo (stm_is_rental()) ? 'user-scalable=no' : ''; ?>">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php
global $post;
$post_type = get_post_type( $post->ID );
if( is_page( 639 ) ) {
    remove_action( 'wp_head', '_wp_render_title_tag', 1 );

    $filter = stm_listings_filter();
    $condition ="";
    $car_make ="";
    $car_model ="";
    $car_year ="";
    $title ="";
    $desc = "";

    while(list($key, $value) = each($filter["options"]["condition"])){

        if($value["selected"] && $value["label"]){
            $condition = $value["label"];
            break;
        }
    }

    while(list($key, $value) = each($filter["options"]["make"])){

        if($value["selected"] && $value["label"] !== "Make"){
            $car_make = $value["label"];
            break;
        }
    }

    while(list($key, $value) = each($filter["options"]["serie"])){

        if($value["selected"] && $value["label"] !== "Model"){
            $car_model = $value["label"];
            break;
        }
    }

    while(list($key, $value) = each($filter["options"]["ca-year"])){

        if($value["selected"] && $value["label"] !== "Year"){
            $car_year = $value["label"];
            break;
        }
    }


    if($condition == "New"){
        //Car Make (New)
        if($car_model === ""){
        $title = "New " . $car_make . " Cars for Sale in Qatar | MotorsDoha";
        $desc = '<meta name="description" content="Shop new '. $car_make.' vehicles for sale in Qatar. Find great deal on new '.$car_make.'. Inspected & Certified brand new cars on motorsdoha.com." />';
        } else { //Car Model (New)
            $title = $car_year." " . $car_make." ". $car_model. " Prices, Cars for Sale in Qatar | MotorsDoha";
            $desc = '<meta name="description" content="New '.$car_make.' '.$car_model.' for sale on motorsdoha.com. Shop and buy top-rated new cars. Find a great deal on '.$car_make.' '.$car_model.' in Qatar." />';
        }
    } elseif($condition == "Used") {
        //Car Make (Used) 
        if($car_model === ""){
            $title = $car_make ." Used Cars for Sale in Qatar | MotorsDoha";
            $desc = '<meta name="description" content="Shop used '.$car_make.' vehicles for sale in Qatar. Find great deal on used '.$car_make.'. Inspected & Certified second hand cars on motorsdoha.com." />';

        } else { //Car Model (Used)
            $title = "Used ".$car_make." ".$car_model." Cars for Sale in Qatar | MotorsDoha";
            $desc = '<meta name="description" content="Used '.$car_make.' '.$car_model .' for sale on motorsdoha.com. Explore exiting offers and discounts. Find a great deal on used '.$car_make.' '.$car_model.' in Qatar." />';
        }

    } else {
        $title = "Inventory | MotorsDoha";
        $desc = '<meta name="description" content="inventory,  MotorsDoha" />';
    }
    
    echo "<title>".$title."</title>";
    echo $desc;

}

?>

	    <?php wp_head(); ?>

	<!-- <link rel="stylesheet" href="<?php echo get_template_directory_uri();?>/style1.css"> -->
	<?php

	if(get_theme_mod('logo_font_family', '') != "" || get_theme_mod('logo_font_size', '') != "" || get_theme_mod('logo_color', '') != "") {
		echo "<style>";
		echo ".blogname h1{";
		if ( get_theme_mod( 'logo_font_family', '' ) != "" ) {
			echo "font-family: " . get_theme_mod( 'logo_font_family', '' ) . " !important; ";
		}
		if ( get_theme_mod( 'logo_font_size', '' ) != "" ) {
			echo "font-size: " . get_theme_mod( 'logo_font_size', '' ) . "px !important; ";
		}
		if ( get_theme_mod( 'logo_color', '' ) != "" ) {
			echo "color: " . get_theme_mod( 'logo_color', '' ) . " !important;";
		}
		echo "}";
		echo "</style>";
	}
	?>

<style type="text/css">
    
.rtl .entry-header{
    background-image: url(<?php echo str_replace('/ar/', '/', get_bloginfo('url')); ?>wp-content/themes/motors/assets/images/title-box-default-bg-2.jpg);
}



</style>


<style>
    .listing-list-loop .main-mob-btn-wrapper a.btn-icon > img {width: auto !important;}
</style>
</head>

<?php
	$body_custom_image = get_theme_mod('custom_bg_image');
	$boats_header_layout = get_theme_mod('boats_header_layout', 'boats');
	$motorcycle_header_layout = get_theme_mod('motorcycle_header_layout', 'motorcycle');
	$top_bar_layout = '';
	if(stm_is_boats() || stm_is_dealer_two()) {
		$top_bar_layout = '-boats';
	}

?>




<?php 

    $user = get_userdata( get_current_user_id() );

    // Get all the user roles as an array.
    $user_roles = $user->roles;

    $current_role = $user_roles[0];

?>


<body <?php body_class('stm-template-listing_four'); ?> <?php if(!empty($body_custom_image)): ?> style="background-image: url('<?php echo esc_url($body_custom_image); ?>')" <?php endif; ?> ontouchstart="">


	<?php do_action('motors_before_header'); ?>
	<div id="wrapper">
        <?php if(!stm_is_auto_parts()) { ?>
            <?php if(stm_is_boats() || stm_is_dealer_two()): ?>
                <div id="stm-boats-header">
            <?php endif; ?>

                <?php if(!is_404() and !is_page_template('coming-soon.php')){ ?>
                    <?php get_template_part('partials/top', 'bar' . $top_bar_layout); ?>
                    <div id="header">
                        <?php
                            if(is_listing(array('listing', 'listing_two', 'listing_three'))) {
                                get_template_part( 'partials/header/header-listing' );
                            } elseif(stm_get_current_layout() == 'boats' and $boats_header_layout == 'boats') {
                                get_template_part( 'partials/header/header-boats' );
                            } elseif(stm_is_motorcycle() and $motorcycle_header_layout == 'motorcycle') {
                                get_template_part( 'partials/header/header-motorcycle' );
                            } elseif(stm_is_rental()) {
                                get_template_part( 'partials/header/header-rental' );
                            } elseif(stm_is_magazine()) {
                                get_template_part( 'partials/header/header-magazine' );
                            } elseif(stm_is_dealer_two()) {
                                get_template_part( 'partials/header/header-dealer-two' );
                            } else {
                                get_template_part('partials/header/header');
                                get_template_part('partials/header/header-nav');
                            }
                        ?>
                    </div> <!-- id header -->
                <?php } elseif(is_page_template('coming-soon.php')) {
                    get_template_part('partials/header/header-coming','soon');
                } else {
                    get_template_part('partials/header/header','404');
                }; ?>
            <?php if(stm_is_boats() || stm_is_dealer_two()): ?>
                </div>
                <?php get_template_part('partials/header/header-boats-mobile'); ?>
            <?php endif; ?>
        <?php } else {
            do_action('stm_hb', array('header' => 'stm_hb_settings'));
        } ?>
		<div id="main" <?php if(stm_is_magazine()) echo 'style="margin-top: -80px;"'; ?>>



