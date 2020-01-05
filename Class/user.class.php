<?php
/**
 * CLASS "USER"
 * Class for working about user
 * @author: Jasmin Kovačević
 * @see: Bottom of page for testing examples
 */
class User{
    private static $instance;
    private static $connection;
    public $result;
    /**
     **** Method for connecting to the database ****
     *  @return connection to the static $connection variable 
     */
    public static function connect(){
        self::$instance = Connection::getInstance();
        self::$connection = self::$instance->getConnection();
    }
    /**
     **** Method for checking login credentials of user ****
     *  @param:
     * $username (string) - User username
     * $password (string) - User password 
     */
    public function login($username, $password){
        $this->username = $username;
        $this->password = $password;
        #Converting password to md5()
        $this->hashPassword = md5($this->password);
        #Connecting to the database
        self::connect();
        $this->query = "SELECT user_id, username FROM user WHERE username = '$this->username' AND password = '$this->hashPassword'";
        $this->queryResult = self::$connection->query($this->query);

        #If we have results that means that user exists and he has given exact login credentials
        if($this->queryResult->num_rows > 0){
            $this->userData = $this->queryResult->fetch_assoc();
                #Start the session and set session variables
                session_start();
                    $_SESSION['user_id'] = $this->userData['user_id'];
                    $_SESSION['username'] = $this->userData['username'];
                #Redirect user to homepage
                header("Location:licenses.php");
        }else{
            #If we don't have results that means that user doesn't exist or he give wrong login credentials
            header("location:index.php?e=2");
        }
    }
}
/**
 * Testing passed:
 * 
 * include "connection.class.php";
 * 
 * $user = new User;
 * $user->login("test_user1", "TestUserPassword.1!");
 * $user->login("test_user2", "TestUserPassword.2!");
 */
?>