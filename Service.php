<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.3
 */

abstract class Service {
	
	/**
	 * username
	 *
	 * @var string
	 */
	protected $username;
	
	/**
	 * password
	 *
	 * @var string
	 */
	protected $password;
	
	/**
	 * content
	 *
	 * @var mix
	 */
	protected $content;
	
	/**
	 * Enter description here...
	 *
	 * @var boolean
	 */
	protected $sendSource = true;
	
	/**
	 * Enter description here...
	 *
	 * @var string
	 */
	protected $statusFieldName = 'status';
	
	/**
	 * Enter description here...
	 *
	 * @var string
	 */
	protected $updateUrl;
	
	/**
	 * Enter description here...
	 *
	 * @var array
	 */
	protected $_post_data;
	
	const COOKIE_DIR = 'cookies';
	
	/**
	 * construct
	 *
	 */
	function __construct() {
		
		$this->_post_data = array ();
		$this->username = $this->password = null;
		$this->content = null;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $pwd
	 */
	public function setPassword($pwd) {
		
		$this->password = trim ( $pwd );
	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $user
	 */
	public function setUsername($user) {
		
		$this->username = trim ( $user );
	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $key
	 * @param string $value
	 */
	protected function addPostData($key, $value) {
		if (trim ( $key ) == '') {
			return;
		}
		
		$this->_post_data [$key] = $value;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param mix $content
	 */
	public function setContent($content) {
		if (empty ( $content )) {
			return;
		}
		
		$this->content = $content;
	}
	
	/**
	 * update
	 *
	 */
	public function update() {
		$this->sendContent ();
	}
	
	/**
	 * send
	 *
	 */
	protected function sendContent() {
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
	
	/**
	 * send item
	 *
	 * @param string $content
	 */
	protected function sendItem($content) {
		if (empty ( $content )) {
			return;
		}
		
		if ($this->sendSource) {
			$this->_post_data ['source'] = SOURCE;
		}
		
		$this->_post_data [$this->statusFieldName] = urlencode ( $content );
		
		$curlOptions = array ();
		
		$curlOptions [CURLOPT_USERPWD] = "{$this->username}:{$this->password}";
		$curlOptions [CURLOPT_URL] = $this->updateUrl;
		$curlOptions [CURLOPT_POST] = true;
		$curlOptions [CURLOPT_POSTFIELDS] = createKeyString ( $this->_post_data );
		$curlOptions [CURLOPT_RETURNTRANSFER] = true;
		$curlOptions [CURLOPT_TIMEOUT] = 10;
		
		$curlHandler = curl_init ();
		curl_setopt_array ( $curlHandler, $curlOptions );
		curl_exec ( $curlHandler );
		curl_close ( $curlHandler );
	}

}

?>