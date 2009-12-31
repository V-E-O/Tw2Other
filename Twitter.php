<?php

class Twitter {
	
	private $api;
	
	private $user;
	
	/**
	 * 
	 */
	function __construct($api = '', $user = '') {
		$this->api = $api;
		$this->user = $user;
	}
	
	public function setApi($api) {
		if (trim ( $api ) != '') {
			$this->api = trim ( $api );
		}
	}
	
	public function setUser($user) {
		if (trim ( $user ) != '') {
			$this->user = trim ( $user );
		}
	}
	
	public function getContent() {
		$json = file_get_contents ( $this->getTwitterAPI () );
		$json = json_decode ( $json, true );
		if (! isset ( $json [0] ['id'] )) {
			exit ( 'No update' );
		}
		
		$this->writeTweetId ( $json [0] ['id'] );
		$i = - 1;
		$result = array ();
		while ( isset ( $json [++ $i] ) ) {
			$result [$i] = $json [$i] ['text'];
		}
		unset ( $json );
		
		return array_reverse ( $result );
	}
	
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
	
	private function writeTweetId($id) {
		$fileHandler = @fopen ( 'tweet.id', 'w+' );
		@fwrite ( $fileHandler, $id );
		@fclose ( $fileHandler );
	}
	
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