<?php

include_once 'qq/opent.php';

class Qq extends Service {
	
	private $_aouth = null;
	
	public function __construct() {
		parent::__construct ();
		$auth = $this->getQQAuth ();
		$this->_aouth = new MBOpenTOAuth ( QQ_API_KEY, QQ_API_SECRET, $auth ['oauth_token'], $auth ['oauth_token_secret'] );
	}
	
	public function sendItem($content) {
		$q = array ('c' => $content, 'ip' => $_SERVER ['REMOTE_ADDR'], 'j' => '', 'w' => '' );
		$params = array ('format' => 'json', 'content' => $content, 'clientip' => $_SERVER ['REMOTE_ADDR'], 'jing' => '', 'wei' => '' );
		$url = 'http://open.t.qq.com/api/t/add?f=1';
		return $this->_aouth->post ( $url, $params );
	}
	
	private function getQQAuth() {
		if (file_exists ( getQQOauthFile () )) {
			$content = file_get_contents ( getQQOauthFile () );
			$auth = unserialize ( $content );
			return $auth;
		}
		
		return null;
	}

}

?>