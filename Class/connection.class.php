<?php
/**
 * CLASS "CONNECTION"
 * 
 * Class for establishing connection to the database using myslqi approach
 * @author: Jasmin Kovačević
 * @see: Bottom of file for testing examples
 */
class Connection{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "licenses_manager";
    public $connection; # Hold the connection
    private static $instance = null;   # Hold the class instance.

    public function __construct(){
        #Create connection
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->db);
        #Check if everything is ok
        if($this->connection->connect_errno) {
            #If we have connection error get error description
            echo "Connection failed: " . $this->connection->connect_error;
            exit();
        }
    }
    /**
    **** Method for creating instance of "Connection" class ****
    *  First check if instance of the class already exists.
    *  If instance doesn't exist it creates one and stores it to the $instance variable
    *  @return $instance of the "Connection" class
    */
    public static function getInstance(){
        if(!self::$instance){
        self::$instance = new Connection();
        }
        return self::$instance;
    }

    /**
    ***** Method for connecting to the database ****
    *  @return object with connection
    */
    public function getConnection(){
        return $this->connection;
    }

    /**
    **** Method for closing connection ****
    */
    public function closeConnection(){
        $this->connection->close();
    }
}
/** 
 * Testing passed:
 * 
 * $connection = new Connection;
 * var_dump($connection->getInstance());
 * var_dump($connection->getConnection());
 * $connection->closeConnection();
*/
?>