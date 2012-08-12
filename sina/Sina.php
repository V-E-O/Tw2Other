<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.4
 */

include 'sina/SinaOauth.php';

class Sina extends Service {
	
	protected $_so;
	
	public function __construct() {
		parent::__construct ();
		$auth = $this->getAuth ();
		$this->_so = new SinaOauth ( SINA_API_KEY, SINA_API_SECRET, $auth ['oauth_token'], $auth ['oauth_token_secret'] );
	}
	
	public function sendItem($content) {
		$params = array ('status' => $content );
		$url = 'https://api.weibo.com/2/statuses/update.json';
		echo $this->_so->oAuthRequest ( $url, 'POST', $params );
	}
	
	private function getAuth() {
		$oauth = dirPs ( OAUTH_DIR ) . 'tw2other_sina.oauth';
		if (file_exists ( $oauth )) {
			$content = file_get_contents ( $oauth );
			$auth = unserialize ( $content );
			return $auth;
		}
		
		return null;
	}

}

?>