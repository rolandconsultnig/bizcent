<?php
/**
 * PHP Built-in Web Server Router for CodeIgniter 3
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// If the requested file or directory exists in root, let PHP serve it
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

$_SERVER['SCRIPT_NAME'] = '/index.php';
require_once __DIR__ . '/index.php';
