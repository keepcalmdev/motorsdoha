<?php

/**
 * Element Definition
 */

class BSA_PRO_Ad_Space {

	public function ui() {
		return array(
		  'title'       => __( 'Get Ad Space ADS PRO', 'ads-pro-ad-space' ),
		  'autofocus' => array(
				'heading' => 'h4.ads-pro-space-heading',
				'content' => '.ads-pro-space-item'
			),
			'icon_group' => 'ads-pro-ad-space'
		);
	}

	public function getAdSpaces($count = null) {
		if ( class_exists('BSA_PRO_Model') ) {
			$model = new BSA_PRO_Model();
			if ( $count == 'first' ) {
				$firstSpace = $model->getSpaces();
				return $firstSpace[0]['id'];
			} else {
				return $model->getSpaces();
			}
		} else {
			return null;
		}
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