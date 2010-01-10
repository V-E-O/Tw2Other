<?php
if (! defined ( 'TWTO_VERSION' )) {
	exit ();
}

define ( 'INTERVAL', 50 );

$twitterApi = 'http://twitter.com/';

$twitterUser = 'cluries';

/**
 * 0：不过滤
 * 1：过滤回复别人的tweet
 * 2：过滤RT别人的推	
 * 3：只同步自己的tweet,推中不包含RT,@字样
 *  
 */
$twitterSyncLevel = 0;

$services = array ("sina" => array ('username' => 'your_username', 'password' => 'your_password' ), 
					"digu" => array ('username' => 'your_username', 'password' => 'your_password' ),
					"zuosa" => array ('username' => 'your_username', 'password' => 'your_password' ), 
					"follow5" => array ('username' => 'your_username', 'password' => 'your_password' ), 
					"douban" => array ('username' => 'your_username', 'password' => 'your_password' ), 
					/*T9911就是9911.com*/ "T9911" => array ('username' => 'your_username', 'password' => 'your_password' ), 
					 );

?>