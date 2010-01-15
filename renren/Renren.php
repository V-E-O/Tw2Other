<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.1
 */

class Renren extends Service {
	
	function __construct() {
		parent::__construct ();
	}
	
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	private function login() {
		$cookieFile = tempnam ( Service::COOKIE_DIR, 'renren.cookie' );
		
		$loginInfo = array ();
		
		$loginInfo ['email'] = $this->username;
		$loginInfo ['password'] = $this->password;
		$loginInfo ['autoLogin'] = 'true';
		
		$loginCurlHandler = curl_init ( "http://passport.renren.com/PLogin.do" );
		curl_setopt ( $loginCurlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $loginCurlHandler, CURLOPT_REFERER, "http://passport.renren.com/PLogin.do" );
		curl_setopt ( $loginCurlHandler, CURLOPT_POSTFIELDS, createKeyString ( $loginInfo ) );
		curl_setopt ( $loginCurlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		curl_setopt ( $loginCurlHandler, CURLOPT_HEADER, 0 );
		curl_setopt ( $loginCurlHandler, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $loginCurlHandler, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $loginCurlHandler, CURLOPT_RETURNTRANSFER, true );
		$t = curl_exec ( $loginCurlHandler );
		curl_close ( $loginCurlHandler );
		
		$t = trim ( $t );
		$r = array ();
		preg_match ( '/<a href="https?:\/\/.*\/(callback.do\?.*)">/i', $t, $r );
		
		$result = array ();
		$result ['cookieFile'] = $cookieFile;
		$result ['url'] = trim ( $r [1] );
		return $result;
	}
	
	private function goHome($cookieFile, $url) {
		$indexCurlHandler = curl_init ( "http://www.renren.com/{$url}" );
		curl_setopt ( $indexCurlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		curl_setopt ( $indexCurlHandler, CURLOPT_COOKIEFILE, $cookieFile );
		curl_setopt ( $indexCurlHandler, CURLOPT_RETURNTRANSFER, true );
		curl_exec ( $indexCurlHandler );
		curl_close ( $indexCurlHandler );
		unset ( $indexCurlHandler );
	}
	
	protected function sendContent() {
		
		if (empty ( $this->content )) {
			return;
		}
		
		$result = $this->login ();
		$cookieFile = $result ['cookieFile'];
		$this->goHome ( $cookieFile, $result ['url'] );
		
		if (is_array ( $this->content )) {
			foreach ( $this->content as $value ) {
				$this->sendItem ( $value, $cookieFile );
			}
		} else {
			$this->sendItem ( $this->content, $cookieFile );
		}
		
		if (file_exists ( $cookieFile )) {
			unlink ( $cookieFile );
		}
	}
	
	protected function sendItem($content, $cookieFile) {
		$content = urlencode ( $content );
		$post = array ('c' => $content, 'isAtHome' => '1', 'raw' => $content );
		
		$curlHandler = curl_init ();
		curl_setopt ( $curlHandler, CURLOPT_URL, "http://status.renren.com/doing/update.do" );
		curl_setopt ( $curlHandler, CURLOPT_REFERER, "http://www.renren.com/Home.do" );
		curl_setopt ( $curlHandler, CURLOPT_FOLLOWLOCATION, TRUE );
		curl_setopt ( $curlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $curlHandler, CURLOPT_POSTFIELDS, createKeyString ( $post ) );
		curl_setopt ( $curlHandler, CURLOPT_COOKIEFILE, $cookieFile );
		curl_setopt ( $curlHandler, CURLOPT_RETURNTRANSFER, true );
		curl_exec ( $curlHandler );
		curl_close ( $curlHandler );
	}
}

?>