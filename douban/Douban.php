<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.1
 */

class Douban extends Service {
	
	function __construct() {
		parent::__construct ();
	
	}
	
	/**
	 * Enter description here...
	 *
	 * @return unknown
	 */
	private function login() {
		$cookieFile = tempnam ( Service::COOKIE_DIR, 'douban.cookie' );
		
		$loginInfo = array ('form_email' => $this->username, 'form_password' => $this->password );
		$loginCurlHandler = curl_init ( "http://www.douban.com/login" );
		curl_setopt ( $loginCurlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $loginCurlHandler, CURLOPT_REFERER, "http://www.douban.com/login" );
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
	
	/**
	 * Enter description here...
	 *
	 * @param unknown_type $cookieFile
	 * @return unknown
	 */
	private function getCkValue($cookieFile) {
		
		$indexCurlHandler = curl_init ( "http://www.douban.com/" );
		curl_setopt ( $indexCurlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		curl_setopt ( $indexCurlHandler, CURLOPT_COOKIEFILE, $cookieFile );
		curl_setopt ( $indexCurlHandler, CURLOPT_RETURNTRANSFER, true );
		curl_exec ( $indexCurlHandler );
		curl_close ( $indexCurlHandler );
		unset ( $indexCurlHandler );
		
		$content = file_get_contents ( $cookieFile );
		$content = trim ( $content );
		
		$pattern = '/ck\s+"(.*?)"/mi';
		$matchs = array ();
		preg_match ( $pattern, $content, $matchs );
		
		return $matchs [1];
	}
	
	/**
	 * Enter description here...
	 *
	 */
	protected function sendContent() {
		
		if (empty ( $this->content )) {
			return;
		}
		
		$cookieFile = $this->login ();
		$ck = $this->getCkValue ( $cookieFile );
		
		if (is_array ( $this->content )) {
			foreach ( $this->content as $value ) {
				$this->sendItem ( $value, $cookieFile, $ck );
			}
		} else {
			$this->sendItem ( $this->content, $cookieFile, $ck );
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
	 * @param unknown_type $ck
	 */
	protected function sendItem($content, $cookieFile, $ck) {
		$content = urlencode ( $content );
		$post = array ('mb_text' => $content, 'ck' => $ck );
		
		$curlHandler = curl_init ();
		curl_setopt ( $curlHandler, CURLOPT_URL, "http://www.douban.com/people/cluries/miniblogs" );
		curl_setopt ( $curlHandler, CURLOPT_REFERER, "http://www.douban.com/people/cluries/miniblogs" );
		curl_setopt ( $curlHandler, CURLOPT_POST, 1 );
		curl_setopt ( $curlHandler, CURLOPT_POSTFIELDS, createKeyString ( $post ) );
		curl_setopt ( $curlHandler, CURLOPT_COOKIEFILE, $cookieFile );
		curl_setopt ( $curlHandler, CURLOPT_RETURNTRANSFER, true );
		curl_exec ( $curlHandler );
		curl_close ( $curlHandler );
	}

}

?>