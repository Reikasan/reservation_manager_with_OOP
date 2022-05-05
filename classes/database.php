<?php 

require_once("config.php");

class Database {
    public $connection;
    public $db;

    function __construct() {
        $this->db = $this->open_db_connection();
    }

    public function open_db_connection() {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if($this->connection->connect_errno) {
            die("Database connection failed" .$this->connection->connect_error);
        }

        return $this->connection;
    }

    public function query($sql) {
        $result = $this->db->query($sql);
        $this->confirm_query($result);

        return $result;
    }

    public function confirm_query($result) {
        if(!$result) {
            die("Query failed " .$this->db->error);
        }
    }

    public function escape_string($string) {
        return $this->db->real_escape_string($string);
    }

}

$database = new Database();

?>