<?php

namespace AppBundle\Database\PDO\Manager;

final class PDOManager
{
    /** @var PDOWrapper */
    private $pdoWrapper;

    /** @param PDOWrapper $PDOWrapper */
    public function __construct(PDOWrapper $PDOWrapper)
    {
        $this->pdoWrapper = $PDOWrapper;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return \PDOStatement
     */
    final public function executeSql(string $sql, array $params = []): \PDOStatement
    {
        $pdo = $this->pdoWrapper->getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }
}