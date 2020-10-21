<?php

require('../src/sessionAdmin.php');

use Rx\SessionAdmin;

$rxSessionAdmin = new SessionAdmin();
$rxSessionAdmin->activateSession();

/**
 * if URL is not allowed to load, go to safe place (index.php)
 * you can comment the following validation but, when accessing private.php without authentication you will see
 * the page header in red and the session data showing
 * 'urlIsAllowedToLoad': false 
 */
if(!$_SESSION['urlIsAllowedToLoad']){
    header('Location: index.php');
}


/**
 * this demo assumes you have the following files:
 * 
 * src/
 *     sessionAdmin.php 
 * demo/
 *     authentication.php
 *     exit.php
 *     index.php
 *     page2.php
 *     private.php
 *     required.php
 * 
 */
