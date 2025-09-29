<?php

/** destroy session */
$sessionName = 'MyCustomMPASessionName';
session_name($sessionName);
session_start();
$_SESSION = [];
session_destroy();

/** go to main page */
header('Location: index.php');