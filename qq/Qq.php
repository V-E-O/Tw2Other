<?php

include_once 'qq/opent.php';

class Qq extends Service {
	
	const KEY = 'e6fbbf16f6264aebbf3c090a83ba2931';
	const SECRET = '99eae2a938d7dd70874a42d3751754b6';
	
	private $_aouth = null;
	
	public function __construct() {
		parent::__construct ();
		$auth = $this->getQQAuth ();
		$this->_aouth = new MBOpenTOAuth ( Qq::KEY, Qq::SECRET, $auth ['oauth_token'], $auth ['oauth_token_secret'] );
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