<?php

namespace core\Database\Connectors;

use core\Database\Connectors\DatabaseConnectorInterface;
use core\Config\Manager\Config;
use MongoDB\Client;

class MongodbConnector implements DatabaseConnectorInterface
{

    private string $DBMS;

    private string $databaseUser;

    private string $databasePassword;

    private string $clusterAddress;

    private string $mongodbDSN;

    private Client $connectionInstance;

    public function __construct()
    {
        $this->databaseUser = Config::$configData['Mongodb']['database_user'];
        $this->databasePassword = Config::$configData['Mongodb']['database_password'];
        $this->clusterAddress = Config::$configData['Mongodb']['database_cluster'];
        $this->DBMS = Config::$configData['Mongodb']['database_engine'];

        $this->mongodbDSN = "mongodb+srv://$this->databaseUser:$this->databasePassword@appproject.q24zo.mongodb.net/?retryWrites=true&w=majority";
    }

    public function openConnection() : self
    {
        if(isset($this->connectionInstance)) return $this;

        $this->connectionInstance = new Client($this->mongodbDSN);
        return $this;
    }

    public function getDBMS() : string
    {
        return $this->DBMS;
    }

    public function getConnectionInstance() : Client
    {
        return $this->connectionInstance;
    }
}