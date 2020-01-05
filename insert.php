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
$typeValues = new Database;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Licenses Manager || Insert license</title>
    <link rel="stylesheet" href="Source/Css/style.css">
</head>
<body>
<div id="wrapper">
    <?php include "menu.php"; ?>
    <div id="main_wrapper">
        <main>
            <div id="insert_form_wrapper">
                <form action="finishInsert.php" method="POST">
                    <label for="license_name">License name</label>
                    <input type="text" name="license_name" max_length="200" required autofocus>
                    <label for="license_period">License period</label>
                    <input type="number" name="license_period" max_length="255" min="1" required>
                    <?php $typeValues->getTypes() ?>
                    <button type="submit">Add license</button>
                </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>