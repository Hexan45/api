<?php

namespace core\Database;

use core\Database\Connectors\DatabaseConnectorInterface;
use core\Database\Executors\DatabaseExecutorInterface;
use core\Config\Manager\Config;

class DatabaseAdapter
{

    const CONNECTORS_NAMESPACE = '\\core\\Database\\Connectors\\';

    const EXECUTORS_NAMESPACE = '\\core\\Database\\Executors\\';

    private DatabaseConnectorInterface $databaseConnector;

    private string $databaseExecutor;

    public function __construct()
    {
        $this->databaseConnector = $this->getConnector();
        $this->databaseExecutor = $this->getExecutor();

        $this->databaseConnector->openConnection();
    }

    private function getConnector() : DatabaseConnectorInterface
    {
        $connectorName = self::CONNECTORS_NAMESPACE . ucfirst(Config::$configData['default_connector']) . 'Connector';
        return new $connectorName;
    }

    private function getExecutor() : string
    {
        return self::EXECUTORS_NAMESPACE . ucfirst(Config::$configData['default_connector']) . 'Executor';
    }

    public function query(string|array $query, array $binds = array()) : DatabaseExecutorInterface
    {
        $executorInstance = new $this->databaseExecutor($query, $binds, $this->databaseConnector->getConnectionInstance());
        return $executorInstance;
    }
}