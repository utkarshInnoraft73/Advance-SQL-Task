<?php

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . "./../");
$dotenv->load();

/**
 * Class to perform the operation related to databses.
 */
class ConnectDB
{
  /**
   * To Stores the database name.
   * 
   * @var string $database;
   *   Database name.
   */
  private $database;

  /**
   * To stores the use name.
   * 
   * @var string $username;
   *   Username.
   */
  private $username;

  /**
   * To stores the password.
   * 
   * @var string $password;
   *   Password.
   */
  private $password;

  /**
   * To stores the host.
   * 
   * @var string $host;
   *   Host.
   */
  private $host;

  private $conn;

  /**
   * Constructor to set the values.
   * 
   * @var string $database;
   *   Database name;
   * @var string $username;
   *   User name.
   * @var string $host;
   *   Host name.
   * @var string $password.
   *   Password.
   */
  function __construct()
  {
    $this->database = $_ENV['DATABASE'];
    $this->username =  $_ENV['USERNAME'];
    $this->password = $_ENV['PASSWORD'];
    $this->host = $_ENV['HOSTNAME'];
  }

  /**
   * To connect the database.
   * 
   * Description:
   *   It connect the database with php by PDO.
   */

  function connectDB()
  {
    try {
      $this->conn = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $this->conn;
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }
}
