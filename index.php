<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.1
 */

define ( 'TWTO_VERSION', 0.1 );

error_reporting ( E_ALL ^ E_NOTICE );

include 'config.php';
include 'init.php';

is_continue ();
updateLastUpdateTime ();

include 'IService.php';
include 'Twitter.php';

$twitter = new Twitter ( );
$twitter->setApi ( $twitterApi );
$twitter->setUser ( $twitterUser );

$content = $twitter->getContent ();

foreach ( $services as $k => $v ) {
	
	$service = ucfirst ( $k );
	$service = new $service ( );
	$service->setUsername ( $v ['username'] );
	$service->setPassword ( $v ['password'] );
	$service->setContent ( $content );
	$service->update ();
}

?>