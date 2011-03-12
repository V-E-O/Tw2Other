<?php
@header ( 'Content-Type:text/html;charset=utf-8' );
session_start ();
require_once ('../config.php');
@require_once ('../twitteroauth/OAuth.php');
@require_once ('opent.php');

function dirPs($dir) {
	return substr ( $dir, - 1 ) == '/' ? $dir : $dir . '/';
}

function getQQOauthFile() {
	return dirPs ( OAUTH_DIR ) . 'tw2other_qq.oauth';
}

$o = new MBOpenTOAuth ( QQ_API_KEY, QQ_API_SECRET, $_SESSION ['keys'] ['oauth_token'], $_SESSION ['keys'] ['oauth_token_secret'] );
$last_key = $o->getAccessToken ( $_REQUEST ['oauth_verifier'] ); //获取ACCESSTOKEN
if (! empty ( $last_key )) {
	$fileHandler = @fopen ( getQQOauthFile (), 'w+' );
	@fwrite ( $fileHandler, serialize ( $last_key ) );
	@fclose ( $fileHandler );
	
	$handle = @fopen ( 'tw2other_qq.lock', 'w+' );
	@fwrite ( $handle, date ( "Y-m-d H:i:s" ) );
	@fclose ( $handle );
	
	echo '授权完成 ';
} else {
	echo '授权失败';
}
?>


