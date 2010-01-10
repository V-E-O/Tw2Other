<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.3
 */

class Sina extends Service {
	
	function __construct() {
		parent::__construct ();
	}
	
	/**
	 * get sina login url
	 *
	 * @return string
	 */
	private function getLoginUrl() {
		$loginUrl = 'https://login.sina.com.cn/sso/login.php';
		return $loginUrl . "?username={$this->username}&password={$this->password}&returntype=TEXT";
	}
	
	/**
	 * login
	 *
	 * @return unknown
	 */
	private function login() {
		$cookieFile = tempnam ( Service::COOKIE_DIR, 'sina.cookie' );
		
		$loginCurlHandler = curl_init ( $this->getLoginUrl () );
		curl_setopt ( $loginCurlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		
		curl_setopt ( $loginCurlHandler, CURLOPT_HEADER, 0 );
		curl_setopt ( $loginCurlHandler, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $loginCurlHandler, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $loginCurlHandler, CURLOPT_RETURNTRANSFER, true );
		curl_exec ( $loginCurlHandler );
		curl_close ( $loginCurlHandler );
		
		return $cookieFile;
	}
	
	/**
	 * send content
	 *
	 */
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
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $content
	 * @param unknown_type $cookieFile
	 */
	protected function sendItem($content, $cookieFile) {
		
		$content = urlencode($content);
		
		$curlHandler = curl_init ();
		curl_setopt ( $curlHandler, CURLOPT_URL, "http://t.sina.com.cn/mblog/publish.php" );
		curl_setopt ( $curlHandler, CURLOPT_REFERER, "http://t.sina.com.cn" );
		curl_setopt ( $curlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $curlHandler, CURLOPT_POSTFIELDS, "content=" . $content );
		curl_setopt ( $curlHandler, CURLOPT_COOKIEFILE, $cookieFile );
		curl_setopt ( $curlHandler, CURLOPT_RETURNTRANSFER, true );
		curl_exec ( $curlHandler );
		curl_close ( $curlHandler );
	}

}

?>