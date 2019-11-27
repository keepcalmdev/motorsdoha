<?php

//get site translations
global $wpdb;
if(!isset($wpdb))
{
    require_once('../../../wp-config.php');
    require_once('../../../wp-includes/wp-db.php');
}

$results = $wpdb->get_results( "SELECT * FROM  wp_trp_gettext_ar WHERE domain ='motors' 
	AND id !='2050' 
	AND id!='2280' 
	AND id != '2284'
	");

echo json_encode($results);


?>