<?php

declare(strict_types=1);

/**
 * Router script for PHP's built-in dev server.
 *
 * .htaccess is ignored by `php -S`, so use this to get:
 * - /login      -> /login.php
 * - /login.php  -> /login (GET/HEAD only)
 * - /index.php  -> /      (GET/HEAD only)
 *
 * Run from the project root:
 *   php -S localhost:8000 -t public public/router.php
 */

$uri = isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '/';
$path = parse_url($uri, PHP_URL_PATH);
$path = is_string($path) && $path !== '' ? $path : '/';

$path = rawurldecode($path);
$path = '/' . ltrim($path, '/');

if ($path !== '/' && substr($path, -1) === '/') {
    $path = rtrim($path, '/');
    $path = $path !== '' ? $path : '/';
}

// Basic hardening against path traversal.
if (strpos($path, "\0") !== false || strpos($path, '..') !== false) {
    http_response_code(400);
    echo 'Bad Request';
    return true;
}

$docroot = __DIR__;
$fullPath = $docroot . $path;

// If the requested path maps to an existing file/dir, serve it normally.
if ($path !== '/' && (is_file($fullPath) || is_dir($fullPath))) {
    return false;
}

$method = isset($_SERVER['REQUEST_METHOD']) ? strtoupper((string) $_SERVER['REQUEST_METHOD']) : 'GET';
$isSafeMethod = ($method === 'GET' || $method === 'HEAD');

// Canonical home URL.
if ($isSafeMethod && ($path === '/index.php' || $path === '/index')) {
    $qs = parse_url($uri, PHP_URL_QUERY);
    $target = '/';
    if (is_string($qs) && $qs !== '') {
        $target .= '?' . $qs;
    }

    header('Location: ' . $target, true, 301);
    exit;
}

// Redirect direct .php requests to extensionless URLs (GET/HEAD only).
if ($isSafeMethod && preg_match('#^/(.+)\.php$#i', $path, $m)) {
    $target = '/' . $m[1];
    $qs = parse_url($uri, PHP_URL_QUERY);
    if (is_string($qs) && $qs !== '') {
        $target .= '?' . $qs;
    }

    header('Location: ' . $target, true, 301);
    exit;
}

// Rewrite extensionless URLs to their .php file.
if ($path !== '/') {
    $candidate = $docroot . $path . '.php';

    if (is_file($candidate)) {
        $_SERVER['SCRIPT_FILENAME'] = $candidate;
        $_SERVER['SCRIPT_NAME'] = $path . '.php';
        $_SERVER['PHP_SELF'] = $path . '.php';

        require $candidate;
        return true;
    }
}

return false;
