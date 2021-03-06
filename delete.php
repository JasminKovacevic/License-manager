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

#Checking if license_id is set for deleting
if(isset($_GET['license_id'])){
    #Checking if license with given license_id exists in database
    $checkLicense = new Database;
    if($checkLicense->checkLicense($_GET['license_id']) === false){
        #If license doesn't exist redirect user to the homepage
        header("Location:licenses.php");
    }else{
        $license_id = $_GET['license_id'];
    }
}else{
    #If license_id is not set redirect user to the homepage
    header("Location:licenses.php");
}

#If everything is ok delete the license and redirect user back to the homepage
$deleteLicense = new Database;
$deleteLicense->deleteLicense($license_id);
header("Location:licenses.php");
?>