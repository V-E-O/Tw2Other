<?php
$url = "http://intgu.com/tw2other/index.php";

$curlHandler = curl_init ( $url );

curl_exec ( $curlHandler );
curl_close ( $curlHandler );

?>