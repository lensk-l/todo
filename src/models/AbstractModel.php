<?php

namespace App\models;

use PDO;

abstract class AbstractModel
{
    protected PDO $connection;

    public function __construct()
    {
        $config = include __DIR__ . '/../../utils/database.php';
        $dsn = $config['dsn'];
        $username = $config['username'];
        $password = $config['password'];

        $connection = new PDO($dsn, $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        $this->connection = $connection;
    }
}
