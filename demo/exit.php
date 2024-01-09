<?php

/** destroy session */
$sessionName = 'SuperDuperSessionName';
session_name($sessionName);
session_start();
$_SESSION = array();
session_destroy();

/** go to main page */
header('Location: index.php');