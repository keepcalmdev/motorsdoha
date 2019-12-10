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

    if( get_locale() != "en_US") {
        $apiKey = "AIzaSyDcyyYqhqGyd65gSP1CMYPV_hRsTSAGWN0";    
        $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q='.rawurlencode($car_make).'&source=en&target=ar';

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handle);                 
        $responseDecoded = json_decode($response, true);
        curl_close($handle);

        $car_make = $responseDecoded['data']['translations'][0]['translatedText']; //car make ar

        $apiKey = "AIzaSyDcyyYqhqGyd65gSP1CMYPV_hRsTSAGWN0";    
        $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q='.rawurlencode($car_model).'&source=en&target=ar';

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handle);                 
        $responseDecoded = json_decode($response, true);
        curl_close($handle);

        $car_model = $responseDecoded['data']['translations'][0]['translatedText']; //car model ar
    }


    if($condition == "New"){
        if( $car_make === "" && $car_model === "" ) { //new default
            if(get_locale() != "en_US"){ //ar
                $title = "سيارات جديدة في قطر، مقالات وأسعار، اشترِ سيارة جديدة | مواتر الدوحة";
                $desc = 'ابحث عن سيارات جديدة للبيع فى قطر. شاهد أحدث عروض السيارات الجديدة واحصل على السعر من التُجار والوكلاء مباشرةً. قارن السيارات وأقرأ آخر الأخبار والمقالات.';
            } else { //en
                $title ="New Cars in Qatar, Reviews and Prices, Buy New Car | MotorsDoha "; //en
                $desc = 'Research new cars for sale in Qatar. View the latest new car offers, get the price from dealers. Compare cars, read latest news and reviews.';
            }
        } else { //new make/model
            //Car Make (New)
            if($car_model === ""){
                if(get_locale() != "en_US"){ //ar
                    $title = "سيارات ".$car_make." جديدة للبيع في قطر | مواتر الدوحة";
                    $desc = "اعرض سيارات ".$car_make." جديدة للبيع في قطر. اعثر على عرض رائع على ".$car_make." الجديدة. سيارات جديدة مفحوصة ومضمونة على موقع motorsdoha.com.";
                } else {
                    $title = "New ".$car_make." Cars for Sale in Qatar | MotorsDoha";
                    $desc = "Shop new ".$car_make." vehicles for sale in Qatar. Find great deal on new ".$car_make.". Inspected & Certified brand new cars on motorsdoha.com.";
                }
            } else { //Car Model (New)
                if(get_locale() != "en_US"){ //ar
                    $title = "الأسعار، سيارات ".$car_year." ".$car_make." ".$car_model." للبيع في قطر | مواتر الدوحة";
                    $desc = $car_make. " ".$car_model." مستعملة للبيع على موقع motorsdoha.com. تسوق واشترِ السيارات الجديدة الأعلى تصنيفًا. اعثر على عرض رائع على ".$car_make." ".$car_model." في قطر.";
                } else {
                    $title = $car_year. " " .$car_make." ".$car_model. "Prices, Cars for Sale in Qatar | MotorsDoha";
                    $desc = "New ".$car_make." ".$car_model." for sale on motorsdoha.com. Shop and buy top-rated new cars. Find a great deal on ".$car_make." " .$car_model ."in Qatar.";
                }

            }
        }
    } elseif($condition == "Used") {
        if( $car_make === "" && $car_model === "" ) {
            if(get_locale() != "en_US"){ //ar
                $title = "سيارات مستعمله للبيع في قطر، اشترِ سيارة مستعملة | مواتر الدوحة";
                $desc = 'متجر للسيارات المستعملة عبر الإنترنت. اعثر علي أفضل العروض المحلية في قطر. تشكيلة كبيرة من السيارات المستعملة والمملوكة مُسبقًا من المالكين المعتمدين.';
            } else {
                $title = "Used Cars for Sale in Qatar, Buy Second Hand Car | MotorsDoha";
                $desc = 'Shop for used cars online. Find the best local deals in Qatar. A wide selection of quality second hand & pre-owned cars from verified owners.';
            }
        } else {
            if($car_model === ""){ //Car Make (Used)
                if(get_locale() != "en_US"){ //ar
                    $title = "سيارات ".$car_make." مستعملة للبيع في قطر | مواتر الدوحة";
                    $desc = $car_make." مستعملة للبيع في قطر. اعثر على عرض رائع على ".$car_make." المستعملة. سيارات مستعملة مفحوصة ومضمونة على موقع motorsdoha.com.";
                } else {
                    $title = $car_make. " Used Cars for Sale in Qatar | MotorsDoha";
                    $desc = "Shop used ".$car_make." vehicles for sale in Qatar. Find great deal on used ".$car_make.". Inspected &amp; Certified second hand cars on motorsdoha.com.";
                }
            } else { //Car Model (Used)
                if(get_locale() != "en_US"){ //ar
                    $title = "سيارات ".$car_make." ".$car_model." مستعملة للبيع في قطر | مواتر الدوحة";
                    $desc = $car_make." ".$car_model." مستعملة للبيع على موقع motorsdoha.com. استكشف العروض والخصومات الرائعة. اعثر على عرض رائع على ".$car_make." ".$car_model." المستعملة في قطر. سيارات ".$car_make." ".$car_model." مستعملة في قطر";
                } else {
                    $title = "Used ".$car_make." ".$car_model." Cars for Sale in Qatar | MotorsDoha";
                    $desc = "Used ".$car_make." ".$car_model." for sale on motorsdoha.com. Explore exiting offers and
                    discounts. Find a great deal on used ".$car_make." ".$car_model." in Qatar.";
                }

            }
        }
    } else { //condition
        if($car_make !== "" || $car_model !=="" ){
            if(get_locale() != "en_US"){
                if($car_make !== "" && $car_model ===""){ // Without condition make
                    $title = $car_make." سيارات للبيع، السعر في قطر | مواتر الدوحة";
                    $desc ="اعرض سيارات ".$car_make." جديدة ومستعملة للبيع في الدوحة، قطر. اعثر على عرض رائع على ".$car_make.". سيارات جديدة مستعملة مضمونة علي موقع motorsdoha.com.";
                } else if($car_make != "" && $car_model !="") { //Without condition model
                    $title ="سيارات ".$car_make." ".$car_model." للبيع، السعر في قطر | مواتر الدوحة";
                    $desc ="سيارات ".$car_make." ".$car_model." جديدة ومستعملة للبيع على موقع motorsdoha.com. استكشف العروض والخصومات الرائعة. اعثر على عروض رائعة على ".$car_make." ".$car_model." في قطر.";
                } 
            } else {
                $title = trim($car_make . " " .$car_model . " Cars for Sale, Price in Qatar | MotorsDoha");
                $title = str_replace('  ', " ", $title);
                if ($car_model === "") { //car make description
                    $desc = 'Shop new & used '.$car_make.' vehicles for sale in Doha, Qatar. Find great deal on '.$car_make.'. New & certified second hand cars on motorsdoha.com.';
                } else { //car model descripiron
                    $desc = 'New & used '. $car_make.' ' . $car_model.' for sale on motorsdoha.com. Explore exiting offers and discounts. Find a great deal on '.$car_make.' ' .$car_model.' in Qatar.';
                }
            }

        } else { //inventory default
            if(get_locale() != "en_US"){
                $title = "بيع السيارات في قطر، اشترِ سيارات جديدة ومستعملة | مواتر الدوحة";
                $desc = 'مجموعة كبيرة من السيارات من التجار والوكلاء الموثوقين. تصفح قائمة سيارات مواتر الدوحة للعثور علي سيارتك الجديدة أو المستعملة القادمة. ابحث وقارن بين الموديلات والأسعار في قطر.';
            } else {
                $title = "Qatar car Sale, Buy New & Used Vehicles | MotorsDoha";
                $desc = 'Wide range of cars from trusted dealers. Browse MotorsDoha inventory to find your next new or used car. Research, compare models and prices in Qatar.';

            }
        } 
    }

    // if( get_locale() != "en_US") {
    //     $apiKey = "AIzaSyDcyyYqhqGyd65gSP1CMYPV_hRsTSAGWN0";    
    //     $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q='.rawurlencode($title).'&source=en&target=ar';

    //     $handle = curl_init($url);
    //     curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($handle);                 
    //     $responseDecoded = json_decode($response, true);
    //     curl_close($handle);

    //     echo "<title>".$responseDecoded['data']['translations'][0]['translatedText']."</title>"."\n";
    // }  else {
        echo "<title>".preg_replace('/\s\s+/', ' ', str_replace("،",",",$title) ) ."</title>"."\n";
    //}

    // if( get_locale() != "en_US") {
    //     $apiKey = "AIzaSyDcyyYqhqGyd65gSP1CMYPV_hRsTSAGWN0";    
    //     $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q='.rawurlencode($desc).'&source=en&target=ar';

    //     $handle = curl_init($url);
    //     curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    //     $response = curl_exec($handle);                 
    //     $responseDecoded = json_decode($response, true);
    //     curl_close($handle);

    //     echo '<meta name="description" content="'. $responseDecoded['data']['translations'][0]['translatedText'] .'" />';
    //}  else {
         echo '<meta name="description" content="'.preg_replace('/\s\s+/', ' ', str_replace("،",",",$desc) )  .'" />'."\n";
    //}

    //additional metatags
    $title = str_replace("،",",",$title);
    $desc = str_replace("،",",",$desc);     
    $ogtitle = '<meta property="og:title" content="'.$title.'" />';
    $ogdesc = '<meta property="og:description" content="'.$desc.'" />';
    $twtitle = '<meta name="twitter:title" content="'.$title.'" />';
    $twdes = '<meta name="twitter:description" content="'.$desc.'" />';
    $metatags = $ogtitle . "\n" . $ogdesc . "\n" . $twtitle . "\n" . $twdes . "\n";
    echo $metatags;
    //end additional metatags     


}
//car page
$post_id = get_the_ID();
$categories = get_post_type( $post_id );
if ($categories === "listings") {
    remove_action( 'wp_head', '_wp_render_title_tag', 1 );
    $filter = stm_listings_filter();
    $condition ="";
    $car_make ="";
    $car_model ="";
    $car_year ="";
    $title ="";
    $desc = "";
    //make
    $make = get_post_meta($post_id, 'make', true);
    $car_make = $filter["options"]["make"][$make]["label"];
    //model
    $model = get_post_meta($post_id, 'serie', true);
    $car_model = $filter["options"]["serie"][$model]["label"];
    //year
    $car_year = get_post_meta($post_id, 'ca-year', true);

    if( get_locale() != "en_US") {
        $apiKey = "AIzaSyDcyyYqhqGyd65gSP1CMYPV_hRsTSAGWN0";    
        $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q='.rawurlencode($car_make).'&source=en&target=ar';

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handle);                 
        $responseDecoded = json_decode($response, true);
        curl_close($handle);

        $car_make = $responseDecoded['data']['translations'][0]['translatedText']; //car make ar

        $apiKey = "AIzaSyDcyyYqhqGyd65gSP1CMYPV_hRsTSAGWN0";    
        $url = 'https://www.googleapis.com/language/translate/v2?key=' . $apiKey . '&q='.rawurlencode($car_model).'&source=en&target=ar';

        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($handle);                 
        $responseDecoded = json_decode($response, true);
        curl_close($handle);

        $car_model = $responseDecoded['data']['translations'][0]['translatedText']; //car model ar
    }

   
    $title ="";
    $desc = "";

    $car_condition = get_post_meta($post_id, 'condition', true);
    if($car_condition === "new-cars"){ //Specific Car Page (New)
        if(get_locale() != "en_US"){ //ar
            $title ="سيارة ".$car_year." ".$car_make." ".$car_model." للبيع في قطر | مواتر الدوحة";
            $desc ="ابحث عن سيارة ".$car_make." ".$car_model. " ".$car_year." على موقع motorsdoha.com. احصل على آخر الأسعار، تسوق واشترِ السيارات الجديدة الأعلى تصنيفًا. اعثر على عرض رائع على ".$car_make." ".$car_model." في قطر.";
        } else {
            $title =$car_year." ".$car_make." ".$car_model." for Sale in Qatar | MotorsDoha";
            $desc ="Research ".$car_make." ".$car_model." ".$car_year." on motorsdoha.com. Get latest prices, shop and buy top-rated new cars. Find a great deal on ".$car_make." ".$car_model." in Qatar.";

        }
    } else if ($car_condition === "used-cars") { //Specific Car Page (Used)
        if(get_locale() != "en_US"){ //ar
            $title ="سيارة ".$car_year." ".$car_make." ".$car_model." مستعملة للبيع في قطر | مواتر الدوحة";
            $desc ="اشترِ سيارة ".$car_make." ".$car_model." ".$car_year." على موقع motorsdoha.com. سيارات مستعملة مفحوصة ومضمونة للبيع. اعثر على عرض رائع على ".$car_make." ".$car_model." المستعملة في قطر.";
        } else {
            $title ="Used ".$car_year." ".$car_make." ".$car_model." for Sale in Qatar | MotorsDoha";
            $desc ="Buy used ".$car_make." ".$car_model." ".$car_year." on motorsdoha.com. Inspected & Certified second hand cars for sale. Find a great deal on used ".$car_make." ".$car_model." in Qatar.";

        }        
    }
    echo "<title>".preg_replace('/\s\s+/', ' ', str_replace("،",",",$title) ) ."</title>"."\n";
    echo '<meta name="description" content="'.preg_replace('/\s\s+/', ' ',str_replace("،",",",$desc) ) .'" />'."\n";
    //additional metatags
    $title = preg_replace('/\s\s+/', ' ',str_replace("،",",",$title) ) ;
    $desc = preg_replace('/\s\s+/', ' ',str_replace("،",",",$desc) ) ;  
    $ogtitle = '<meta property="og:title" content="'.$title.'" />';
    $ogdesc = '<meta property="og:description" content="'.$desc.'" />';
    $twtitle = '<meta name="twitter:title" content="'.$title.'" />';
    $twdes = '<meta name="twitter:description" content="'.$desc.'" />';
    $metatags = $ogtitle . "\n" . $ogdesc . "\n" . $twtitle . "\n" . $twdes . "\n";
    echo $metatags;
    //end additional metatags  


}

