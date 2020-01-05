<?php
    ### Session check ###
    session_start();
    isset($_SESSION['user_id']) && !empty($_SESSION['user_id']) ? : header("Location:index.php?e=2");
    #End session check
session_destroy(); //destroy the session
header("location:index.php"); //to redirect back to "index.php" after logging out
exit();
?>