<?php get_header(); ?>

<div class="stm-error-page-unit">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?php esc_html_e('Accidents happen. Just like this page.', 'motors'); ?></h2>
                <?php get_search_form(); ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="button"><?php esc_html_e('Homepage', 'motors'); ?></a>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
