<?php

namespace Database;

use Dotenv\Dotenv;
use PDO;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

class DBConnection extends \PDO
{
    private string $dbname;
    private string $host;
    private string $username;
    private string $password;
    private PDO $pdo;


    public function __construct()
    {
        $this->dbname = $_ENV["DB_NAME"];
        $this->host = $_ENV["DB_HOST"];
        $this->username = $_ENV["DB_USER"];
        $this->password = $_ENV["DB_PASS"];
    }

    public function getPDO(): PDO
    {
        return $this->pdo ?? $this->pdo = new PDO("mysql:dbname=$this->dbname;host=$this->host", $this->username, $this->password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET CHARACTER SET UTF8MB4'
        ]);
    }


//    public function query(string $sql, int $param = null, bool $single = null)
//    {
//        $method = is_null($param) ? 'query' : 'prepare';
//        $fetch = is_null($single) ? 'fetchAll' : 'fetch';
//        $stmt = $this->getPDO()->$method($sql);
//        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->pdo]);
//
//        if ($method === 'query') {
//            return $stmt->$fetch();
//        }else{
//            $stmt->execute([$param]);
//            return $stmt->$fetch();
//        }
//    }
}