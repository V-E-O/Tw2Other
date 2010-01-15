<?php
/**
 * @author cluries
 * @link http://cuies.com
 * @version 0.3
 * 
 */

class Digu extends Service {
	
	function __construct() {
		
		parent::__construct ();
		
		$this->statusFieldName = 'content';
		$this->updateUrl = 'http://api.minicloud.com.cn/statuses/update.xml';
	}

}

?>