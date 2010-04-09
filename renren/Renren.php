<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.2
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
		$loginInfo ['origURL'] = '/home.do';
		$loginInfo ['login'] = '登录';
		
		$loginCurlHandler = curl_init ( "http://3g.renren.com/login.do?fx=0&autoLogin=true" );
		curl_setopt ( $loginCurlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $loginCurlHandler, CURLOPT_REFERER, "http://wap.renren.com/" );
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
		preg_match ( '/<a href="(https?:\/\/.*)">/i', $t, $r );
		
		$result = array ();
		$result ['cookieFile'] = $cookieFile;
		$result ['url'] = trim ( $r [1] );
		
		return $result;
	}
	
	private function goHome($cookieFile, $url) {
		$indexCurlHandler = curl_init ( $url );
		curl_setopt ( $indexCurlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		curl_setopt ( $indexCurlHandler, CURLOPT_COOKIEFILE, $cookieFile );
		curl_setopt ( $indexCurlHandler, CURLOPT_RETURNTRANSFER, true );
		$t = curl_exec ( $indexCurlHandler );
		curl_close ( $indexCurlHandler );
		unset ( $indexCurlHandler );
		
		$r = array ();
		preg_match ( '/action="(https?:\/\/.*?)"/i', $t, $r );
		
		return $r [1];
	}
	
	protected function sendContent() {
		
		if (empty ( $this->content )) {
			return;
		}
		
		$result = $this->login ();
		$cookieFile = $result ['cookieFile'];
		$url = $this->goHome ( $cookieFile, $result ['url'] );
		
		if (is_array ( $this->content )) {
			foreach ( $this->content as $value ) {
				$this->sendItem ( $value, $cookieFile, $url );
			}
		} else {
			$this->sendItem ( $this->content, $cookieFile, $url );
		}
		
		if (file_exists ( $cookieFile )) {
			unlink ( $cookieFile );
		}
	}
	
	protected function sendItem($content, $cookieFile, $url) {
		$url = urldecode($url);
		$content = urlencode ( $content );
		$post = array ('position' => 4, 'sour' => 'home', 'status' => $content, 'update' => '更新' );
		$curlHandler = curl_init ();
		curl_setopt ( $curlHandler, CURLOPT_URL, $url );
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