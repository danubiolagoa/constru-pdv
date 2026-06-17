<?php

return [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', 'localhost'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_NAME', 'neondb'),
    'username' => env('DB_USER', 'neondb_owner'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'sslmode' => env('DB_SSLMODE', 'require'),
];
