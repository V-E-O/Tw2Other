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

//username对应登录名
//password对应登录密码
$services = array ("sina" => array ('username' => 'your_email', 'password' => '' ), 
					"digu" => array ('username' => 'your_username', 'password' => '' ),
					"zuosa" => array ('username' => 'your_username', 'password' => '' ), 
					"follow5" => array ('username' => 'your_username', 'password' => '' ),
					"renjian" => array ('username' => 'your_username', 'password' => '' ),
					"douban" => array ('username' => 'your_email', 'password' => '' ), 
					"xianguo" => array ('username' => 'your_email', 'password' => '' ),
/*T9911就是9911.com*/ "t9911" => array ('username' => 'your_username', 'password' => '' ), 
					"renren" => array ('username' => 'your_email', 'password' => '' ),
					 );

?>