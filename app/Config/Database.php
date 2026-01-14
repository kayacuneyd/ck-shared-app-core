<?php

namespace Config;

use CodeIgniter\Database\Config;

/**
 * Database Configuration
 *
 * Configures the SQLite database connection for the application.
 */
class Database extends Config
{
    /**
     * Default database group.
     *
     * @var string
     */
    public string $defaultGroup = 'default';

    /**
     * Default database configuration (SQLite).
     *
     * @var array<string, mixed>
     */
    public array $default = [
        'DSN' => '',
        'hostname' => '',
        'username' => '',
        'password' => '',
        'database' => WRITEPATH . 'database/app.sqlite',
        'DBDriver' => 'SQLite3',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug' => true,
        'charset' => 'utf8',
        'DBCollat' => '',
        'swapPre' => '',
        'encrypt' => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port' => 0,
        'foreignKeys' => true,
        'dateFormat' => [
            'date' => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time' => 'H:i:s',
        ],
    ];

    /**
     * Tests database configuration (SQLite).
     *
     * @var array<string, mixed>
     */
    public array $tests = [
        'DSN' => '',
        'hostname' => '',
        'username' => '',
        'password' => '',
        'database' => WRITEPATH . 'database/test.sqlite',
        'DBDriver' => 'SQLite3',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug' => true,
        'charset' => 'utf8',
        'DBCollat' => '',
        'swapPre' => '',
        'encrypt' => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port' => 0,
        'foreignKeys' => true,
        'dateFormat' => [
            'date' => 'Y-m-d',
            'datetime' => 'Y-m-d H:i:s',
            'time' => 'H:i:s',
        ],
    ];
}
