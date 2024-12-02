<?php

namespace Lib;

use Dotenv\Dotenv;
use ORM;

class App
{
    public static function configure(): void
    {
        $dotenv = Dotenv::createUnsafeImmutable(__DIR__.'/..');
        $dotenv->load();

        ORM::configure([
            'connection_string' => 'pgsql:host='.getenv('DB_HOST').';dbname='.getenv('DB_DATABASE'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
        ]);
    }
}