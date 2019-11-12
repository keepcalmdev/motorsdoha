<?php 

    $filter = stm_listings_filter();
    $condition ="";
    $car_make ="";
    $car_model ="";

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

?>
<div class="archive-listing-page">
    <!-- Inventory title -->
    <?php
        $top_title = "";
        if($condition == "New"){
            $top_title = "New ".$car_make." ". $car_model." Cars in Qatar";
        } elseif($condition == "Used") {
                $top_title = "Used ".$car_make." ".$car_model." Cars in Qatar";
        }
    ?>
    <h1 class="title h2"><?php echo $top_title; ?></h1>
    <div class="container">
        <?php $boats_template = get_theme_mod('listing_boat_filter', true);
        wp_enqueue_script( 'stm_grecaptcha' );
        if (stm_is_dealer_two() || is_listing(array('listing', 'listing_two', 'listing_three'))) {
            get_template_part('partials/listing-cars/listing-directory', 'archive');
        } elseif (stm_is_boats() and $boats_template) {
            get_template_part('partials/listing-cars/listing-boats', 'archive');
        } elseif (stm_is_motorcycle()) {
            require_once(locate_template('partials/listing-cars/motos/listing-motos-archive.php'));
        } else {
            get_template_part('partials/listing-cars/listing', 'archive');
        }
        ?>
    </div>
</div>