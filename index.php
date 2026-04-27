<?php

$uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';

if ($scriptName !== '' && str_ends_with($uriPath, $scriptName)) {
    $uriPath = substr($uriPath, 0, -strlen($scriptName));
}

$basePath = rtrim($uriPath, '/');
$redirectPath = ($basePath === '' ? '' : $basePath) . '/public/';

header('Location: ' . $redirectPath, true, 302);
exit;
