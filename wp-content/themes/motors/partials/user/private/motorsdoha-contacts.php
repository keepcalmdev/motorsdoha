<?php
$social = get_theme_mod('socials_link');
$all_social_links = explode( '&', $social );
?>
<div class="show-motorsdoha-contacts">
    <img src="<?php echo get_template_directory_uri() . '/assets/images/Motorsdoha-Logo.png'; ?>" alt="Motors Doha logo">
    <div class="social-links">
		<?php foreach ($all_social_links as $social_link) :
			$social_link = explode( '=', $social_link);
			if( $social_link[1] ) :
				if( $social_link[0] !== 'phone' ) : ?>
                    <a href="<?php echo esc_url( urldecode( $social_link[1] ) ); ?>" target="_blank">
                        <i class="fa fa-<?php echo esc_attr( $social_link[0] ); ?>" aria-hidden="true"></i>
                    </a>
				<?php else : ?>
                    <div class="stm-dealer-phone">
                        <i class="stm-service-icon-phone"></i>
                        <div class="phone-label heading-font">Contact Phone</div>
                        <div class="phone">
                            <a class="number" href="tel:<?php echo preg_replace('/[^0-9]/', '', $social_link[1]); ?>" target="_self">
								<?php echo urldecode( $social_link[1] ); ?>
                            </a>
                        </div>
                    </div>
				<?php endif;
			endif;
		endforeach; ?>
    </div>
</div>