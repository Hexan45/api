<?php

namespace core\Database\Executors;

use core\Database\Executors\DatabaseExecutorInterface;
use core\Database\Connectors\DatabaseConnectorInterface;
use \PDO;
use \PDOStatement;

class PDOExecutor implements DatabaseExecutorInterface
{

    private string $queryContent;

    private array $bindParams;

    private static $connectionInstance;

    private PDOStatement $queryStatement;

    const FETCH_TYPES = [
        1 => PDO::FETCH_ASSOC,
        2 => PDO::FETCH_OBJ
    ];

    public function __construct(string $query, array $binds, PDO $connectionInstance)
    {
        $this->queryContent = $query;
        $this->bindParams = $binds;

        self::$connectionInstance = $connectionInstance;

        return $this;
    }

    public function execute() : bool
    {
        $this->queryStatement = self::$connectionInstance->prepare($this->queryContent);

        return $this->queryStatement->execute($this->bindParams);
    }

    public function fetchData(int $fetchType = 1) : mixed
    {
        if ($this->queryStatement->rowCount() > 0)
        {
            return $this->queryStatement->fetchAll(self::FETCH_TYPES[$fetchType]);
        }
        return false;
    }
}