<?php

namespace App\Core;

use App\Exception\InternalServerErrorException;
use PDO;

class DataBase
{
    public PDO $pdo;

    public function __construct(array $envConfig)
    {
        $dsn = $envConfig['dsn'];
        $user = $envConfig['user'];
        $password = $envConfig['password'];
        $this->pdo = new PDO($dsn, $user, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}