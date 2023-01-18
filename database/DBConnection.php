<?php

namespace Database;

use PDO;

class DBConnection
{
    private $dbname;
    private $host;
    private $username;
    private $password;

    private $pdo;

    /**
     * @param $dbname
     * @param $host
     * @param $username
     * @param $password
     */
    public function __construct($dbname, $host = 'localhost', $username = 'root', $password = 'root')
    {
        $this->dbname = $dbname;
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
    }

    public function getPDO(): PDO
    {
        return $this->pdo ?? $this->pdo = new PDO("mysql:dbname=secret_agency;host=localhost", 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET UTF8MB4'
        ]);
    }

    public function query($statement)
    {
        $req = $this->getPDO()->query($statement);
        $datas = $req->fetchAll();
        return $datas;
    }
}