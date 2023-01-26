<?php

namespace src\Models\v1;

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