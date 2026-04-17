<?php

return [
    'site' => [
        'name' => 'yefaclothing',
        'tagline' => '',
        'currency_symbol' => '₦',
    ],
    'db' => [
        // Preferred: set env vars YEFA_DB_DSN / YEFA_DB_USER / YEFA_DB_PASS.
        // Example MySQL DSN: mysql:host=127.0.0.1;dbname=yefaclothing;charset=utf8mb4
        // Example SQLite DSN: sqlite:/absolute/path/to/storage/app.sqlite
        'dsn' => '',
        'user' => '',
        'pass' => '',
    ],
    'auth' => [
        // Set these, or use environment variables:
        //   YEFA_ADMIN_EMAIL
        //   YEFA_ADMIN_PASSWORD_HASH
        'admin_email' => '',
        'admin_password_hash' => '',
    ],
];
