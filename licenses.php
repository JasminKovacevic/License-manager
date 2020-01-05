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

$secure = new Security;
$secureFrom = ["'", ";"];
$licenses = new Database;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>License manager || All licenses</title>
    <link rel="stylesheet" href="Source/Css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div id="wrapper">
    <?php include "menu.php" ?>
    <div id="main_wrapper">
        <main>
            <a href="insert.php" title="Add new license">Add license +</a>
            <div id="search_form_wrapper">
                <form action="" method="GET">
                    <?php
                        #check if search keyword is set, if is than give the input that value
                        if(isset($_GET['q']) && !empty($_GET['q'])){
                            echo "<input type='text' name='q' value='" . $_GET['q'] . "'>";
                        }else{
                            echo "<input type='text' name='q' placeholder='Search licenses...'>";
                        }
                    ?>
                    <?php 
                        $licenses->getTypes(); 
                    ?>
                    <button type="submit">Search</button>
                </form>
            </div>
            <?php
            #Checking if type or search keyword are inserted for passing right values to method for displaying licenses
            if(isset($_GET['q']) && !empty($_GET['q'])){
                if(isset($_GET['license_type'])){
                    $licenses->showLicenses($secure->cleanString($_GET['q'], $secureFrom), $_GET['license_type']);
                }else{
                    $licenses->showLicenses($secure->cleanString($_GET['q'], $secureFrom), null); 
                }
            }elseif(isset($_GET['license_type'])){
                $licenses->showLicenses(null, $_GET['license_type']); 
            }else{
                $licenses->showLicenses(); 
            }
            ?>
        </main>
    </div>
</div>
</body>
</html>