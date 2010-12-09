<?php

class Fanfou extends Service {
	function __construct() {
		parent::__construct ();
		
		$this->updateUrl = 'http://api.fanfou.com/statuses/update/update.xml';
	}
}

?>