<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.1
 */
 
 
$url = "";
//����$url = "http://intgu.com/tw2other/index.php";

if (empty ( $url )) {
	exit ( '��������cron.php' );
}

$curlHandler = curl_init ( $url );

if (isset ( $_GET ['echo'] )) {
	curl_setopt ( $curlHandler, CURLOPT_RETURNTRANSFER, true );
}

curl_exec ( $curlHandler );
curl_close ( $curlHandler );

?>