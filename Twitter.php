<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.3
 */

class Twitter {
	
	/**
	 * twitter api url
	 *
	 * @var string 
	 */
	private $api;
	
	/**
	 * twitter username
	 *
	 * @var string
	 */
	private $user;
	
	/**
	 * sysc level
	 *
	 * @var int
	 */
	private $syncLevel = 0;
	
	/**
	 * 
	 */
	function __construct($api = '', $user = '') {
		$this->api = $api;
		$this->user = $user;
	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $api
	 */
	public function setApi($api) {
		if (trim ( $api ) != '') {
			$this->api = trim ( $api );
		}
	}
	
	/**
	 * Enter description here...
	 *
	 * @param string $user
	 */
	public function setUser($user) {
		if (trim ( $user ) != '') {
			$this->user = trim ( $user );
		}
	}
	
	/**
	 * Enter description here...
	 *
	 * @param int $level
	 */
	public function setSyncLevel($level) {
		$this->syncLevel = intval ( $level );
		
		if ($this->syncLevel > 3 || $this->syncLevel < 0) {
			$this->syncLevel = 0;
		}
	}
	
	/**
	 * return the tweets
	 *
	 * @return string or array
	 */
	/*
	public function getContent() {
		//$json = file_get_contents ( $this->getTwitterAPI () );
		

		$json = '';
		if (get_cfg_var ( 'allow_url_fopen' )) {
			$json = file_get_contents ( $this->getTwitterAPI () );
		} else {
			$curlHander = curl_init ( $this->getTwitterAPI () );
			curl_setopt ( $curlHander, CURLOPT_RETURNTRANSFER, true );
			$json = curl_exec ( $curlHander );
			curl_close ( $curlHander );
		}
		
		$json = json_decode ( $json, true );
		if (! isset ( $json [0] ['id'] )) {
			$this->noupdate ();
		}
		
		$this->writeTweetId ( $json [0] ['id'] );
		$i = - 1;
		$result = array ();
		while ( isset ( $json [++ $i] ) ) {
			$result [$i] = $json [$i] ['text'];
		}
		unset ( $json );
		
		$this->filter ( $result );
		$this->filterKey ( $result );
		
		return array_reverse ( $result );
	}*/
	
	public function getContent() {
		
		include_once 'twitteroauth/OAuth.php';
		include_once 'twitteroauth/twitteroauth.php';
		
		$access_token = getOauth ();
		$access_token = unserialize ( $access_token );
		
		$connection = new TwitterOAuth ( CONSUMER_KEY, CONSUMER_SECRET, $access_token ['oauth_token'], $access_token ['oauth_token_secret'] );
		
		$parameter = $this->getParameters ();
		$json = $connection->get ( 'statuses/user_timeline', $parameter );
		
		if (! isset ( $json [0] ['id_str'] )) {
			$this->noupdate ();
		}
		
		$this->writeTweetId ( $json [0] ['id_str'] );
		$i = - 1;
		$result = array ();
		while ( isset ( $json [++ $i] ) ) {
			$result [$i] = $json [$i] ['text'];
		}
		
		unset ( $json );
		
		$this->filter ( $result );
		$this->filterKey ( $result );
		
		return array_reverse ( $result );
	}
	
	/*
	public function debugFilter() {
		$this->syncLevel = 3;
		$content = array ();
		$content [0] = '#t2oRT@fdsafasd dfasdfsa';
		$content [1] = 'dfasdfasd';
		$content [2] = '@fds #t2odfasd';
		$content [3] = 'fddddddddda54545512121212';
		$content [4] = 'RT @DFSD DFASDFAS';
		$this->filterKey ( $content );
		
		echo '<pre>';
		print_r ( $content );
		echo '</pre>';
	}
	*/
	
	/**
	 * Enter description here...
	 *
	 * @param mix $content
	 * @return mix
	 */
	private function filter(& $content) {
		if ($this->syncLevel == 0) {
			return $content;
		}
		
		$pattern = $this->getPattern ();
		
		do {
			if (empty ( $pattern )) {
				break;
			}
			
			if (is_array ( $content )) {
				
				foreach ( $content as $k => $v ) {
					if (preg_match ( $pattern, $v )) {
						unset ( $content [$k] );
					}
				}
				
				if (count ( $content ) < 1) {
					$this->noupdate ();
				}
				
				break;
			}
			
			if (preg_match ( $pattern, $content )) {
				$this->noupdate ();
			}
		
		} while ( false );
		
		return $content;
	}
	
	/**
	 * 
	 * @param unknown_type $content
	 */
	private function filterKey(& $content) {
		
		$key = '#t2o';
		if (is_array ( $content )) {
			foreach ( $content as $k => $v ) {
				if (false !== strpos ( $v, $key )) {
					unset ( $content [$k] );
				}
			}
		} else {
			if (false !== strpos ( $content, $key )) {
				$this->noupdate ();
			}
		}
		
		return $content;
	}
	
	/**
	 * 
	 */
	private function getPattern() {
		
		switch ($this->syncLevel) {
			//过滤回复别人的tweet
			case 1 :
				return '/^@.*/m';
				break;
			
			//过滤RT别人的推	
			case 2 :
				return '/^RT\s@.*/m';
				break;
			
			//只同步自己的tweet,推中不包含RT,@字样	
			case 3 :
				return '/RT\s|@/';
				break;
			
			default :
				return NULL;
				break;
		}
	}
	
	/**
	 * Enter description here...
	 *
	 */
	private function noupdate() {
		exit ( 'No update' );
	}
	
	/**
	 * Enter description here...
	 *
	 * @param int $count
	 * @return string
	 */
	private function getTwitterAPI($count = 50) {
		
		$api = '';
		
		if (substr ( $this->api, - 1, 1 ) == '/') {
			$api = $this->api . 'statuses/user_timeline.json?id=';
		} else {
			$api = $this->api . '/statuses/user_timeline.json?id=';
		}
		
		$since_id = $this->getStartTweetId ();
		$api .= $this->user . '&count=' . $count;
		
		if (trim ( $since_id ) != '') {
			$api .= '&since_id=' . $since_id;
		}
		
		return $api;
	}
	
	private function getParameters($count = 50) {
		$parameters = array ();
		$parameters ['count'] = $count;
		$parameters ['include_rts'] = true;
		$since_id = $this->getStartTweetId ();
		if (! empty ( $since_id )) {
			$parameters ['since_id'] = $since_id;
		}
		
		return $parameters;
	}
	
	/**
	 * write the last tweetid in file:tweet.id
	 *
	 * @param string  $id
	 */
	private function writeTweetId($id) {
		$fileHandler = fopen ( 'tweet.id', 'w+' );
		if (! fwrite ( $fileHandler, $id )) {
			exit ( '请设置tw2other所在的目录可写' );
		}
		@fclose ( $fileHandler );
	}
	
	/**
	 * get tweet id int file:tweet.id
	 *
	 * @return string
	 */
	private function getStartTweetId() {
		if (! file_exists ( 'tweet.id' )) {
			return '';
		}
		
		$id = file_get_contents ( 'tweet.id' );
		
		return trim ( $id );
	}
	
	/**
	 * 
	 */
	function __destruct() {
	
		//TODO - Insert your code here
	}
}

?>