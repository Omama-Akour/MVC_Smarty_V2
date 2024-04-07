<?php

class Database {

   // Properties to store database connection details and query results
   public $host;
   public $username;
   public $password;
   public $db_name;

   public $con;// Database connection object
   public $exec;// Query execution result
   public $result;// Query result

 // Constructor to initialize database connection details
   public function __construct()
   {
       $this->host = 'localhost';
       $this->username = 'root';
       $this->password = '';
       $this->db_name = 'mvc';
   }

   public function Connect()
   {
       $this->con = mysqli_connect($this->host, $this->username, $this->password) or die('Connection string Error');
       mysqli_select_db($this->con, $this->db_name) or die("$this->db_name this Database not found");
   }
  // Method to execute SQL queries
   public function Query($qry) 
   {
        $this->Connect(); // Establishing a database connection
        $this->exec = mysqli_query($this->con, $qry);   // Executing the query
        return $this->exec;
      
   }
   public function getConnection() {
    return $this->con;
}
public function prepare($sql) {
  return $this->con->prepare($sql);
}

}
