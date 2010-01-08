<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.1
 */

class Follow5 implements IService {
	
	private $username;
	
	private $password;
	
	private $content;
	
	const Follow5_API = 'http://api.follow5.com/api/statuses/update.xml';
	
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
		
		$post = array ();
		$post ['api_key'] = 'BB15BAEA943955C56FB6CA4A30754ED8';
		$post ['status'] = urlencode ( $content );
		
		$curlOptions = array ();
		
		$curlOptions [CURLOPT_USERPWD] = "{$this->username}:{$this->password}";
		$curlOptions [CURLOPT_URL] = self::Follow5_API;
		
		$curlOptions [CURLOPT_POST] = true;
		$curlOptions [CURLOPT_POSTFIELDS] = createKeyString ( $post );
		
		//$curlOptions [CURLOPT_HEADERFUNCTION] = 'duplicateHeader';
		$curlOptions [CURLOPT_RETURNTRANSFER] = true;
		
		$curlHandler = curl_init ();
		curl_setopt_array ( $curlHandler, $curlOptions );
		curl_exec ( $curlHandler );
		curl_close ( $curlHandler );
	}
}

?>