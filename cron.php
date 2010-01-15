<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.3
 */

$url = "";
//比如$url = "http://cuies.com/tw2other/index.php";
//这里一定要填写正确的地址

if (empty ( $url )) {
	exit ( '请先配置cron.php' );
}

$curlHandler = curl_init ( $url );

if (isset ( $_GET ['echo'] )) {
	curl_setopt ( $curlHandler, CURLOPT_RETURNTRANSFER, true );
}

curl_exec ( $curlHandler );
curl_close ( $curlHandler );

?>