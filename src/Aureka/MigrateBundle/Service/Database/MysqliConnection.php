<?php

namespace Aureka\MigrateBundle\Service\Database;

class MysqliConnection implements Connection
{
    private $connection;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }


    public function __destruct()
    {
         $this->connection->close();
    }


    public static function create($host, $user, $password, $database, $encoding = 'utf8')
    {
        $mysqli = mysqli_connect($host, $user, $password, $database);
        $mysqli->set_charset($encoding);
        return new static($mysqli);
    }


    public function execute($query)
    {
        $connection->execute($query);
        return $this;
    }


    public function fetchOne($query)
    {
        return $this->connection->query($query)->fetch_array(MYSQLI_ASSOC);
    }


    public function fetchAll($query)
    {
        return $this->connection->query($query)->fetch_all(MYSQLI_ASSOC);
    }
}
