<?php
	$special_car = get_post_meta(get_the_ID(), 'special_car', true);
	$badge_text = get_post_meta(get_the_ID(), 'badge_text', true);
	$badge_bg_color = get_post_meta(get_the_ID(), 'badge_bg_color', true);
	if(!empty($badge_bg_color)) {
		$badge_bg_color = 'style="background-color:' . $badge_bg_color . '";';
	} else {
		$badge_bg_color = '';
	}

    if(empty($badge_text)) {
        $badge_text = 'Special';
    }

	if(!empty($special_car) and $special_car == 'on'): ?>
		<div class="stm-badge-directory heading-font <?php if(stm_is_car_dealer()) echo "stm-badge-dealer"?>" <?php echo sanitize_text_field($badge_bg_color); ?>>
			<?php printf( _x( '%s', 'Badge text', 'motors' ), $badge_text ); ?>
		</div>
	<?php endif; ?>
			<?php if (get_post_meta(get_the_ID(), 'car_mark_as_sold', true) == 'on') { ?>
				<div class="stm-badge-directory heading-font stm-badge-dealer" style="background-color:#dd3333" ;="">Sold</div>
			<?php } ?>