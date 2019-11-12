<?php

/**
 * Defaults Values
 */

$getSpaces = new BSA_PRO_Ad_Space();

return array(
	'space_id'	    	=> $getSpaces->getAdSpaces('first'),
	'max_width'         => '',
	'delay'             => '',
	'padding_top'       => '',
	'attachment'        => '',
	'crop'              => '',
	'hide_for_id'       => '',
	'if_empty'          => '',
	'id'                => '',
	'class'             => '',
	'style'             => '',
);