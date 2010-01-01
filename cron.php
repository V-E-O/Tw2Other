<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.1
 */
 
 
$url = "";
//╠ххГ$url = "http://intgu.com/tw2other/index.php";

if (empty ( $url )) {
	exit ( 'гКохеДжцcron.php' );
}

$curlHandler = curl_init ( $url );

if (isset ( $_GET ['echo'] )) {
	curl_setopt ( $curlHandler, CURLOPT_RETURNTRANSFER, true );
}

curl_exec ( $curlHandler );
curl_close ( $curlHandler );

?>