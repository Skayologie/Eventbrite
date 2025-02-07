<?php
namespace App\core;
use Dotenv\Dotenv;
use PDO;

require realpath(__DIR__."/../../vendor/autoload.php");

$dotenv = Dotenv::createImmutable(__DIR__."/../../");
$dotenv->load();

class Database{
    public function getConnection()
    {
        $DB_SERVER   = $_ENV["HOST"];
        $DB_USERNAME = $_ENV["USERNAME"];
        $DB_PASSWORD = $_ENV["PASSWORD"];
        $DB_NAME     = $_ENV["DB"];
        $source = "mysql:host=$DB_SERVER;dbname=$DB_NAME;user=$DB_USERNAME;password=$DB_PASSWORD";
        return new PDO($source);
    }
}