<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.3
 */

class Zuosa extends Service {
	
	/**
	 * 
	 */
	function __construct() {
		
		parent::__construct ();
		
		$this->sendSource = false;
		$this->updateUrl = 'http://api.zuosa.com/statuses/update.xml';
	}
}

?>