<?php 
//numverify
$key = "529b2a573f050611cbdccb8aecd0c794";
$number=""; //14158586273

if(isset($_GET["number"]) && !empty($_GET["number"])){
	$number = $_GET["number"];
}


if( $curl = curl_init() ) {
	// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, 'http://apilayer.net/api/validate?access_key='.$key.'&number='.$number);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);
    echo $out;
    curl_close($curl);
 }

?>