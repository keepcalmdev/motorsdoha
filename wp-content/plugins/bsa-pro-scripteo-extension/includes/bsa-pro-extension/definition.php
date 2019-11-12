<?php

/**
 * Element Definition
 */

class BSA_PRO_Ad_Extension {

	public function ui() {
		return array(
      'title'       => __( 'Ad Template ADS PRO', 'ads-pro-ad-extension' ),
      'autofocus' => array(
    		'heading' => 'h4.ads-pro-extension-heading',
    		'content' => '.ads-pro-extension-item'
    	),
    	'icon_group' => 'ads-pro-ad-extension'
    );
	}

//	public function update_build_shortcode_atts( $atts ) {
//
//		// This allows us to manipulate attributes that will be assigned to the shortcode
//		// Here we will inject a background-color into the style attribute which is
//		// already present for inline user styles
//		if ( !isset( $atts['style'] ) ) {
//			$atts['style'] = '';
//		}
//
//
//		if ( isset( $atts['background_color'] ) ) {
//			$atts['style'] .= ' background-color: ' . $atts['background_color'] . ';';
//			unset( $atts['background_color'] );
//		}
//
//		return $atts;
//
//	}


}