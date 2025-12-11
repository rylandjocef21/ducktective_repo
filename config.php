<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 0);

define('APP_NAME', 'Duck-tective');
define('APP_VERSION', '1.0.0');
?>