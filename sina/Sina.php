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
	 * override sendItem
	 *
	 * @param string $content
	 */
	protected function sendItem($content) {
		if (empty ( $content )) {
			return;
		}
		
		$cookieFile = tempnam ( Service::COOKIE_DIR, 'sina.cookie' );
		
		$content = urlencode ( $content );
		
		$loginCurlHandler = curl_init ( $this->getLoginUrl () );
		curl_setopt ( $loginCurlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		
		curl_setopt ( $loginCurlHandler, CURLOPT_HEADER, 0 );
		curl_setopt ( $loginCurlHandler, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $loginCurlHandler, CURLOPT_TIMEOUT, 10 );
		curl_setopt ( $loginCurlHandler, CURLOPT_RETURNTRANSFER, true );
		curl_exec ( $loginCurlHandler );
		curl_close ( $loginCurlHandler );
		unset ( $loginCurlHandler );
		
		$curlHandler = curl_init ();
		curl_setopt ( $curlHandler, CURLOPT_URL, "http://t.sina.com.cn/mblog/publish.php" );
		curl_setopt ( $curlHandler, CURLOPT_REFERER, "http://t.sina.com.cn" );
		curl_setopt ( $curlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $curlHandler, CURLOPT_POSTFIELDS, "content=" . $content );
		curl_setopt ( $curlHandler, CURLOPT_COOKIEFILE, $cookieFile );
		curl_setopt ( $curlHandler, CURLOPT_RETURNTRANSFER, true );
		curl_exec ( $curlHandler );
		curl_close ( $curlHandler );
		
		if (file_exists ( $cookieFile )) {
			unlink ( $cookieFile );
		}
	}

}

?>