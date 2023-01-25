<?php

namespace core\Database\Executors;

interface DatabaseExecutorInterface
{
    const FETCH_ASSOC = 1;

    const FETCH_OBJ = 2;

    public function execute() : bool;

    public function fetchData(int $fetchType = 1) : mixed;
}