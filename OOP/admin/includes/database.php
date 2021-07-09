<?php
require_once("new_config.php");

class Database{
    // plik służący do łączenia się z bazą 
    //INSERT INTO `users` (`id`, `username`, `password`, `first_name`, `last_name`) VALUES (NULL, 'John', '123', 'Ricardo', 'Ricardo');
    public $connection;
    function __construct(){
        $this-> open_db_connection();
    }
    public function open_db_connection(){//łączenie się z bazą
        //$this -> connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        $this -> connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if($this->connection->connect_errno){
            die("DataBase diead".$this->connection->connect_errno);
        }
        
    }
    public function query($sql)//metoda która wywołuje nasze zapytanie w bazie
    {
        $result = $this->connection->query($sql);
        $this->confirm_query($result);
        return $result;
    }
    private function confirm_query($result){
        if(!$result){
            die("Query fail".$this->connection->error);
        }
    }
    public function escape_string($string){//metoda odfiltrowujaca podane dane
        $escaped_string =$this->connection->real_escape_string($string);
        return $escaped_string;
    }
    public function the_insert_id(){//metoda która ustawia id dla połączenioa 
        return $this->connection->insert_id;
    }
    public function the_isert_id(){//metoda która zwraca id ostatniego dodanego uzytkownika
        return mysqli_insert_id($this->connection);
    }
}

$database = new Database();



?>
