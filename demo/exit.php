<?php

/** destroy session */
$sessionName = 'demo';
session_name($sessionName . '_Session');
session_start();
$_SESSION = array();
session_destroy();

/** go to main page */
header('Location: index.php');