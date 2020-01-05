<?php
### Session check ###
session_start();
#Session variables
if(!isset($_SESSION['user_id']) && empty($_SESSION['user_id'])){
    header("Location:index.php?e=1");
}
#End session check

include "Class/connection.class.php";
include "Class/database.class.php";

#Checking if license_id is set and does it exist in database
if(isset($_GET['license_id'])){
    $checkLicense = new Database;
    if($checkLicense->checkLicense($_GET['license_id']) === false){
        header("Location:licenses.php");
    }else{
        $license_id = $_GET['license_id'];
    }
}else{
    header("Location:licenses.php");
}
$row = new Database;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Licenses Manager || Update license</title>
    <link rel="stylesheet" href="Source/Css/style.css">
</head>
<body>
<div id="wrapper">
    <?php include "menu.php"; ?>
    <div id="main_wrapper">
        <main>
            <div id="insert_form_wrapper">
            <form action="finishUpdate.php?license_id=<?php echo $license_id; ?>" method="POST">
                <label for="license_name">License name</label>
                <input type="text" name="license_name" max_length="200" value="<?php $row->getRow($license_id, "name", "license", "license_id"); ?>" required autofocus>
                <label for="license_period">License period</label>
                <input type="number" name="license_period" max_length="255" value="<?php $row->getRow($license_id, "period", "license", "license_id"); ?>" min="1" required>
                <?php $row->getSelectedType($license_id); ?>
                <button type="submit">Save</button>
            </form>
            </div>
        </main>
    </div>
</div>
</body>
</html>