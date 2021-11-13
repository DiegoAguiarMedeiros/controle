<?php

namespace Api\Model;

use Zend\Db\Adapter\Adapter;

class Connection
{
    private $adapter;
    private $drive = 'Mysqli';
    private $host = 'localhost';
    private $database = 'estoque';
    private $user = 'root';
    private $pass = '';

    public function __construct()
    {
        $this->adapter = new Adapter([
            'driver'   => $this->drive,
            'host'   => $this->host,
            'database' => $this->database,
            'username' => $this->user,
            'password' => $this->pass,
            'resources.db.params.charset' => "utf8",
        ]);
    }

    public function getAdapter()
    {
        return $this->adapter;
    }
}
