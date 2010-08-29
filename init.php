<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.4
 */

//define ( 'SOURCE', '<a href="http://cuies.com/">Tw2ohter</a>' );
define ( 'SOURCE', 'Tw2ohter' );

//Tw2other
define ( 'CONSUMER_KEY', '5xb2INFvAZHcLLz1iHQ2A' );
define ( 'CONSUMER_SECRET', 'NNJAppLCPA3UHxCwy2i2i7nzPM8qaddF5OsKyALTRHE' );

function defaultExceptionHandler(TwtoException $e) {
	echo $e->getMessage ();
}

function duplicateHeader($curl, $header) {
	$duplicate = trim ( $header );
	header ( $duplicate );
	return strlen ( $header );

}

function createKeyString($data) {
	return http_build_query ( $data );
}

function __autoload($className = '') {
	if (empty ( $className )) {
		return;
	}
	
	$file = strtolower ( $className ) . '/' . $className . '.php';
	
	if (file_exists ( $file )) {
		include $file;
	}
}

function updateLastUpdateTime() {
	$fileHandler = @fopen ( 'update.time', 'w+' );
	@fwrite ( $fileHandler, time () );
	@fclose ( $fileHandler );
}

function getOauth() {
	if (file_exists ( OAUTH_DIR . 'tw2other.oauth' )) {
		return file_get_contents ( OAUTH_DIR . 'tw2other.oauth' );
	}
	return null;
}

function updateOauth($oauth) {
	$oauth = serialize ( $oauth );
	$fileHandler = @fopen ( OAUTH_DIR . 'tw2other.oauth', 'w+' );
	@fwrite ( $fileHandler, $oauth );
	@fclose ( $fileHandler );
}

function check() {
	if (! file_exists ( 'config.php' )) {
		echo "<h1>请先配置config.php</h1>";
		exit ();
	}
	
	if (! function_exists ( 'curl_init' )) {
		exit ( '环境不支持CURL' );
	}
	
	if (file_exists ( 'update.time' )) {
		$lastTime = file_get_contents ( 'update.time' );
		if (trim ( $lastTime ) + INTERVAL > time () - 1) {
			exit ( 'Can\'t update now!' );
		}
	}
	
	if (! is_dir ( OAUTH_DIR )) {
		if (! mkdir ( OAUTH_DIR, 0777, true )) {
			exit ( 'OAUTH_DIR VALUE WRONG!' );
		}
	}
	
	$oauth = getOauth ();
	if (empty ( $oauth )) {
		header ( 'Location:connect.php' );
		exit ();
	}
}
?>