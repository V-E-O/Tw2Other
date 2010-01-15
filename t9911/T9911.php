<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.3
 */

class T9911 extends Service {
	
	function __construct() {
		parent::__construct ();
		
		$this->updateUrl = 'http://api.9911.com/statuses/update.xml';
		$this->sendSource = false;
	}
}

?>