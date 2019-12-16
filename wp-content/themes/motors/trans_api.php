<?php
//get site translations
global $wpdb;
if(!isset($wpdb))
{
    require_once('../../../wp-config.php');
    require_once('../../../wp-includes/wp-db.php');
}
$results = $wpdb->get_results( "SELECT * FROM  wp_trp_dictionary_en_us_ar");
echo json_encode($results);
?>