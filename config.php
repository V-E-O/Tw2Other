<?php
if (! defined ( 'TWTO_VERSION' )) {
	exit ();
}

define ( 'INTERVAL', 60 );

$twitterApi = 'http://twitter.com/';

$twitterUser = 'cluries';

$services = array ("sina" => array ('username' => 'you_username', 'password' => 'you_password' ), 
					"digu" => array ('username' => 'you_username', 'password' => 'you_password' ),
					"zuosa" => array ('username' => 'you_username', 'password' => 'you_password' ), 
					 );

?>