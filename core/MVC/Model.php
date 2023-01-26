<?php

namespace core\MVC;

use core\Database\DatabaseAdapter;
use core\Database\Executors\DatabaseExecutorInterface;

abstract class Model
{

    private static DatabaseAdapter $db;

    protected string $tableName;

    protected string $primaryKey = 'id';

    private array $toSave = [];

    /*
     * TODO: Add deleting method for models
     */

    protected function __construct(?int $id = null)
    {
        self::$db = new DatabaseAdapter();

        if (is_integer($id))
        {
            $result = $this->find(['id', '=', ':id'], [':id' => $id]);

            if ($result !== false) $this->toSave = array_merge($this->toSave, ...$result);
        }
    }

    public function __set(string $name, mixed $value) : void
    {
        $this->toSave[$name] = $value;
    }

    public function __get(string $name) : mixed
    {
        return array_key_exists($name, $this->toSave) ? $this->toSave[$name] : null;
    }

    public function save() : bool
    {
        $records = implode(', ', array_keys($this->toSave));
        $replacers = implode(', ', array_fill(0, count($this->toSave), '?'));

        $result = self::$db->query("INSERT INTO $this->tableName ($records) VALUES ($replacers)", array_values($this->toSave));

        return $result->execute();
    }

    public function update() : bool
    {
        $set = implode(' = ?, ', array_keys($this->toSave)) . ' = ?';
        $id = $this->toSave[$this->primaryKey];

        $binds = array_values($this->toSave);
        array_push($binds, $id);

        $result = self::$db->query("UPDATE $this->tableName SET $set WHERE $this->primaryKey = ?", $binds);

        return $result->execute();
    }

    public function delete() : bool
    {
        $result = self::$db->query("DELETE FROM $this->tableName WHERE $this->primaryKey = ?", array($this->toSave[$this->primaryKey]));

        return $result->execute();
    }

    public function all() : array|object|bool
    {
        $result = self::$db->query("SELECT * FROM $this->tableName");

        return $result->execute() ? $result->fetchData(DatabaseExecutorInterface::FETCH_ASSOC) : false;
    }

    public function find(array $conditions, array $bind = []) : array|object|bool
    {
        $conditions = implode(' ', $conditions);
        $result = self::$db->query("SELECT * FROM $this->tableName WHERE $conditions", $bind);

        return $result->execute() ? $result->fetchData(DatabaseExecutorInterface::FETCH_ASSOC) : false;
    }
}