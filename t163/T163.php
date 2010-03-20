<?php
/**
 * 
 * @author cluries
 * @link http://cuies.com
 *
 */

class T163 extends Service {
	
	function __construct() {
		parent::__construct ();
	}
	
	private function login() {
		$cookieFile = tempnam ( Service::COOKIE_DIR, 't163.cookie' );
		
		$loginInfo = array ();
		
		$loginInfo ['username'] = $this->username;
		$loginInfo ['password'] = $this->password;
		
		$loginCurlHandler = curl_init ( "http://3g.163.com/t/account/tologin" );
		curl_setopt ( $loginCurlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $loginCurlHandler, CURLOPT_REFERER, "http://3g.163.com/t/session" );
		curl_setopt ( $loginCurlHandler, CURLOPT_POSTFIELDS, createKeyString ( $loginInfo ) );
		curl_setopt ( $loginCurlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		curl_setopt ( $loginCurlHandler, CURLOPT_HEADER, 0 );
		curl_setopt ( $loginCurlHandler, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $loginCurlHandler, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $loginCurlHandler, CURLOPT_RETURNTRANSFER, true );
		$t = curl_exec ( $loginCurlHandler );
		curl_close ( $loginCurlHandler );
		unset ( $loginCurlHandler );
		
		$m = array ();
		preg_match ( '/<a\s+href="(.*)">/mi', $t, $m );
		
		$url = trim ( $m [1] );
		
		$homeCurlHandler = curl_init ( $url );
		curl_setopt ( $homeCurlHandler, CURLOPT_REFERER, "http://3g.163.com/t/account/tologin" );
		curl_setopt ( $homeCurlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		curl_setopt ( $homeCurlHandler, CURLOPT_COOKIEFILE, $cookieFile );
		curl_setopt ( $homeCurlHandler, CURLOPT_RETURNTRANSFER, true );
		$t = curl_exec ( $homeCurlHandler );
		curl_close ( $homeCurlHandler );
		
		return $cookieFile;
	}
	
	protected function sendContent() {
		
		if (empty ( $this->content )) {
			return;
		}
		
		$cookieFile = $this->login ();
		
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
		 
		$post = array ('sub' => '发布','url' => 'http://3g.163.com/t/', 'status' => $content );
		$curlHandler = curl_init ( "http://3g.163.com/t/statuses/update.do" );
		curl_setopt ( $curlHandler, CURLOPT_REFERER, "http://3g.163.com/t/statuses/update.do" );
		curl_setopt ( $curlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $curlHandler, CURLOPT_POSTFIELDS, $post );
		curl_setopt ( $curlHandler, CURLOPT_FOLLOWLOCATION, TRUE );
		curl_setopt ( $curlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		curl_setopt ( $curlHandler, CURLOPT_COOKIEFILE, $cookieFile );
		curl_setopt ( $curlHandler, CURLOPT_RETURNTRANSFER, true );
		$t = curl_exec ( $curlHandler );
		curl_close ( $curlHandler );
	}
}

?>