<?php

/**
 * Shortcode definition
 */

$ad_template   		= ( $ad_template  != '' ) ? $ad_template : 'default';
$ad_animation   	= ( $ad_animation  != '' ) ? $ad_animation : 'none';
$ad_title   		= ( $ad_title  != '' ) ? $ad_title : 'Ad Title';
$ad_desc   			= ( $ad_desc  != '' ) ? $ad_desc : 'Ad Description';
$ad_img				= ( $ad_img  != '' ) ? $ad_img : 'Ad Image';
$link_link_url		= ( $link_link_url  != '' ) ? $link_link_url : 'Ad URL';
?>

<div <?php cs_atts( array( 'id' => $id, 'class' => $class, 'style' => $style ) ); ?>>
	<?php require( BSA_PRO_EXTENSION_PATH . 'assets/templates/' . $ad_template . '.php' ); ?>
</div>