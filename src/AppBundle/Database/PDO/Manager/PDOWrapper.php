<?php

namespace AppBundle\Database\PDO\Manager;

use PDO;

final class PDOWrapper
{
    /** @var PDO */
    private $pdo;

    /**
     * @param $host
     * @param $db
     * @param $user
     * @param $pass
     * @param $charset
     */
    public function __construct($host, $db, $user, $pass, $charset)
    {
        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }

    /**
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}