<?php
### Session check ###
session_start();
#Session variables
if(!isset($_SESSION['user_id']) && empty($_SESSION['user_id'])){
    #If session is not started redirect user to login page
    header("Location:index.php?e=1");
}
#End session check

include "Class/connection.class.php";
include "Class/database.class.php";
include "Class/security.class.php";
include "Class/user.class.php";

#Cleaning inputs
if(isset($_POST['username']) && isset($_POST['password'])){
    $checkInput = new Security;
    $cleanFrom = ["'", ";"];
    $username = $checkInput->cleanString($_POST['username'], $cleanFrom);
    $password = $checkInput->cleanString($_POST['password'], $cleanFrom);
}else{
    header("Location:index.php");
}
#Checking user login credentials
$login = new User;
$login->login($username, $password);
?>