<?php
/**
 * Configuration File
 * Handles session initiation and global settings.
 */

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error Reporting (Turn off for production, on for debugging)
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Define App Constants
define('APP_NAME', 'Duck-tective');
define('APP_VERSION', '1.0.0');
?>