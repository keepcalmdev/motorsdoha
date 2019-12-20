<?php
/*----------------Filter page----------------*/
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
                    $title = $car_year. " " .$car_make." ".$car_model. " Prices, Cars for Sale in Qatar | MotorsDoha";
                    $desc = "New ".$car_make." ".$car_model." for sale on motorsdoha.com. Shop and buy top-rated new cars. Find a great deal on ".$car_make." " .$car_model ." in Qatar.";
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
    echo "<title>".preg_replace('/\s\s+/', ' ', str_replace("،",",",$title) ) ."</title>"."\n";
    echo '<meta name="description" content="'.preg_replace('/\s\s+/', ' ', str_replace("،",",",$desc) )  .'" />'."\n";

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


/*----------------Seperate car page----------------*/
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
    $price = "";
    //make
    $make = get_post_meta($post_id, 'make', true);
    $car_make = $filter["options"]["make"][$make]["label"];
    //model
    $model = get_post_meta($post_id, 'serie', true);
    $car_model = $filter["options"]["serie"][$model]["label"];
    //year
    $car_year = get_post_meta($post_id, 'ca-year', true);
    //price
    $price = get_post_meta($post_id, 'price', true);
    $currency = "QAR";
    $price = $price." ".$currency;


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
            $desc ="New ".$car_make." ".$car_model." ".$car_year." for ".$price." on MotorsDoha.com. Get latest prices, shop and buy top-rated new cars. Find a great deal on ".$car_make." ".$car_model." in Qatar.";

        }
    } else if ($car_condition === "used-cars") { //Specific Car Page (Used)
        if(get_locale() != "en_US"){ //ar
            $title ="سيارة ".$car_year." ".$car_make." ".$car_model." مستعملة للبيع في قطر | مواتر الدوحة";
            $desc ="اشترِ سيارة ".$car_make." ".$car_model." ".$car_year." على موقع motorsdoha.com. سيارات مستعملة مفحوصة ومضمونة للبيع. اعثر على عرض رائع على ".$car_make." ".$car_model." المستعملة في قطر.";
        } else {
            $title ="Used ".$car_year." ".$car_make." ".$car_model." for Sale in Qatar | MotorsDoha";
            $desc ="Buy used ".$car_make." ".$car_model." ".$car_year." for ".$price." on Motorsdoha.com. Inspected & Certified second hand cars for sale. Find a great deal on used ".$car_make." ".$car_model." in Qatar.";

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


/*----------------Others pages AR----------------*/
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

/*---------------- Yoast og:locale----------------*/
do_action("print_locale");

/*---------------- print canonical (filter page) ----------------*/
do_action("print_canonical");
?>