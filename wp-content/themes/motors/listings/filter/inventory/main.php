<div class="archive-listing-page">
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
<?php 
//SPECIALS val   
    if ( isset($_GET["featured_top"]) & !empty($_GET["featured_top"]) ) {
        $featured_top = $_GET["featured_top"];
        echo "<input type='hidden' name='featured_top_hidden' value=".$featured_top.">";
    }
?>  