<?php
/**
 * @author cluries
 * @link http://intgu.com
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