// echo "sraka";
// echo get_locale(); 
// echo  is_page( 707 );
// global $post;
// echo $post->ID;
//seperate pages arabic metatags
global $post;
if(
    is_page( 5 ) || //home
    is_page( 1806 ) || //Delears
    $post->ID == 748 || //Blog/Newsroom
    is_page( 370 ) || //About us
    is_page( 712 )  //Contacts
){
    if(get_locale() != "en_US"){ //ar
        remove_action( 'wp_head', '_wp_render_title_tag', 1 );

        $title = "";
        $desc = "";
       

        if( is_page( 5 ) ){ //home
            $title = "سيارات للبيع في قطر، اشترِ سيارة جديدة ومستعملة | مواتر الدوحة";
            $desc = "اعثر على السيارات الجديدة والمستعملة من التجار الموثوقين. احصل على أفضل الأسعار للسيارات المعروضة للبيع في الدوحة، قطر. قم بشراء سيارة أو بيع سيارتك المستعملة بسهولة.";
        }
        if( is_page( 1806 ) ){ //Delears
            $title = "تجار ووكلاء السيارات في قطر، وكالات السيارات الجديدة والمستعملة | مواتر الدوحة";
            $desc = "اعثر على تاجر سيارات في الدوحة، قطر. اختر السيارة المناسبة من بين آلاف العروض واشتريها مباشرةً. وكالات السيارات الجديدة والمستعملة القريبة منك.";
        }
        if( $post->ID == 748 ){ //Blog/Newsroom
            $title = "مقالات وتقارير، إرشادات ونصائح لشراء سيارة | مواتر الدوحة";
            $desc = "إرشادات للبحث عن سيارة وشرائها. كل ما تحتاج لمعرفته حول شراء سيارة جديدة أو مستعملة. اقرأ مقالات الخبراء وآخر أخبار السيارات.";
        }
        if( is_page( 370 ) ){ //About us
            $title = "عن MotorsDoha.com | سيارات للبيع في قطر ";
            $desc = "اعرف أكثر عن MotorsDoha.com. اعثر على السيارات الجديدة أو المستعملة من التجار الموثوقين في قطر.";
        }
        if( is_page( 712 ) ){ //Contacts
            $title = "اتصل بنا | MotorsDoha.com";
            $desc = "اتصل بنا إذا كان لديك أي سؤال يتعلق بشراء أو بيع سيارة على موقع MotorsDoha.com. ويمكنك ترك تعليقاتك حول الموقع أو تقديم مقترح أو شكوى.";
        }
        
        echo "<title>". preg_replace('/\s\s+/', ' ',str_replace("،",",",$title) ) ."</title>"."\n";
        echo '<meta name="description" content="'. preg_replace('/\s\s+/', ' ',str_replace("،",",",$desc) )  .'" />'."\n";
    }
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
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NQ2MHQK');</script>
<!-- End Google Tag Manager -->
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
    
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NQ2MHQK"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

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
        }

        if(is_404()) : ?>
            <a  class="back-button" href="javascript:history.go(-1)">
                <img src="<?php echo get_template_directory_uri() . '/assets/images/left-arrow.svg'; ?>" alt="left arrow">
                <span><?php esc_html_e('Back', 'motors'); ?></span>
            </a>
        <?php endif; ?>

		<div id="main" <?php if(stm_is_magazine()) echo 'style="margin-top: -80px;"'; ?>>



