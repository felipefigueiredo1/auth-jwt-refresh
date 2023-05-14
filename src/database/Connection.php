<?php

namespace App\database;


class Connection
{
    public static $instance;

    public static function connect()
    {
        try {
            return new \PDO("pgsql:host=postgres;dbname=teste", "postgres", "123456", [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
            ]);
        } catch(\Throwable $th) {
            echo "Error: {$th->getMessage()}";
        }       
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}