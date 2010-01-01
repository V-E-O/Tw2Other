<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.1
 */

class Sina implements IService {
	
	private $username;
	
	private $password;
	
	private $content;
	
	const Sina_URL = 'https://login.sina.com.cn/sso/login.php';
	
	const Sina_COOKIE_DIR = 'cookies';
	
	function __construct() {
		$this->username = $this->password = null;
		$this->content = null;
	}
	
	public function setPassword($pwd) {
		
		$this->password = trim ( $pwd );
	}
	
	public function setUsername($user) {
		
		$this->username = trim ( $user );
	}
	
	public function setContent($content) {
		if (empty ( $content )) {
			return;
		}
		
		$this->content = $content;
	}
	
	public function update() {
		
		$this->sendContent ();
	}
	
	private function sendContent() {
		if (empty ( $this->content )) {
			return;
		}
		
		if (is_array ( $this->content )) {
			foreach ( $this->content as $value ) {
				$this->sendItem ( $value );
			}
			return;
		}
		
		$this->sendItem ( $this->content );
	
	}
	
	private function sendItem($content) {
		if (empty ( $content )) {
			return;
		}
		
		$cookieFile = tempnam ( self::Sina_COOKIE_DIR, 'sina.cookie' );
		
		$content = urlencode ( $content );
		
		$loginUrl = self::Sina_URL . "?username={$this->username}&password={$this->password}&returntype=TEXT";
		
		$loginCurlHandler = curl_init ( $loginUrl );
		curl_setopt ( $loginCurlHandler, CURLOPT_COOKIEJAR, $cookieFile );
		
		curl_setopt ( $loginCurlHandler, CURLOPT_HEADER, 0 );
		curl_setopt ( $loginCurlHandler, CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt ( $loginCurlHandler, CURLOPT_RETURNTRANSFER, 1 );
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
		curl_setopt ( $curlHandler, CURLOPT_RETURNTRANSFER, 1 );
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