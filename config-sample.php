<?php
date_default_timezone_set ( 'Etc/GMT-8' );

define ( 'INTERVAL', 50 );

define ( 'OAUTH_DIR', '../../oauth/' );
if (!file_exists(OAUTH_DIR)){
	@mkdir(OAUTH_DIR,0777,true);
}

//注意，在Twitter注册Application的时候，Application Type这一项要选中Browser 
define ( 'CONSUMER_KEY', '' );
define ( 'CONSUMER_SECRET', '' );

//填写tw2other的url，注意目录的大小写 。
define ( 'TW2OTHER_URL', 'http://cuies.com/tw2other/' );

//填写为你自己申请的SINA API KEY
//请注意,以前这里是SINA_APP_KEY，现在是SINA_API_KEY
define ( 'SINA_API_KEY', '' );
define ( 'SINA_API_SECRET', '');

 
define ( 'QQ_API_KEY', '' );
define ( 'QQ_API_SECRET', '' );

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
$services = array ("sina" => array('oauth'=>true),
			 "digu" => array ('username' => 'your_username', 'password' => '' ), 
			 "zuosa" => array ('username' => 'your_username', 'password' => '' ),
		 "follow5" => array ('username' => 'your_username', 'password' => '' ), 
		 "renjian" => array ('username' => 'your_username', 'password' => '' ), 
		 "douban" => array ('username' => 'your_email', 'password' => '' ), 
		 "xianguo" => array ('username' => 'your_email', 'password' => '' ),
/*T9911就是9911.com*/ "t9911" => array ('username' => 'your_username', 'password' => '' ), 
/*T163就是163.com*/ "t163" => array ('username' => 'your_email', 'password' => '' ),
 "renren" => array ('username' => 'your_email', 'password' => '' ), 
 "fanfou" => array ('username' => 'your_email', 'password' => '' ),
	"qq"=>array('oauth'=>true) );

?>