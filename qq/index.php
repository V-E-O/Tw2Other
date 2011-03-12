<?php
@header ( 'Content-Type:text/html;charset=utf-8' );
if (file_exists ( 'tw2other_qq.lock' )) {
	exit ( 'qq目录下存在tw2other_qq.lock，请删除后再试。' );
}
function dirPs($dir) {
	return substr ( $dir, - 1 ) == '/' ? $dir : $dir . '/';
}
session_start ();
require_once ('../config.php');
@require_once ('../twitteroauth/OAuth.php');
require_once ('opent.php');

$o = new MBOpenTOAuth ( QQ_API_KEY, QQ_API_SECRET );
$keys = $o->getRequestToken ( dirPs ( TW2OTHER_URL ) . 'qq/callback.php' ); //这里填上你的回调URL
$aurl = $o->getAuthorizeURL ( $keys ['oauth_token'], false, '' );
$_SESSION ['keys'] = $keys;
?>
<a href="<?php echo $aurl?>">登录到疼讯QQ验证去</a>
