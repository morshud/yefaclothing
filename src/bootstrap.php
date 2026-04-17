<?php

declare(strict_types=1);

function env_load($path)
{
    $path = (string) $path;

    if ($path === '' || !is_file($path) || !is_readable($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES);
    if (!is_array($lines)) {
        return;
    }

    foreach ($lines as $line) {
        if (!is_string($line)) {
            continue;
        }

        $line = trim($line);
        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }

        $m = [];
        if (preg_match('/^export\s+([A-Z0-9_]+)\s*=\s*(.*)$/', $line, $m) !== 1 && preg_match('/^([A-Z0-9_]+)\s*=\s*(.*)$/', $line, $m) !== 1) {
            continue;
        }

        $key = isset($m[1]) ? (string) $m[1] : '';
        $value = isset($m[2]) ? (string) $m[2] : '';
        if ($key === '') {
            continue;
        }

        $value = trim($value);

        // Strip inline comments for unquoted values.
        if ($value !== '' && $value[0] !== '"' && $value[0] !== "'") {
            $hashPos = strpos($value, ' #');
            if ($hashPos !== false) {
                $value = rtrim(substr($value, 0, $hashPos));
            }
        }

        $len = strlen($value);
        if ($len >= 2) {
            $first = $value[0];
            $last = $value[$len - 1];
            if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                $value = substr($value, 1, -1);
                if ($first === '"') {
                    $value = str_replace(['\\n', '\\r', '\\t', '\\"', '\\\\'], ["\n", "\r", "\t", '"', '\\'], $value);
                }
            }
        }

        $current = getenv($key);
        if ($current !== false && $current !== '') {
            continue;
        }

        putenv($key . '=' . $value);
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

env_load(__DIR__ . '/../.env');

function config()
{
    static $config = null;

    if ($config === null) {
        $config = require __DIR__ . '/config.php';
    }

    return $config;
}

function db_config()
{
    $cfg = config();
    $db = (isset($cfg['db']) && is_array($cfg['db'])) ? $cfg['db'] : [];

    $dsn = getenv('YEFA_DB_DSN');
    $user = getenv('YEFA_DB_USER');
    $pass = getenv('YEFA_DB_PASS');

    $dsn = is_string($dsn) && $dsn !== '' ? $dsn : (isset($db['dsn']) && is_string($db['dsn']) ? $db['dsn'] : '');
    $user = is_string($user) && $user !== '' ? $user : (isset($db['user']) && is_string($db['user']) ? $db['user'] : '');
    $pass = is_string($pass) && $pass !== '' ? $pass : (isset($db['pass']) && is_string($db['pass']) ? $db['pass'] : '');

    return [
        'dsn' => $dsn,
        'user' => $user,
        'pass' => $pass,
    ];
}

function db_is_configured()
{
    $cfg = db_config();

    return isset($cfg['dsn']) && is_string($cfg['dsn']) && $cfg['dsn'] !== '';
}

function db()
{
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    if (!class_exists('PDO')) {
        throw new RuntimeException('PDO is not enabled on this server.');
    }

    $cfg = db_config();
    $dsn = isset($cfg['dsn']) && is_string($cfg['dsn']) ? $cfg['dsn'] : '';
    $user = isset($cfg['user']) && is_string($cfg['user']) ? $cfg['user'] : '';
    $pass = isset($cfg['pass']) && is_string($cfg['pass']) ? $cfg['pass'] : '';

    if ($dsn === '') {
        throw new RuntimeException('Database is not configured. Set YEFA_DB_DSN (and YEFA_DB_USER/YEFA_DB_PASS if needed).');
    }

    // Normalize SQLite DSNs so platforms can use relative paths like:
    //   YEFA_DB_DSN=sqlite:storage/app.sqlite
    if (stripos($dsn, 'sqlite:') === 0) {
        $sqliteTarget = substr($dsn, 7);
        $sqliteTarget = is_string($sqliteTarget) ? $sqliteTarget : '';

        // Ignore in-memory DB and special formats.
        if ($sqliteTarget !== '' && $sqliteTarget !== ':memory:' && stripos($sqliteTarget, 'file:') !== 0) {
            if ($sqliteTarget[0] !== '/') {
                $root = realpath(__DIR__ . '/..');
                if ($root !== false) {
                    $sqliteTarget = $root . '/' . $sqliteTarget;
                    $dsn = 'sqlite:' . $sqliteTarget;
                }
            }

            $dir = dirname($sqliteTarget);
            if (!is_dir($dir)) {
                if (!@mkdir($dir, 0775, true) && !is_dir($dir)) {
                    throw new RuntimeException('SQLite directory is not writable: ' . $dir);
                }
            }
        }
    }

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($dsn, $user !== '' ? $user : null, $pass !== '' ? $pass : null, $options);

    return $pdo;
}

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function is_https()
{
    $https = isset($_SERVER['HTTPS']) ? (string) $_SERVER['HTTPS'] : '';
    if ($https !== '' && strtolower($https) !== 'off') {
        return true;
    }

    $requestScheme = isset($_SERVER['REQUEST_SCHEME']) ? (string) $_SERVER['REQUEST_SCHEME'] : '';
    if (strtolower($requestScheme) === 'https') {
        return true;
    }

    $xfp = isset($_SERVER['HTTP_X_FORWARDED_PROTO']) ? (string) $_SERVER['HTTP_X_FORWARDED_PROTO'] : '';
    if ($xfp !== '') {
        $parts = explode(',', $xfp);
        $proto = isset($parts[0]) ? strtolower(trim($parts[0])) : '';
        if ($proto === 'https') {
            return true;
        }
    }

    $xfs = isset($_SERVER['HTTP_X_FORWARDED_SSL']) ? (string) $_SERVER['HTTP_X_FORWARDED_SSL'] : '';
    if (strtolower($xfs) === 'on') {
        return true;
    }

    $forwarded = isset($_SERVER['HTTP_FORWARDED']) ? (string) $_SERVER['HTTP_FORWARDED'] : '';
    if ($forwarded !== '' && stripos($forwarded, 'proto=https') !== false) {
        return true;
    }

    $port = isset($_SERVER['SERVER_PORT']) ? (string) $_SERVER['SERVER_PORT'] : '';
    return $port === '443';
}

function start_session()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $params = session_get_cookie_params();

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => isset($params['path']) ? $params['path'] : '/',
        'domain' => isset($params['domain']) ? $params['domain'] : '',
        'secure' => is_https(),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    ini_set('session.use_strict_mode', '1');
    session_start();
}

