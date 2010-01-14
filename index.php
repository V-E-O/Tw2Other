<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.51
 */

define ( 'TWTO_VERSION', 0.51 );

error_reporting ( E_ALL ^ E_NOTICE );

include 'config.php';
include 'init.php';

is_continue ();
updateLastUpdateTime ();

include 'Service.php';
include 'Twitter.php';

$twitter = new Twitter ( );
$twitter->setApi ( $twitterApi );
$twitter->setUser ( $twitterUser );
$twitter->setSyncLevel ( $twitterSyncLevel );

$content = $twitter->getContent ();

foreach ( $services as $k => $v ) {
	
	if (trim ( $k ) == '') {
		continue;
	}
	
	if (trim ( $v ['username'] ) == '' || trim ( $v ['password'] ) == '') {
		continue;
	}
	
	$service = ucfirst ( $k );
	$service = new $service ( );
	$service->setUsername ( $v ['username'] );
	$service->setPassword ( $v ['password'] );
	$service->setContent ( $content );
	$service->update ();
}

?>