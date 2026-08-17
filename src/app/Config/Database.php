<?php
namespace App\Config;

use PDO;

class Database
{

    // conexion pdo con mysql
    private $host = 'localhost';

    private $user = 'root';
    private $password = '';
    private $database = 'laboratorio-pos-uped';

    // puerto de mysql
    private $port = '3306';
    private $charset = 'utf8mb4';
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host={$this->host};port={$this->port};dbname={$this->database};charset={$this->charset}", $this->user, $this->password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection()
    {
        return $this->pdo;
    }
    
}