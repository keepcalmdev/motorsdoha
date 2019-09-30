<?php

/**
 * Element Controls
 */

return array(

	'ad_template' => array(
		'type' => 'select',
		'ui'   => array(
			'title'   => __( 'Ad Template', csl18n() ),
			'tooltip' => __( 'Select an Ad Template for this ad.', csl18n() ),
		),
		'options' => array(
			'choices' => array(
				array( 'value' => 'default',			'label' => __( 'Default', $td ) ),
				array( 'value' => 'default-extra',		'label' => __( 'Default Extra', $td ) ),
				array( 'value' => 'facebook-1',			'label' => __( 'Facebook 1', $td ) ),
				array( 'value' => 'facebook-2',			'label' => __( 'Facebook 2', $td ) ),
				array( 'value' => 'flat-1',				'label' => __( 'Flat 1', $td ) ),
				array( 'value' => 'flat-2',				'label' => __( 'Flat 2', $td ) ),
				array( 'value' => 'flat-3',				'label' => __( 'Flat 3', $td ) ),
				array( 'value' => 'flat-4',				'label' => __( 'Flat 4', $td ) ),
				array( 'value' => 'image-1',			'label' => __( 'Image 1', $td ) ),
				array( 'value' => 'image-2',			'label' => __( 'Image 2', $td ) ),
				array( 'value' => 'link-1',				'label' => __( 'Link 1', $td ) ),
				array( 'value' => 'link-2',				'label' => __( 'Link 2', $td ) ),
				array( 'value' => 'material-design-1',	'label' => __( 'Material Design 1', $td ) ),
				array( 'value' => 'material-design-2',	'label' => __( 'Material Design 2', $td ) ),
				array( 'value' => 'modern-1',			'label' => __( 'Modern-1', $td ) ),
				array( 'value' => 'modern-2',			'label' => __( 'Modern-2', $td ) ),
				array( 'value' => 'modern-3',			'label' => __( 'Modern-3', $td ) ),
				array( 'value' => 'modern-4',			'label' => __( 'Modern-4', $td ) ),
				array( 'value' => 'paper-note-1',		'label' => __( 'Paper Note 1', $td ) ),
				array( 'value' => 'paper-note-2',		'label' => __( 'Paper Note 2', $td ) ),
				array( 'value' => 'paper-note-3',		'label' => __( 'Paper Note 3', $td ) )
			),
		)
	),

	'ad_title' => array(
		'type'    => 'text',
		'ui'   => array(
			'title'   => __( 'Ad Title', csl18n() ),
			'tooltip' => __( 'Enter Ad Title here.', csl18n() ),
		),
		'context' => 'content',
		'suggest' => __( 'Ad Title', 'ads-pro-ad-extension' ),
		'condition' => 	array(
			'ad_template' => array (
				'default',
				'default-extra',
				'facebook-1',
				'facebook-2',
				'flat-1',
				'flat-2',
				'flat-3',
				'flat-4',
				'image-2',
				'link-1',
				'link-2',
				'material-design-1',
				'material-design-2',
				'modern-1',
				'modern-2',
				'modern-3',
				'modern-4',
				'paper-note-1',
				'paper-note-2',
				'paper-note-3',
			)
		),
	),

	'ad_desc' => array(
		'type'    => 'text',
		'ui'   => array(
			'title'   => __( 'Ad Description', csl18n() ),
			'tooltip' => __( 'Enter Ad Description here.', csl18n() ),
		),
		'context' => 'content',
		'suggest' => __( 'Ad Description', 'ads-pro-ad-extension' ),
		'condition' => 	array(
			'ad_template' => array (
				'default',
				'default-extra',
				'facebook-1',
				'facebook-2',
				'flat-1',
				'flat-2',
				'flat-3',
				'link-2',
				'material-design-1',
				'material-design-2',
				'modern-1',
				'modern-2',
				'modern-3',
				'modern-4',
				'paper-note-1',
				'paper-note-2',
				'paper-note-3',
			)
		),
	),

	'ad_img' => array(
		'type'    => 'image',
		'ui'   => array(
			'title'   => __( 'Ad Image', csl18n() ),
			'tooltip' => __( 'Enter Ad Image here.', csl18n() ),
		),
		'condition' => 	array(
			'ad_template' => array (
				'default',
				'default-extra',
				'facebook-1',
				'facebook-2',
				'flat-3',
				'flat-4',
				'image-1',
				'image-2',
				'material-design-1',
				'material-design-2',
				'modern-1',
				'modern-2',
				'modern-3',
				'modern-4',
			)
		),
	),

	'link' => array(
		'mixin' => 'link',
	),

	'background_color' => array(
		'type' => 'color',
		'ui' => array(
			'title'   => __( 'Background Color', 'ads-pro-ad-extension' )
		),
		'condition' => 	array(
			'ad_template' => array (
				'default',
				'default-extra',
				'facebook-1',
				'facebook-2',
				'flat-1',
				'flat-2',
				'flat-3',
				'flat-4',
				'link-1',
				'link-2',
				'material-design-1',
				'material-design-2',
				'modern-1',
				'modern-2',
				'modern-3',
				'modern-4',
				'paper-note-1',
				'paper-note-2',
				'paper-note-3',
			)
		),
	),

	'title_color' => array(
	 	'type' => 'color',
	 	'ui' => array(
			'title'   => __( 'Title Color', 'ads-pro-ad-extension' )
		),
		'condition' => 	array(
			'ad_template' => array (
				'default',
				'default-extra',
				'facebook-1',
				'facebook-2',
				'flat-1',
				'flat-2',
				'flat-3',
				'flat-4',
				'image-2',
				'link-1',
				'link-2',
				'material-design-1',
				'material-design-2',
				'modern-1',
				'modern-2',
				'modern-3',
				'modern-4',
				'paper-note-1',
				'paper-note-2',
				'paper-note-3',
			)
		),
	),

	'description_color' => array(
	 	'type' => 'color',
	 	'ui' => array(
			'title'   => __( 'Description Color', 'ads-pro-ad-extension' )
		),
		'condition' => 	array(
			'ad_template' => array (
				'default',
				'default-extra',
				'facebook-1',
				'facebook-2',
				'flat-1',
				'flat-2',
				'flat-3',
				'flat-4',
				'link-2',
				'material-design-1',
				'material-design-2',
				'modern-1',
				'modern-2',
				'modern-3',
				'modern-4',
				'paper-note-1',
				'paper-note-2',
				'paper-note-3',
			)
		),
	),

	'url_color' => array(
	 	'type' => 'color',
	 	'ui' => array(
			'title'   => __( 'URL Color', 'ads-pro-ad-extension' )
		),
		'condition' => 	array(
			'ad_template' => array (
				'default',
				'default-extra',
				'facebook-1',
				'facebook-2',
				'flat-1',
				'flat-2',
				'flat-3',
				'flat-4',
				'modern-1',
				'modern-4',
				'paper-note-1',
			)
		),
	),

	'extra_color_1' => array(
	 	'type' => 'color',
	 	'ui' => array(
			'title'   => __( 'Extra Color 1', 'ads-pro-ad-extension' )
		),
		'condition' => 	array(
			'ad_template' => array (
				'flat-1',
				'flat-2',
				'flat-3',
				'image-2',
				'link-2',
				'material-design-1',
				'modern-4',
				'paper-note-1',
				'paper-note-3',
			)
		),
	),

	'extra_color_2' => array(
	 	'type' => 'color',
	 	'ui' => array(
			'title'   => __( 'Extra Color 2', 'ads-pro-ad-extension' )
		),
		'condition' => 	array(
			'ad_template' => array (
				'flat-1',
				'flat-2',
				'paper-note-1',
				'paper-note-3',
			)
		),
	),

	'ad_animation' => array(
		'type' => 'select',
		'ui'   => array(
			'title'   => __( 'Ad Animation (Visible on Live)', csl18n() ),
			'tooltip' => __( 'Select an Ad Animation for this ad.', csl18n() ),
		),
		'options' => array(
			'choices' => array(
				array( 'value' => 'none',					'label' => __( 'none', $td ) ),
				array( 'value' => 'bounce',				'label' => __( 'Bounce', $td ) ),
				array( 'value' => 'flash',				'label' => __( 'Flash', $td ) ),
				array( 'value' => 'pulse',				'label' => __( 'Pulse', $td ) ),
				array( 'value' => 'rubberBand',			'label' => __( 'Rubber Band', $td ) ),
				array( 'value' => 'shake',				'label' => __( 'Shake', $td ) ),
				array( 'value' => 'swing',				'label' => __( 'Swing', $td ) ),
				array( 'value' => 'tada',				'label' => __( 'Tada', $td ) ),
				array( 'value' => 'wobble',				'label' => __( 'Wobble', $td ) ),

				array( 'value' => 'bounceIn',			'label' => __( 'Bounce In', $td ) ),
				array( 'value' => 'bounceInDown',		'label' => __( 'Bounce In Down', $td ) ),
				array( 'value' => 'bounceInLeft',		'label' => __( 'Bounce In Left', $td ) ),
				array( 'value' => 'bounceInRight',		'label' => __( 'Bounce In Right', $td ) ),
				array( 'value' => 'bounceInUp',			'label' => __( 'Bounce In Up', $td ) ),

				array( 'value' => 'fadeIn',				'label' => __( 'Fade In', $td ) ),
				array( 'value' => 'fadeInDown',			'label' => __( 'Fade In Down', $td ) ),
				array( 'value' => 'fadeInDownBig',		'label' => __( 'Fade In Down Big', $td ) ),
				array( 'value' => 'fadeInLeft',			'label' => __( 'Fade In Left', $td ) ),
				array( 'value' => 'fadeInLeftBig',		'label' => __( 'Fade In Left Big', $td ) ),
				array( 'value' => 'fadeInRight',		'label' => __( 'Fade In Right', $td ) ),
				array( 'value' => 'fadeInRightBig',		'label' => __( 'Fade In Right Big', $td ) ),
				array( 'value' => 'fadeInUp',			'label' => __( 'Fade In Up', $td ) ),
				array( 'value' => 'fadeInUpBig',		'label' => __( 'Fade In Up Big', $td ) ),

				array( 'value' => 'flip',				'label' => __( 'Flip', $td ) ),
				array( 'value' => 'flipInX',			'label' => __( 'Flip In X', $td ) ),
				array( 'value' => 'flipInY',			'label' => __( 'Flip In Y', $td ) ),

				array( 'value' => 'lightSpeedIn',		'label' => __( 'Light Speed In', $td ) ),

				array( 'value' => 'rotateIn',			'label' => __( 'Rotate In', $td ) ),
				array( 'value' => 'rotateInDownLeft',	'label' => __( 'Rotate In Down Left', $td ) ),
				array( 'value' => 'rotateInDownRight',	'label' => __( 'Rotate In Down Right', $td ) ),
				array( 'value' => 'rotateInUpLeft',		'label' => __( 'Rotate In Up Left', $td ) ),
				array( 'value' => 'rotateInUpRight',	'label' => __( 'Rotate In Up Right', $td ) ),

				array( 'value' => 'hinge',				'label' => __( 'Hinge', $td ) ),
				array( 'value' => 'rollIn',				'label' => __( 'Roll In', $td ) ),

				array( 'value' => 'zoomIn',				'label' => __( 'Zoom In', $td ) ),
				array( 'value' => 'zoomInDown',			'label' => __( 'Zoom In Down', $td ) ),
				array( 'value' => 'zoomInLeft',			'label' => __( 'Zoom In Left', $td ) ),
				array( 'value' => 'zoomInRight',		'label' => __( 'Zoom In Right', $td ) ),
				array( 'value' => 'zoomInUp',			'label' => __( 'Zoom In Up', $td ) ),
			)
		)
	),

);