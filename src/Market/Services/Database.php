<?php

namespace Market\Services;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Database class
 */
class Database
{
    public function __construct()
    {
        $s = [
            'driver' => getenv('DB_CONNECTION'),
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci'
        ];

        $capsule = new Capsule();
        $capsule->addConnection($s);
        $capsule->bootEloquent();
    }
}
