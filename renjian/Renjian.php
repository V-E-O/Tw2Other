<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.1
 * 
 */

class Renjian extends Service {
	
	function __construct() {
		parent::__construct ();
		
		$this->statusFieldName = 'text';
		$this->updateUrl = 'http://api.renjian.com/statuses/update.xml';
	}
}

?>