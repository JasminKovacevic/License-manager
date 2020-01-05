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

$license_name_input = $_POST['license_name'];
$license_period = $_POST['license_period'];
$license_type = $_POST['license_type'];
$user_id = 1;

#Clearing inputs
$secureString = new Security;
$cleanFrom = ["'", ";"];
$license_name = $secureString->cleanString($license_name_input, $cleanFrom);

#When inputs are cleared proceed to the insert and redirect user to the homepage
$newLicense = new Database;
$newLicense->insertLicense($license_name, $license_period, $license_type, $user_id);
header("Location:licenses.php");
?>