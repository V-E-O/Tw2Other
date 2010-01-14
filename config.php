<?php
if (! defined ( 'TWTO_VERSION' )) {
	exit ();
}

define ( 'INTERVAL', 50 );

$twitterApi = 'http://twitter.com/';

//你的twitter用户名
$twitterUser = '';

/**
 * 0：不过滤
 * 1：过滤回复别人的tweet
 * 2：过滤RT别人的推	
 * 3：只同步自己的tweet,推中不包含RT,@字样
 *  
 */
$twitterSyncLevel = 0;

/**
 * 请填写你的follow5 api_key
 * 如果不同步到follow5，就不用填写
 * 获取follow5 api_key的办法见follow5主页
 * 关于为什么不公开提供api_key
 * 详见：http://intgu.com/post/now-the-follow5-model-in-tw2other-is-not-public.html
 */
$follow5ApiKey = '';


$services = array ("sina" => array ('username' => 'your_email', 'password' => 'your_password' ), 
					"digu" => array ('username' => 'your_username', 'password' => 'your_password' ),
					"zuosa" => array ('username' => 'your_username', 'password' => 'your_password' ), 
					"follow5" => array ('username' => 'your_username', 'password' => 'your_password' ), 
					"douban" => array ('username' => 'your_email', 'password' => 'your_password' ), 
					"xianguo" => array ('username' => 'your_email', 'password' => 'your_password' ),
/*T9911就是9911.com*/ "T9911" => array ('username' => 'your_username', 'password' => 'your_password' ), 
					 );

?>