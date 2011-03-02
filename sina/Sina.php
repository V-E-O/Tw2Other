<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.4
 */

class Sina extends Service {
	function __construct() {
		parent::__construct ();
		
		$this->sendSource = false;
		$this->updateUrl = 'http://api.t.sina.com.cn/statuses/update.xml';
		$this->addPostData ( 'source', SINA_APP_KEY );
	}
}

?>