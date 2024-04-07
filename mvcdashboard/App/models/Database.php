<?php

namespace App\models;
use Exception;

class Database {
    // Properties to store database connection details and query results
    public $host;
    public $username;
    public $password;
    public $db_name;

    public $con; // Database connection object
    public $exec; // Query execution result
    public $result; // Query result

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
        $this->con = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
        if (!$this->con) {
            die('Connection failed: ' . mysqli_connect_error());
        }
    }

    // Method to execute SQL queries
    public function query($qry) 
    {
        $this->Connect(); // Establishing a database connection
        return $this->con->query($qry); // Executing the query
    }

    public function getConnection() {
        $this->Connect(); // Ensure connection is established
        return $this->con;
    }

    public function prepare($sql) {
        // Ensure that the database connection is established
        $this->Connect();
    
        // Check if the connection object is null
        if ($this->con === null) {
            // Handle the error, throw an exception, or return null
            // For demonstration purposes, let's throw an exception
            throw new Exception("Database connection is null");
        }
    
        // Return the prepared statement
        return $this->con->prepare($sql);
    }

    public function escapeString($string)
    {
        $this->Connect(); // Ensure connection is established
        return mysqli_real_escape_string($this->con, $string);
    }

    // Method to get the last inserted ID
    public function lastInsertId()
    {
        $this->Connect(); // Ensure connection is established
        return mysqli_insert_id($this->con);
    }

    public function find($id, $table)
    {
        $sql = "SELECT * FROM $table WHERE id = " . $this->escapeString($id);
        $result = $this->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    }
}
