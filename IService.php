<?php
/**
 * @author cluries
 * @link http://intgu.com
 * @version 0.1
 */


interface IService {
	
	public function update();
	
	public function setUsername($user);
	
	public function setPassword($pwd);
	
	public function setContent($content);
}

?>