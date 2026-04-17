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

        $current = env_get($key);
        if (is_string($current) && $current !== '') {
            continue;
        }

        if (function_exists('putenv')) {
            putenv($key . '=' . $value);
        }
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

env_load(__DIR__ . '/../.env');

function env_normalize_value($value)
{
    if (!is_string($value)) {
        return null;
    }

    $value = trim($value);
    if ($value === '') {
        return null;
    }

    // Strip inline comments for unquoted values (matches .env behavior).
    if ($value[0] !== '"' && $value[0] !== "'") {
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

    return $value;
}

function env_get($key)
{
    $key = (string) $key;
    if ($key === '') {
        return null;
    }

    $value = null;

    if (function_exists('getenv')) {
        $v = getenv($key);
        if ($v !== false) {
            $value = $v;
        }
    }

    if ($value === null && array_key_exists($key, $_ENV)) {
        $value = $_ENV[$key];
    }

    if ($value === null && array_key_exists($key, $_SERVER)) {
        $value = $_SERVER[$key];
    }

    return env_normalize_value($value);
}

function app_root()
{
    static $root = null;

    if ($root === null) {
        $resolved = realpath(__DIR__ . '/..');
        $root = ($resolved !== false) ? $resolved : (__DIR__ . '/..');
    }

    return $root;
}

function storage_path($relative = '')
{
    $relative = (string) $relative;
    $relative = ltrim($relative, '/');

    $base = app_root() . '/storage';
    return $relative !== '' ? ($base . '/' . $relative) : $base;
}

function app_debug_enabled()
{
    $value = env_get('YEFA_APP_DEBUG');
    if (!is_string($value) || $value === '') {
        return false;
    }

    $value = strtolower(trim($value));
    return in_array($value, ['1', 'true', 'yes', 'on'], true);
}

function app_log($message)
{
    $message = trim((string) $message);
    if ($message === '') {
        return;
    }

    $line = '[' . date('c') . '] ' . $message . "\n";
    $logFile = storage_path('logs/app.log');
    $logDir = dirname($logFile);

    if (!is_dir($logDir)) {
        @mkdir($logDir, 0775, true);
    }

    $ok = @file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
    if ($ok === false) {
        // Fallback to the server error log (viewable in cPanel "Errors").
        error_log($message);
    }
}

function app_report_exception(Throwable $e, $context = [])
{
    $ctx = '';
    if (is_array($context) && $context) {
        $encoded = json_encode($context, JSON_UNESCAPED_SLASHES);
        $ctx = is_string($encoded) ? $encoded : '';
    }

    $request = [
        'method' => isset($_SERVER['REQUEST_METHOD']) ? (string) $_SERVER['REQUEST_METHOD'] : '',
        'uri' => isset($_SERVER['REQUEST_URI']) ? (string) $_SERVER['REQUEST_URI'] : '',
        'ip' => isset($_SERVER['REMOTE_ADDR']) ? (string) $_SERVER['REMOTE_ADDR'] : '',
    ];

    $requestJson = json_encode($request, JSON_UNESCAPED_SLASHES);
    $requestJson = is_string($requestJson) ? $requestJson : '';

    app_log('Exception ' . get_class($e) . ': ' . $e->getMessage());
    app_log('Location: ' . $e->getFile() . ':' . $e->getLine());
    if ($requestJson !== '') {
        app_log('Request: ' . $requestJson);
    }
    if ($ctx !== '') {
        app_log('Context: ' . $ctx);
    }
}

function db_exception_public_message(Throwable $e)
{
    // In debug mode, show the raw error (use only temporarily in production).
    if (app_debug_enabled()) {
        return 'Database error (debug): ' . $e->getMessage();
    }

    // Keep the public message safe, but actionable.
    $msg = strtolower((string) $e->getMessage());

    if (!db_is_configured()) {
        return 'Database is not configured. Set YEFA_DB_DSN (and YEFA_DB_USER/YEFA_DB_PASS if needed).';
    }

    // Missing schema (MySQL + SQLite common phrases).
    if (strpos($msg, 'users') !== false && (
        strpos($msg, 'no such table') !== false ||
        strpos($msg, 'doesn\'t exist') !== false ||
        strpos($msg, 'not found') !== false
    )) {
        return 'Database schema is missing. Import database/schema.mysql.sql (or database/schema.sqlite.sql) into your database.';
    }

    // SQLite path/permissions.
    if (strpos($msg, 'unable to open database file') !== false || strpos($msg, 'not writable') !== false) {
        return 'SQLite path is not writable on this host. Set YEFA_DB_DSN to a writable (and ideally persistent) path.';
    }

    // PDO driver not installed/enabled.
    if (strpos($msg, 'could not find driver') !== false) {
        $dsn = db_config();
        $dsn = isset($dsn['dsn']) ? (string) $dsn['dsn'] : '';
        if (stripos($dsn, 'mysql:') === 0) {
            return 'This server does not have the MySQL PDO driver enabled (pdo_mysql). Enable it in your hosting PHP settings.';
        }
        if (stripos($dsn, 'sqlite:') === 0) {
            return 'This server does not have the SQLite PDO driver enabled (pdo_sqlite). Enable it in your hosting PHP settings.';
        }
        return 'This server is missing the required PDO database driver.';
    }

    // MySQL common connection/auth errors.
    if (strpos($msg, 'access denied') !== false || strpos($msg, 'sqlstate[28000]') !== false) {
        return 'Database login failed. Verify YEFA_DB_USER/YEFA_DB_PASS and that the user is added to the database with privileges.';
    }

    if (strpos($msg, 'unknown database') !== false || (strpos($msg, '1049') !== false && strpos($msg, 'sqlstate') !== false)) {
        return 'Database name was not found. Create the database (in cPanel → MySQL Databases) and update the dbname in YEFA_DB_DSN.';
    }

    if (
        strpos($msg, 'connection refused') !== false ||
        strpos($msg, 'timed out') !== false ||
        strpos($msg, 'server has gone away') !== false ||
        (strpos($msg, '2002') !== false && strpos($msg, 'sqlstate') !== false)
    ) {
        return 'Cannot connect to the database server. Check the host/port in YEFA_DB_DSN and firewall/remote-MySQL settings.';
    }

    if (strpos($msg, 'getaddrinfo failed') !== false || strpos($msg, 'php_network_getaddresses') !== false) {
        return 'Database host cannot be resolved. Double-check the host in YEFA_DB_DSN.';
    }

    if (strpos($msg, 'unknown character set') !== false) {
        return 'MySQL does not support the configured charset. Try charset=utf8 (or upgrade MySQL/MariaDB) and re-test.';
    }

    return 'Database error. Please try again.';
}

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

    $dsn = env_get('YEFA_DB_DSN');
    $user = env_get('YEFA_DB_USER');
    $pass = env_get('YEFA_DB_PASS');

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

    $email = env_get('YEFA_ADMIN_EMAIL');
    $hash = env_get('YEFA_ADMIN_PASSWORD_HASH');

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

