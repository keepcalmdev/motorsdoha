<?php

/**
 * Shortcode definition
 */

$space_id   		= ( $space_id  != '' ) ? $space_id : null;
$max_width   		= ( $max_width  != '' ) ? 'max_width='.$max_width : null;
$delay   			= ( $delay  != '' ) ? 'delay='.$delay : null;
$padding_top   		= ( $padding_top  != '' ) ? 'padding_top='.$padding_top : null;
$attachment   		= ( $attachment  != '' ) ? 'attachment='.$attachment : null;
$crop   			= ( $crop  != '' ) ? 'crop='.$crop : null;
$hide_for_id   		= ( $hide_for_id  != '' ) ? 'hide_for_if='.$hide_for_id : null;
$if_empty   		= ( $if_empty  != '' ) ? 'if_empty='.$if_empty : null;
?>

<div <?php cs_atts( array( 'id' => $id, 'class' => $class, 'style' => $style ) ); ?>>
	<?php if ( isset( $space_id ) && $space_id > 0 ): ?>
		<?php echo
		do_shortcode('[bsa_pro_ad_space id="'.$space_id.'" '.$max_width.' '.$delay.' '.$padding_top.' '.$attachment.' '.$crop.' '.$hide_for_id.' '.$if_empty.']') ?>
	<?php endif; ?>
</div>