<?php

namespace core\Database\Connectors;

use core\Database\Connectors\DatabaseConnectorInterface;
use core\Exception\DatabaseConnectorException;
use core\Config\Manager\Config;
use \PDO;

class PDOConnector implements DatabaseConnectorInterface
{
    /*
     * DatabaseAdapter DSN and user data
     */
    private string $host;
    private string $DBMS;
    private string $databaseName;
    private string $databaseUser;
    private string $databasePassword;
    private string $databasePort;
    private string $databaseCharset;

    /*
     * PDO default options for connection
     */
    private array $pdoOptions = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    private string $pdoDSN;
    private ?PDO $connectionInstance;

    public function __construct()
    {
        $this->host = Config::$configData['PDO']['database_host'];
        $this->DBMS = Config::$configData['PDO']['database_engine'];
        $this->databaseName = Config::$configData['PDO']['database_name'];
        $this->databaseUser = Config::$configData['PDO']['database_user'];
        $this->databasePassword = Config::$configData['PDO']['database_password'];
        $this->databasePort = Config::$configData['PDO']['database_port'];
        $this->databaseCharset = Config::$configData['PDO']['database_charset'];

        $this->pdoDSN = "$this->DBMS:host=$this->host;dbname=$this->databaseName;charset=$this->databaseCharset;port=$this->databasePort";
    }

    public function openConnection() : self
    {
        if(isset($this->connectionInstance)) return $this;

        $this->connectionInstance = new PDO($this->pdoDSN, $this->databaseUser, $this->databasePassword, $this->pdoOptions);
        return $this;
    }

    public function closeConnection() : self
    {
        if(!isset($this->connectionInstance)) return $this;
        var_dump('zamykanie');

        $this->connectionInstance = null;
        return $this;
    }

    /*
     * Getters for variables from class
     */

    public function getDatabaseName() : string
    {
        return $this->databaseName;
    }

    public function getConnectionInstance() : PDO
    {
        return $this->connectionInstance;
    }
}