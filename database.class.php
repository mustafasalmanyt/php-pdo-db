<?php


/*
  Author: Mustafa Salman YT
  Web: mustafa.slmn.tr
  Mail: mustafa@slmn.tr
*/

!defined("index") ? die("Geçersiz İstek :(") : null;
date_default_timezone_set('Europe/Istanbul');

class database
{

  private $hostname;
  private $dbname;
  private $username;
  private $password;
  private $charset;
  private $collation;
  private $pdo       = null;
  private $stmt      = null;
  private $log       = null;

  private function ConnectDB()
  {
    $SQL = "mysql:host=" . $this->hostname . ";dbname=" . $this->dbname;
    try {
      $this->pdo = new \PDO($SQL, $this->username, $this->password);
      $this->pdo->exec("SET NAMES '" . $this->charset . "' COLLATE '" . $this->collation . "'");
      $this->pdo->exec("SET CHARACTER SET '" . $this->charset . "'");
      $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    } catch (PDOException $e) {
      $this->ExceptionLog($e->getMessage());
      die();
    }
  }

  public function __construct()
  {
    $this->hostname = $_ENV['DB_HOSTNAME'];
    $this->dbname = $_ENV['DB_NAME'];
    $this->username = $_ENV['DB_USERNAME'];
    $this->password = $_ENV['DB_PASSWORD'];
    $this->charset = $_ENV['DB_CHARSET'];
    $this->collation = $_ENV['DB_COLLATION'];
    $this->log = new log();
    $this->ConnectDB();
  }

  private function myQuery($query, $params = null)
  {
    if (is_null($params)) {
      $this->stmt = $this->pdo->query($query);
    } else {
      $this->stmt = $this->pdo->prepare($query);
      $this->stmt->execute($params);
    }
    return $this->stmt;
  }

  public function getRows($query, $params = null)
  {               //çoklu satır verilerini çekmek için
    try {
      return $this->myQuery($query, $params)->fetchAll();
    } catch (PDOException $e) {
      $this->ExceptionLog($e->getMessage());
      die();
    }
  }

  public function getRow($query, $params = null)
  {                //tek satır veri çekmek  için
    try {
      return $this->myQuery($query, $params)->fetch();
    } catch (PDOException $e) {
      $this->ExceptionLog($e->getMessage());
      die();
    }
  }


  public function getRowsCount($query, $params = null)
  {               //say
    try {
      $dd = $this->myQuery($query, $params)->rowCount();
      return $dd;
    } catch (PDOException $e) {
      $this->ExceptionLog($e->getMessage());
      die();
    }
  }

  public function getColumn($query, $params = null)
  {             //tek satırın sütun verisini çekmek için nokta veri alışı
    try {
      return $this->myQuery($query, $params)->fetchColumn();
    } catch (PDOException $e) {
      $this->ExceptionLog($e->getMessage());
      die();
    }
  }

  public function Insert($query, $params = null)
  {                //kayıt eklemek için             
    try {
      $this->myQuery($query, $params);
      return $this->pdo->lastInsertId();
    } catch (PDOException $e) {
      $this->ExceptionLog($e->getMessage());
      die();
    }
  }

  public function Update($query, $params = null)
  {                //kayıt güncellemek için
    try {
      return $this->myQuery($query, $params)->rowCount();
    } catch (PDOException $e) {
      $this->ExceptionLog($e->getMessage());
      die();
    }
  }

  public function Delete($query, $params = null)
  {                //kayıt Silmek için
    return $this->Update($query, $params);
  }


  public function __destruct()
  {                               //bağlantıyı kapat
    $this->pdo = NULL;
    unset($this->pdo);
  }




  private function ExceptionLog($message, $sql = "")
  {
    $exception = 'İşlenmeyen özel durum. <br />';
    $exception .= $message;
    $exception .= "<br /> Hatayı günlükte bulabilirsin.";

    if (!empty($sql)) {
      $message .= "\r\nRaw SQL : " . $sql;
    }
    $this->log->write($message);

    return $exception;
  }


  public function CreateDB($query)
  {
    //veritabanı oluşturmak için
    $myDB = $this->pdo->query($query . ' CHARACTER SET ' . $this->CHARSET . ' COLLATE ' . $this->COLLATION);
    return $myDB;
  }

  public function TableOperations($query)
  {
    //tablo operasyonları için
    $myTable = $this->pdo->query($query);
    return $myTable;
  }

  public function Maintenance()
  {
    //tabloların bakımı için
    $myTable = $this->pdo->query("SHOW TABLES");
    $myTable->setFetchMode(\PDO::FETCH_NUM);
    if ($myTable) {
      foreach ($myTable as $items) {
        $check = $this->pdo->query("CHECK TABLE " . $items[0]);
        $analyze = $this->pdo->query("ANALYZE TABLE " . $items[0]);
        $repair = $this->pdo->query("REPAIR TABLE " . $items[0]);
        $optimize = $this->pdo->query("OPTIMIZE TABLE " . $items[0]);
        if ($check == true && $analyze == true && $repair == true && $optimize == true) {
          echo $items[0] . ' adlı Tablonuzun bakımı yapıldı<br>';
        } else {
          echo 'Bir hata oluştu';
        }
      }
    }
  }
}
