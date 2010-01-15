<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.3
 */

define ( 'SOURCE', '<a href="http://cuies.com/">Tw2ohter</a>' );

function defaultExceptionHandler(TwtoException $e) {
	echo $e->getMessage ();
}

function duplicateHeader($curl, $header) {
	$duplicate = trim ( $header );
	header ( $duplicate );
	return strlen ( $header );

}

function createKeyString($data) {
	if (! is_array ( $data )) {
		return "content={$data}";
	}
	
	$string = '';
	foreach ( $data as $k => $v ) {
		$string .= "{$k}={$v}&";
	}
	
	return substr ( $string, 0, - 1 );
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

function checkConfigFile() {
	
	global $twitterApi;
	global $twitterUser;
	global $services;
	
	if (empty ( $twitterApi ) || empty ( $twitterUser ) || ! is_array ( $services )) {
		echo "<h1>请先配置config.php</h1>";
		exit ();
	}
}

function is_continue() {
	
	if (! function_exists ( 'curl_init' )) {
		exit ( '环境不支持CURL' );
	}
	
	checkConfigFile ();
	
	if (! file_exists ( 'update.time' )) {
		return;
	}
	
	$lastTime = file_get_contents ( 'update.time' );
	
	if (! defined ( 'INTERVAL' )) {
		define ( 'INTERVAL', 50 );
	}
	
	if (trim ( $lastTime ) + INTERVAL < time ()-1) {
		return;
	}
	
	exit ( 'Can\'t update now!' );
}

function updateLastUpdateTime() {
	$fileHandler = @fopen ( 'update.time', 'w+' );
	@fwrite ( $fileHandler, time () );
	@fclose ( $fileHandler );
}

?>