<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.3
 */

class Follow5 extends Service {
	
	function __construct() {
		parent::__construct ();
		
		$this->updateUrl = 'http://api.follow5.com/api/statuses/update.xml';
		$this->addPostData ( 'api_key', 'BB15BAEA943955C56FB6CA4A30754ED8' );
	}
}

?>