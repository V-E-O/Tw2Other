<?php
@header ( 'Content-Type:text/html;charset=utf-8' );

if (file_exists ( 'tw2other_renren.lock' )) {
	exit ( 'renren目录下存在tw2other_renren.lock，请删除后再试。' );
}
require_once ('../config.php');
require_once ('../twitteroauth/OAuth.php');

require_once '../config.php';

if (!defined('RENREN_API_KEY')) {
	exit('请先填写RENREN_API_KEY');
}
if (!defined('RENREN_API_SECRET')) {
	exit('请先填写RENREN_API_SECRET');
}

include 'RenrenOauth.php';
$callback = dirPs ( TW2OTHER_URL ) . 'renren/callback.php';
$so = new RenrenOauth ();
$authorizeURL = $so->getAuthorizeURL ( RENREN_API_KEY, 'status_update', $callback );

function dirPs($dir) {
	return substr ( $dir, - 1 ) == '/' ? $dir : $dir . '/';
}
?>

<a href="<?php
echo $authorizeURL;
?>">Auth @ renren.com</a>