start_session();

function csrf_token()
{
    if (!isset($_SESSION['csrf_token']) || !is_string($_SESSION['csrf_token']) || $_SESSION['csrf_token'] === '') {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="_csrf" value="' . e(csrf_token()) . '">';
}

function csrf_validate()
{
    $posted = isset($_POST['_csrf']) && is_string($_POST['_csrf']) ? $_POST['_csrf'] : '';

    return $posted !== '' && hash_equals(csrf_token(), $posted);
}

function flash_set($key, $message)
{
    if (!isset($_SESSION['flash']) || !is_array($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }

    $_SESSION['flash'][$key] = $message;
}

function flash_get($key)
{
    if (!isset($_SESSION['flash']) || !is_array($_SESSION['flash']) || !array_key_exists($key, $_SESSION['flash'])) {
        return null;
    }

    $message = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);

    return is_string($message) ? $message : null;
}

function current_user_email()
{
    $email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : null;

    return is_string($email) && $email !== '' ? $email : null;
}

function current_user_id()
{
    $id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    if (is_int($id) && $id > 0) {
        return $id;
    }

    if (is_string($id) && ctype_digit($id)) {
        $n = (int) $id;
        return $n > 0 ? $n : null;
    }

    return null;
}

function is_logged_in()
{
    return current_user_id() !== null || current_user_email() !== null;
}

function auth_set_logged_in_user($user)
{
    $id = isset($user['id']) ? (int) $user['id'] : 0;
    $email = isset($user['email']) ? (string) $user['email'] : '';

    if ($id <= 0 || $email === '') {
        throw new RuntimeException('Invalid user payload.');
    }

    regenerate_session_id();
    $_SESSION['user_id'] = $id;
    $_SESSION['user_email'] = $email;
}

function auth_logout()
{
    unset($_SESSION['user_id'], $_SESSION['user_email']);
    regenerate_session_id();
}

function auth_user_find_by_email($email)
{
    $stmt = db()->prepare('SELECT id, email, password_hash FROM users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => (string) $email]);
    $row = $stmt->fetch();

    return is_array($row) ? $row : null;
}

function auth_user_create($email, $password)
{
    $hash = password_hash((string) $password, PASSWORD_DEFAULT);
    if (!is_string($hash) || $hash === '') {
        throw new RuntimeException('Failed to hash password.');
    }

    $stmt = db()->prepare('INSERT INTO users (email, password_hash) VALUES (:email, :hash)');
    $stmt->execute([
        'email' => (string) $email,
        'hash' => $hash,
    ]);

    return [
        'id' => (int) db()->lastInsertId(),
        'email' => (string) $email,
        'password_hash' => $hash,
    ];
}

function auth_credentials()
{
    $cfg = config();

    $defaultEmail = isset($cfg['auth']['admin_email']) ? $cfg['auth']['admin_email'] : '';
    $defaultHash = isset($cfg['auth']['admin_password_hash']) ? $cfg['auth']['admin_password_hash'] : '';

    $email = getenv('YEFA_ADMIN_EMAIL');
    $hash = getenv('YEFA_ADMIN_PASSWORD_HASH');

    return [
        'email' => is_string($email) && $email !== '' ? $email : (is_string($defaultEmail) ? $defaultEmail : ''),
        'hash' => is_string($hash) && $hash !== '' ? $hash : (is_string($defaultHash) ? $defaultHash : ''),
    ];
}

function regenerate_session_id()
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
    }
}

function redirect($location)
{
    $location = (string) $location;

    if (preg_match('/[\r\n]/', $location)) {
        $location = '/';
    }

    if ($location === '') {
        $location = '/';
    }

    if (!preg_match('#^(?:/|https?://)#i', $location)) {
        $location = '/' . $location;
    }

    header('Location: ' . $location);
    exit;
}

