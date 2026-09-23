<?php

declare(strict_types=1);

/* Local XAMPP defaults can be overridden by environment variables or config.php. */
$config = [
    'host' => getenv('DB_HOST') ?: '127.0.0.1',
    'port' => (int) (getenv('DB_PORT') ?: 3306),
    'username' => getenv('DB_USERNAME') ?: 'root',
    'password' => getenv('DB_PASSWORD') ?: '',
    'database' => getenv('DB_DATABASE') ?: 'al_kassaby',
];

$local_config_file = __DIR__ . '/config.php';
if (is_file($local_config_file)) {
    $local_config = require $local_config_file;

    if (is_array($local_config)) {
        $config = array_replace($config, $local_config);
    }
}

mysqli_report(MYSQLI_REPORT_OFF);

$conn = @new mysqli(
    (string) $config['host'],
    (string) $config['username'],
    (string) $config['password'],
    (string) $config['database'],
    (int) $config['port']
);

if ($conn->connect_error) {
    error_log('Database connection failed: ' . $conn->connect_error);
    http_response_code(500);
    exit('Database connection is currently unavailable. Check the database configuration.');
}

if (!$conn->set_charset('utf8mb4')) {
    error_log('Could not set database character encoding: ' . $conn->error);
    http_response_code(500);
    exit('Database configuration error.');
}
