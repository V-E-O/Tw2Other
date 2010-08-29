<?php
/**
 * @file
 * Clears PHP sessions and redirects to the connect page.
 */

/* Load and clear sessions */

if (file_exists('lock')) {
	exit('Lock文件存在,请删除Tw2other所在路径下的lock文件后再试');
}

session_start ();
session_destroy ();

require_once ('config.php');
require_once 'init.php';

updateOauth ( '' );

/* Redirect to page with the connect to Twitter option. */
header ( 'Location: ./connect.php' );
