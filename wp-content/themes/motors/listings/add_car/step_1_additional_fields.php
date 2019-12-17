
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_countryOfOrigin" value="<?php echo get_post_meta($_GET['item_id'], 'countryOforigin', true); ?>" placeholder="Country of Origin">
		<div class="stm-label"><i class="stm-service-icon-countryOfOrigin"></i> Country of Origin</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_class" value="<?php echo get_post_meta($_GET['item_id'], 'class', true); ?>" placeholder="Car Class">
		<div class="stm-label"><i class="stm-service-icon-class"></i> Car Class</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_bodyStyle" value="<?php echo get_post_meta($_GET['item_id'], 'bodystyle', true); ?>" placeholder="Body Style">
		<div class="stm-label"><i class="stm-service-icon-bodyStyle"></i> Body Style</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_weight" value="<?php echo get_post_meta($_GET['item_id'], 'weight', true); ?>" placeholder="Car Weight (KG)">
		<div class="stm-label"><i class="stm-service-icon-weight"></i> Car Weight (KG)</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_engine_type" value="<?php echo get_post_meta($_GET['item_id'], 'engine_type', true); ?>" placeholder="Engine Type">
		<div class="stm-label"><i class="stm-service-icon-engine_type"></i> <i class="stm-icon-engine_fill"></i> Engine Type</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_gearBox" value="<?php echo get_post_meta($_GET['item_id'], 'gearbox', true); ?>" placeholder="Gear Box">
		<div class="stm-label"><i class="stm-service-icon-gearBox"></i> Gear Box</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_power" value="<?php echo get_post_meta($_GET['item_id'], 'power', true); ?>" placeholder="Horsepower">
		<div class="stm-label"><i class="stm-service-icon-power"></i> Horsepower</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_torque" value="<?php echo get_post_meta($_GET['item_id'], 'torque', true); ?>" placeholder="Engine Torque">
		<div class="stm-label"><i class="stm-service-icon-torque"></i> Engine Torque</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_fuelEconomy100KMPL" value="<?php echo get_post_meta($_GET['item_id'], 'fueleconomy100kmpl', true); ?>" placeholder="Fuel Consumption (100 KM/L)">
		<div class="stm-label"><i class="stm-service-icon-fuelEconomy100KMPL"></i> Fuel Consumption (100 KM/L)</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_fuelEconomyKMPL" value="<?php echo get_post_meta($_GET['item_id'], 'fueleconomykmpl', true); ?>" placeholder="Fuel Consumption (KM/L)">
		<div class="stm-label"><i class="stm-service-icon-fuelEconomyKMPL"></i> Fuel Consumption (KM/L)</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_zeroToHundred" value="<?php echo get_post_meta($_GET['item_id'], 'zerotohundred', true); ?>" placeholder="0-100 KM/Sec">
		<div class="stm-label"><i class="stm-service-icon-zeroToHundred"></i> 0-100 KM/Sec</div>
	</div>
	<div class="stm-form-1-quarter">
		<input type="text" name="stm_s_s_topSpeed" value="<?php echo get_post_meta($_GET['item_id'], 'topspeed', true); ?>" placeholder="Max Speed">
		<div class="stm-label"><i class="stm-service-icon-topSpeed"></i> Max Speed</div>
	</div>

<?php

if ( get_theme_mod('show_registered', true) ) {
	$data_value = get_post_meta($post_id, 'registration_date', true);
	?>
	<div class="stm-form-1-quarter stm_registration_date">
		<input type="text" name="stm_registered"
		       class="stm-years-datepicker<?php if (!empty($data_value)) {
			       echo ' stm_has_value';
		       } ?>"
		       placeholder="<?php esc_attr_e('Enter date', 'motors'); ?>"
		       value="<?php echo esc_attr($data_value); ?>"/>
		<div class="stm-label">
			<i class="stm-icon-key"></i>
			<?php esc_html_e('Registered', 'motors'); ?>
		</div>
	</div>
<?php }

if ( get_theme_mod('show_vin', true) ) {
	$data_value = get_post_meta($post_id, 'vin_number', true);
	?>
	<div class="stm-form-1-quarter stm_vin">
		<input type="text" name="stm_vin"
			<?php if (!empty($data_value)) { ?> class="stm_has_value" <?php } ?>
			   value="<?php echo esc_attr($data_value); ?>" placeholder="<?php esc_attr_e('Enter VIN', 'motors'); ?>"/>
		<div class="stm-label">
			<i class="stm-service-icon-vin_check"></i>
			<?php esc_html_e('VIN', 'motors'); ?>
		</div>
	</div>
<?php }

