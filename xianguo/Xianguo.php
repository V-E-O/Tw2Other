<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.1
 */

class Xianguo extends Service {
	
	function __construct() {
		parent::__construct ();
	}
	
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	private function login() {
		$cookieFile = tempnam ( Service::COOKIE_DIR, 'xianguo.cookie' );
		
		$loginInfo = array ();
		$loginInfo ['rurl'] = '';
		$loginInfo ['code'] = '';
		$loginInfo ['email'] = $this->username;
		$loginInfo ['password'] = $this->password;
		
		$loginCurlHandler = curl_init ( "http://bo.xianguo.com/login" );
		curl_setopt ( $loginCurlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $loginCurlHandler, CURLOPT_REFERER, "http://bo.xianguo.com/login" );
		curl_setopt ( $loginCurlHandler, CURLOPT_POSTFIELDS, createKeyString ( $loginInfo ) );
		curl_setopt ( $loginCurlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		curl_setopt ( $loginCurlHandler, CURLOPT_HEADER, 0 );
		curl_setopt ( $loginCurlHandler, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $loginCurlHandler, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $loginCurlHandler, CURLOPT_RETURNTRANSFER, true );
		curl_exec ( $loginCurlHandler );
		curl_close ( $loginCurlHandler );
		
		return $cookieFile;
	}
	
	private function toIndex($cookieFile) {
		
		$indexCurlHandler = curl_init ( "http://bo.xianguo.com/home" );
		curl_setopt ( $indexCurlHandler, CURLOPT_REFERER, '	http://bo.xianguo.com/login?rurl=%2F' );
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
		
		$cookieFile = $this->login ();
		//$this->toIndex ( $cookieFile );
		
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
		$post = array ('content' => $content, 'picture' => '', 'render' => '0', 'topic' => '' );
		
		$curlHandler = curl_init ();
		curl_setopt ( $curlHandler, CURLOPT_URL, "http://bo.xianguo.com/doings/add" );
		curl_setopt ( $curlHandler, CURLOPT_REFERER, "http://bo.xianguo.com/home" );
		curl_setopt ( $curlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $curlHandler, CURLOPT_POSTFIELDS, createKeyString ( $post ) );
		curl_setopt ( $curlHandler, CURLOPT_COOKIEFILE, $cookieFile );
		curl_setopt ( $curlHandler, CURLOPT_RETURNTRANSFER, true );
		curl_exec ( $curlHandler );
		curl_close ( $curlHandler );
	}
}

?>