<?php
$post_id = get_the_ID();
$car_title = get_post_meta($post_id, 'car_title', true);
$car_condition = get_post_meta($post_id, 'condition', true);
$car_title_prefix = "";
if($car_title === ""){ //custom title prefix
   if($car_condition === "new-cars"){
        $car_title_prefix = "New";
    } else if ($car_condition === "used-cars") {
        $car_title_prefix = "Used";
    } 
}
?>
<div class="row">
    <div class="col-md-9 col-sm-12 col-xs-12">
        <div class="stm-single-car-content">
            <h1 class="title h2"><?php echo $car_title_prefix . " ";?><?php echo ($car_title === "")? the_title() :  $car_title; ?></h1>

            <!--Actions-->
            <?php get_template_part( 'partials/single-car/car', 'actions' ); ?>

            <!--Gallery-->
            <?php get_template_part( 'partials/single-car/car', 'gallery' ); ?>

            <!--Car Gurus if is style BANNER-->
            <?php if ( strpos( get_theme_mod( "carguru_style", "STYLE1" ), "BANNER" ) !== false ) get_template_part( 'partials/single-car/car', 'gurus' ); ?>
            <?php the_content(); ?>
        </div>
    </div>

    <div class="col-md-3 col-sm-12 col-xs-12">
        <div class="stm-single-car-side">
            <?php
            if ( is_active_sidebar( 'stm_listing_car' ) ) {
                dynamic_sidebar( 'stm_listing_car' );
            } else {
                /*<!--Prices-->*/
                get_template_part( 'partials/single-car/car', 'price' );

                /*<!--Data-->*/
                get_template_part( 'partials/single-car/car', 'data' );

                /*<!--Rating Review-->*/
                get_template_part( 'partials/single-car/car', 'review_rating' );

                /*<!--MPG-->*/
                get_template_part( 'partials/single-car/car', 'mpg' );

                /*<!--Calculator-->*/
                get_template_part( 'partials/single-car/car', 'calculator' );
            }
            ?>

        </div>
    </div>
</div>