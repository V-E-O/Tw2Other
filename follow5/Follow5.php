<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.4
 */

class Follow5 extends Service {
	
	function __construct() {
		parent::__construct ();
		
		global $follow5ApiKey;
		
		$this->updateUrl = 'http://api.follow5.com/api/statuses/update.xml';
		$this->addPostData ( 'api_key', trim ( $follow5ApiKey ) );
	}
	
	protected function sendContent() {
		if (strlen ( $this->_post_data ['api_key'] ) != 32) {
			return;
		}
		
		parent::sendContent ();
	}
}

?>