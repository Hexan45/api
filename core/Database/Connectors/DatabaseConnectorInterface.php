<?php

namespace core\Database\Connectors;

interface DatabaseConnectorInterface
{
    public function __construct();

    public function openConnection() : self;
}