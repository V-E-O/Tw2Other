<?php
@header ( 'Content-Type:text/html;charset=utf-8' );
session_start ();
if (empty ( $_SESSION ['key'] )) {
	exit ( 'SESSION中没找到对应的KEY' );
}
require_once ('../config.php');
@require_once ('../twitteroauth/OAuth.php');
@require_once ('SinaOauth.php');

function dirPs($dir) {
	return substr ( $dir, - 1 ) == '/' ? $dir : $dir . '/';
}

function getSinaOauthFile() {
	$p = dirPs ( OAUTH_DIR );
	if (substr ( $p, 0, 3 ) != '../') {
		return dirPs ( OAUTH_DIR ) . 'tw2other_sina.oauth';
	}
	
	return '../' . $p . 'tw2other_sina.oauth';
}

$o = new SinaOauth ( SINA_API_KEY, SINA_API_SECRET, $_SESSION ['key'] ['oauth_token'], $_SESSION ['key'] ['oauth_token_secret'] );
unset ( $_SESSION ['key'] );
$last_key = $o->getAccessToken ( $_REQUEST ['oauth_verifier'] );
if (! empty ( $last_key ['oauth_token'] ) && ! empty ( $last_key ['oauth_token_secret'] )) {
	
	$fileHandler = @fopen ( getSinaOauthFile (), 'w+' );
	@fwrite ( $fileHandler, serialize ( $last_key ) );
	@fclose ( $fileHandler );
	
	$handle = @fopen ( 'tw2other_sina.lock', 'w+' );
	@fwrite ( $handle, date ( "Y-m-d H:i:s" ) );
	@fclose ( $handle );
	
	echo '授权完成 ';
} else {
	print_r ( $last_key );
	echo '<br />';
	echo '授权失败';
}
?>