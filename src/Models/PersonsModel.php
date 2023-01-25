<?php

namespace src\Models;

use core\MVC\Model;

class PersonsModel extends Model
{

    protected string $primaryKey = 'id';

    protected string $tableName = 'persons';

    public function __construct()
    {
        parent::__construct(...func_get_args());
    }
}