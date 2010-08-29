<?php
/**
 * @file
 * Clears PHP sessions and redirects to the connect page.
 */

/* Load and clear sessions */
session_start ();
session_destroy ();

require_once ('config.php');
require_once 'init.php';

updateOauth ( '' );

/* Redirect to page with the connect to Twitter option. */
header ( 'Location: ./connect.php' );
