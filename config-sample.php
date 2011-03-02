<?php

define ( 'INTERVAL', 50 );

define ( 'OAUTH_DIR', '../../oauth/' );

//注意，在Twitter注册Application的时候，Application Type这一项要选中Browser 
define ( 'CONSUMER_KEY', '5xb2INFvAZHcLLz1iHQ2A' );
define ( 'CONSUMER_SECRET', 'NNJAppLCPA3UHxCwy2i2i7nzPM8qaddF5OsKyALTRHE' );

//Application Type这一项选中Browser后，Callback URL这里面填写你自己tw2other里面callback.php的URL
define ( 'OAUTH_CALLBACK', 'http://cuies.com/tw2other/callback.php' );

//填写为你自己申请的SINA API KEY
define ( 'SINA_APP_KEY', '' );

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
 * 详见：http://cuies.com/post/now-the-follow5-model-in-tw2other-is-not-public.html
 */
$follow5ApiKey = '';

//username对应登录名
//password对应登录密码
$services = array ("sina" => array ('username' => 'your_email', 'password' => '' ), "digu" => array ('username' => 'your_username', 'password' => '' ), "zuosa" => array ('username' => 'your_username', 'password' => '' ), "follow5" => array ('username' => 'your_username', 'password' => '' ), "renjian" => array ('username' => 'your_username', 'password' => '' ), "douban" => array ('username' => 'your_email', 'password' => '' ), "xianguo" => array ('username' => 'your_email', 'password' => '' ),
/*T9911就是9911.com*/ "t9911" => array ('username' => 'your_username', 'password' => '' ), 
/*T163就是163.com*/ "t163" => array ('username' => 'your_email', 'password' => '' ), "renren" => array ('username' => 'your_email', 'password' => '' ), "fanfou" => array ('username' => 'your_email', 'password' => '' ) );

?>