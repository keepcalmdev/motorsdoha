<?php

/**
 * Element Controls
 */
$getSpaces = new BSA_PRO_Ad_Space();

$array = array(

	'space_id' => array(
		'type' => 'select',
		'ui'   => array(
			'title'   => __( 'Ad Space (<a href="'.get_admin_url(1).'admin.php?page=bsa-pro-sub-menu-spaces" target="_blank">Edit Here</a>)', csl18n() ),
			'tooltip' => __( 'Select an Ad Space.', csl18n() ),
		),
		'options' => array(
			'choices' => array()
		),
	),

	'max_width' => array(
		'type' => 'number',
		'ui'   => array(
			'title'   => __( 'Max Width', csl18n() ),
			'tooltip' => __( 'Max width of ad space in pixels, eg. 468", "my-text-domain', csl18n() ),
		),
	),

	'delay' => array(
		'type' => 'number',
		'ui'   => array(
			'title'   => __( 'Delay', csl18n() ),
			'tooltip' => __( 'Param in seconds for a popup & slider ads, eg. 3", "my-text-domain', csl18n() ),
		),
	),

	'padding_top' => array(
		'type' => 'number',
		'ui'   => array(
			'title'   => __( 'Padding Top', csl18n() ),
			'tooltip' => __( 'Param in pixels for a background ads, eg. 100", "my-text-domain', csl18n() ),
		),
	),

	'attachment' => array(
		'type' => 'select',
		'ui'   => array(
			'title'   => __( 'Attachment (Background Ads)', csl18n() ),
			'tooltip' => __( 'Param for a background ads, eg. scroll or fixed', csl18n() ),
		),
		'options' => array(
			'choices' => array(
				array( "value" => '', "label" => __( "none", $td ) ),
				array( "value" => 'scroll', "label" => __( "Scroll", $td ) ),
				array( "value" => 'fixed', "label" => __( "Fixed", $td ) )
			)
		),
	),

	'crop' => array(
		'type' => 'select',
		'ui'   => array(
			'title'   => __( 'Crop', csl18n() ),
			'tooltip' => __( 'Select NO if you do not want to use cropping for images', csl18n() ),
		),
		'options' => array(
			'choices' => array(
				array( "value" => 'yes', "label" => __( "yes (disallow gif animations)", $td ) ),
				array( "value" => 'no', "label" => __( "no (allow gif animations)", $td ) ),
			)
		),
	),

	'hide_for_id' => array(
		'type' => 'text',
		'ui'   => array(
			'title'   => __( 'Hide for ID', csl18n() ),
			'tooltip' => __( 'Hide Ad Space for ID e.g. 3,10,100", "my-text-domain', csl18n() ),
		),
	),

	'if_empty' => array(
		'type' => 'select',
		'ui'   => array(
			'title'   => __( 'If the main is empty', csl18n() ),
			'tooltip' => __( 'Show other Ad Space if the main is empty e.g. 2', csl18n() ),
		),
		'options' => array(
			'choices' => array()
		),
	),

);

$array['if_empty']['options']['choices'][] = array( "value" => '', "label" => __( "none", $td ) );
foreach ($getSpaces->getAdSpaces() as $space) {
	$array['space_id']['options']['choices'][] = array( "value" => $space['id'], "label" => __( $space['name'] . " (ID: " . $space['id'] . ")", $td ) );
	$array['if_empty']['options']['choices'][] = array( "value" => $space['id'], "label" => __( $space['name'] . " (ID: " . $space['id'] . ")", $td ) );
}

return $array;