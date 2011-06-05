<?php
@header ( 'Content-Type:text/html;charset=utf-8' );

if (file_exists ( 'tw2other_sina.lock' )) {
	exit ( 'sina目录下存在tw2other_sina.lock，请删除后再试。' );
}
require_once ('../config.php');
require_once ('../twitteroauth/OAuth.php');

require_once '../config.php';

if (!defined('SINA_API_KEY')) {
	exit('请先填写SINA_API_KEY');
}
if (!defined('SINA_API_SECRET')) {
	exit('请先填写SINA_API_SECRET');
}

include 'SinaOauth.php';
session_start ();
$callback = dirPs ( TW2OTHER_URL ) . 'sina/callback.php';
$so = new SinaOauth ( SINA_API_KEY, SINA_API_SECRET );
$token = $so->getRequestToken ( $callback );
$_SESSION ['key'] = $token;
$authorizeURL = $so->getAuthorizeURL ( $token, $callback );

function dirPs($dir) {
	return substr ( $dir, - 1 ) == '/' ? $dir : $dir . '/';
}
?>

<a href="<?php
echo $authorizeURL;
?>">去新浪漾证</a>