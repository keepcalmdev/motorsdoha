<?php
if(stm_is_magazine()) {
    add_filter('body_class', 'stm_listing_magazine_body_class');
}
?>
<?php get_header(); ?>

<?php get_template_part('partials/page_bg'); ?>
<?php get_template_part('partials/title_box'); ?>

    <div class="stm-single-car-page">
        <?php if (stm_is_motorcycle()) {
            get_template_part('partials/single-car-motorcycle/tabs');
        } ?>

        <?php
        $recaptcha_enabled = get_theme_mod('enable_recaptcha', 0);
        $recaptcha_public_key = get_theme_mod('recaptcha_public_key');
        $recaptcha_secret_key = get_theme_mod('recaptcha_secret_key');
        if (!empty($recaptcha_enabled) and $recaptcha_enabled and !empty($recaptcha_public_key) and !empty($recaptcha_secret_key)) {
            wp_enqueue_script('stm_grecaptcha');
        }
        ?>

        <div class="container">
            <?php if (have_posts()) :

                $current_user_id = get_current_user_id();
                        $author_id = get_the_author_id();
                        $post_id = get_the_ID();
                       // echo $current_user_id;
                       // echo $author_id;
                         if ($current_user_id === $author_id) {
                                 
                                  ?>

                                  <a class="edit-button-car" href="/add-a-car-page/?edit_car=1&item_id=<?php echo $post_id;?>">Edit <i class="fa fa-pencil"></i></a>

                                 <?php

                             }

                $template = 'partials/single-car/car-main';
                if (is_listing(array('listing', 'listing_two', 'listing_three'))) {
                    $template = 'partials/single-car-listing/car-main';
                } elseif (stm_is_listing_four()) {
                    $template = 'partials/single-car-listing/car-main-four';
                } elseif (stm_is_boats()) {
                    $template = 'partials/single-car-boats/boat-main';
                } elseif (stm_is_motorcycle()) {
                    $template = 'partials/single-car-motorcycle/car-main';
                }




                while (have_posts()) : the_post();

                    $vc_status = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true);


                    if ($vc_status != 'false' && $vc_status == true) {
                        the_content();
                    } else {

                       
                        get_template_part($template);
                    }

                endwhile;

            endif; ?>

            <div class="clearfix">
                <?php /*
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				} */
                ?>
            </div>
        </div> <!--cont-->
    </div> <!--single car page-->
<?php get_footer(); ?>