if ( get_theme_mod('show_history', true) ) {
	$data_value = get_post_meta($post_id, 'history', true);
	$data_value_link = get_post_meta($post_id, 'history_link', true);
	?>
	<div class="stm-form-1-quarter stm_history">
		<input type="text" name="stm_history_label" class="<?php echo (!empty($data_value)) ? 'stm_has_value' : ''; ?>"
		       value="<?php echo esc_attr($data_value) ?>" placeholder="<?php esc_attr_e('Vehicle History Report', 'motors'); ?>"/>
		<div class="stm-label">
			<i class="stm-icon-time"></i>
			<?php esc_html_e('History', 'motors'); ?>
		</div>

		<div class="stm-history-popup stm-invisible">
			<div class="inner">
				<i class="fa fa-remove"></i>
				<h5><?php esc_html_e('Vehicle history', 'motors'); ?></h5>
				<?php
				$histories = explode(',', $histories);
				if (!empty($histories)):
					echo '<div class="labels-units">';
					foreach ($histories as $history): ?>
						<label>
							<input type="radio" name="stm_chosen_history" value="<?php echo esc_attr($history); ?>"/>
							<span><?php echo esc_attr($history); ?></span>
						</label>
					<?php endforeach;
					echo '</div>';
				endif;
				?>
				<input type="text" name="stm_history_link" placeholder="<?php esc_attr_e('Insert link', 'motors') ?>"
				       value="<?php echo esc_attr($data_value_link); ?>"/>
				<a href="#" class="button"><?php esc_html_e('Apply', 'motors'); ?></a>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function () {
			var $ = jQuery;
			var $stm_handler = $('.stm-form-1-quarter.stm_history input[name="stm_history_label"]');
			$stm_handler.focus(function () {
				$('.stm-history-popup').removeClass('stm-invisible');
			});

			$('.stm-history-popup .button').on('click', function (e) {
				e.preventDefault();
				$('.stm-history-popup').addClass('stm-invisible');

				if ($('input[name=stm_chosen_history]:radio:checked').length > 0) {
					$stm_checked = $('input[name=stm_chosen_history]:radio:checked').val();
				} else {
					$stm_checked = '';
				}

				$stm_handler.val($stm_checked);
			});

			$('.stm-history-popup .fa-remove').on('click', function () {
				$('.stm-history-popup').addClass('stm-invisible');
			});
		});
	</script>
<?php }

if ( get_theme_mod('enable_location', true) ) {
	$data_value = get_post_meta($post_id, 'stm_car_location', true);
	$data_value_lat = get_post_meta($post_id, 'stm_lat_car_admin', true);
	$data_value_lng = get_post_meta($post_id, 'stm_lng_car_admin', true);
	?>

	<div class="stn-add-car-location-wrap">
		<div class="stm-car-listing-data-single">
			<div class="title heading-font"><?php esc_html_e( 'Car Location', 'motors' ); ?></div>
		</div>
		<div class="stm-form-1-quarter stm_location stm-location-search-unit">
			<div class="stm-location-input-wrap stm-location">
				<div class="stm-label">
					<i class="stm-service-icon-pin_2"></i>
					<?php esc_html_e('Location', 'motors'); ?>
				</div>
				<input type="text" name="stm_location_text"<?php if (!empty($data_value)) { ?> class="stm_has_value" <?php } ?>
					   id="stm-add-car-location" value="<?php echo esc_attr($data_value); ?>"
					   placeholder="<?php esc_attr_e('Enter ZIP or Address', 'motors'); ?>"/>
			</div>
			<div class="stm-location-input-wrap stm-lng">
				<div class="stm-label">
					<i class="stm-service-icon-pin_2"></i>
					<?php esc_html_e('Latitude', 'motors'); ?>
				</div>
				<input type="text" class="text_stm_lat" name="stm_lat" value="<?php echo esc_attr($data_value_lat); ?>"
				       placeholder="<?php esc_attr_e('Enter Latitude', 'motors'); ?>"/>
			</div>
			<div class="stm-location-input-wrap stm-lng">
				<div class="stm-label">
					<i class="stm-service-icon-pin_2"></i>
					<?php esc_html_e('Longitude', 'motors'); ?>
				</div>
				<input type="text" class="text_stm_lng" name="stm_lng" value="<?php echo esc_attr($data_value_lng); ?>"
				       placeholder="<?php esc_attr_e('Enter Longitude', 'motors'); ?>"/>
			</div>
			<div class="stm-link-lat-lng-wrap">
				<a href="http://www.latlong.net/" target="_blank"><?php echo esc_html__('Lat and Long Finder', 'motors'); ?></a>
			</div>
		</div>
	</div>
<?php }
?>