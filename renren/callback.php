<?php
@header ( 'Content-Type:text/html;charset=utf-8' );
require_once ('../config.php');
@require_once ('../twitteroauth/OAuth.php');
@require_once ('RenrenOauth.php');

function dirPs($dir) {
	return substr ( $dir, - 1 ) == '/' ? $dir : $dir . '/';
}

function getRenrenOauthFile() {
	$p = dirPs ( OAUTH_DIR );
	if (substr ( $p, 0, 3 ) != '../') {
		return dirPs ( OAUTH_DIR ) . 'tw2other_renren.oauth';
	}
	
	return '../' . $p . 'tw2other_renren.oauth';
}
$callback = dirPs ( TW2OTHER_URL ) . 'renren/callback.php';
$o = new RenrenOauth ();
$last_key = $o->getAccessToken ( $_REQUEST ['code'], $callback );
if (! empty ( $last_key ['access_token'] ) && ! empty ( $last_key ['refresh_token'] )) {
	
	$fileHandler = @fopen ( getRenrenOauthFile (), 'w+' );
	@fwrite ( $fileHandler, serialize ( $last_key ) );
	@fclose ( $fileHandler );
	
	$handle = @fopen ( 'tw2other_renren.lock', 'w+' );
	@fwrite ( $handle, date ( "Y-m-d H:i:s" ) );
	@fclose ( $handle );
	
	echo '授权完成 ';
} else {
	print_r ( $last_key );
	echo '<br />';
	echo '授权失败';
}
?>
