<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.2
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
	public function getContent() {
		$json = file_get_contents ( $this->getTwitterAPI () );
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
		
		return array_reverse ( $result );
	}
	
	/**
	 * debug
	 *
	 */
	/*
	public function debugFilter() {
		$this->syncLevel = 3;
		$content = array ();
		$content [0] = 'RT@fdsafasd dfasdfsa';
		$content [1] = 'dfasdfasd';
		$content [2] = '@fds dfasd';
		$content [3] = 'fddddddddda54545512121212';
		$content [4] = 'RT @DFSD DFASDFAS';
		$this->filter ( $content );
		
		echo '<pre>';
		print_r ( $content );
		echo '</pre>';
	}*/
	
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
	
	/**
	 * write the last tweetid in file:tweet.id
	 *
	 * @param string  $id
	 */
	private function writeTweetId($id) {
		$fileHandler = @fopen ( 'tweet.id', 'w+' );
		@fwrite ( $fileHandler, $id );
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