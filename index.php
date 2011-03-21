<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.9
 */

define ( 'TWTO_VERSION', 0.9 );

error_reporting ( E_ALL ^ E_NOTICE );

date_default_timezone_set ( 'Etc/GMT-8' );

include 'config.php';
include 'init.php';

check ();
updateLastUpdateTime ();

include 'Service.php';
include 'Twitter.php';

$twitter = new Twitter ();
$twitter->setSyncLevel ( $twitterSyncLevel );

$content = $twitter->getContent ();

foreach ( $services as $k => $v ) {
	
	if (trim ( $k ) == '') {
		continue;
	}
	
	if (empty ( $v ['oauth'] ) && (trim ( $v ['username'] ) == '' || trim ( $v ['password'] ) == '')) {
		continue;
	}
	
	$service = ucfirst ( $k );
	$service = new $service ();
	$service->setUsername ( $v ['username'] );
	$service->setPassword ( $v ['password'] );
	$service->setContent ( $content );
	$service->update ();
}

?>