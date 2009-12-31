<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.1
 */


define ( 'SOURCE', '<a href="http://intgu.com/page/twto/">Twto</a>' );

is_go ();

updateLastUpdateTime ();

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

function is_go() {
	if (! file_exists ( 'update.time' )) {
		return;
	}
	
	$lastTime = file_get_contents ( 'update.time' );
	
	if (! defined ( 'INTERVAL' )) {
		define ( 'INTERVAL', 240 );
	}
	
	if (trim ( $lastTime ) + INTERVAL < time ()) {
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