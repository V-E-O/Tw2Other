<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.4
 */

include 'renren/RenrenOauth.php';

class Renren extends Service {
	
	protected $_so;

	private $_auth;
	
	public function __construct() {
		parent::__construct ();
		$this->_auth = $this->getAuth ();
		$this->_so = new RenrenOauth ();
	}
	
	public function sendItem($content) {
		$this->_post['access_token'] = $this->_auth['access_token'];
		$this->_post['status'] = $content;
		ksort($this->_post);
		reset($this->_post);
		$str = '';
		foreach($this->_post AS $k=>$v){
			$str .= $k.'='.$v;
		}

		$str = md5($str.RENREN_API_SECRET);
		$this->_post['sig'] = $str;

		$url = 'http://api.renren.com/restserver.do';
		echo $this->_so->httpRequest ( $url, $this->_post, 2 );
		echo '<br />';
		$token = $this->_so->refreshToken($this->_auth['refresh_token']);
		if (! empty ( $token ['access_token'] ) && ! empty ( $token ['refresh_token'] )) {
	
			$fileHandler = @fopen ( dirPs ( OAUTH_DIR ) . 'tw2other_renren.oauth', 'w+' );
			@fwrite ( $fileHandler, serialize ( $token ) );
			@fclose ( $fileHandler );
	
			echo '授权更新';
		}
	}
	
	private function getAuth() {
		$oauth = dirPs ( OAUTH_DIR ) . 'tw2other_renren.oauth';
		if (file_exists ( $oauth )) {
			$content = file_get_contents ( $oauth );
			$auth = unserialize ( $content );
			return $auth;
		}
		
		return null;
	}

	private $_post	= array(
				'access_token'	=>	'',
				'format'	=>	'JSON',
				'method'	=>	'status.set',
				'status'	=>	'',
				'v'		=>	'1.0'
			);
}

?>
