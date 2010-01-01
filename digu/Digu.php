<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.1
 */

class Digu implements IService {
	
	private $username;
	
	private $password;
	
	private $content;
	
	const Digu_API = 'http://api.minicloud.com.cn/statuses/update.xml';
	
	/**
	 * 
	 */
	function __construct() {
		
		$this->username = $this->password = null;
		$this->content = null;
	}
	
	/**
	 * 
	 * @see IService::setPwd()
	 */
	public function setPassword($pwd) {
		
		$this->password = trim ( $pwd );
	}
	
	/**
	 * 
	 * @see IService::setUser()
	 */
	public function setUsername($user) {
		
		$this->username = trim ( $user );
	}
	
	/**
	 * 
	 *
	 * @see  IService::setContent()
	 */
	public function setContent($content) {
		if (empty ( $content )) {
			return;
		}
		
		$this->content = $content;
	}
	
	/**
	 * 
	 * @see IService::update()
	 */
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
		if (defined ( 'SOURCE' )) {
			$post ['source'] = SOURCE;
		}
		
		$post ['content'] = urlencode ( $content );
		
		$curlOptions = array ();
		
		$curlOptions [CURLOPT_USERPWD] = "{$this->username}:{$this->password}";
		$curlOptions [CURLOPT_URL] = self::Digu_API;
		$curlOptions [CURLOPT_POST] = true;
		$curlOptions [CURLOPT_POSTFIELDS] = createKeyString ( $post );
		//$curlOptions [CURLOPT_HEADERFUNCTION] = 'duplicateHeader';
		$curlOptions [CURLOPT_RETURNTRANSFER] = true;
		
		$curlHandler = curl_init ();
		curl_setopt_array ( $curlHandler, $curlOptions );
		curl_exec ( $curlHandler );
		curl_close ( $curlHandler );
	}
	
	/**
	 * 
	 */
	function __destruct() {
		
	//TODO - Insert your code here
	}
}

?>