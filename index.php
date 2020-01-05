<?php
    ### Session check ###
    session_start();
    #Session variables
    if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
        #If session is already started redirect user to the homepage
        header("Location:licenses.php");
    }
    #End session check
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Licenses manager || Login</title>
    <link rel="stylesheet" href="Source/Css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div id="wrapper">
<span id="error">
    <?php
      if(isset($_GET['e']) && !empty($_GET['e'])){
          $error = $_GET['e'];
        switch ($error) {
          case 1:
            echo "Your session has expired. Please login to continue.";
          break;
          case 2:
            echo "Username or password incorrect ! Please try again.";
          break;
          default:
          break;
        }
      }
    ?>
  </span>
    <div id="flexWrapper">        
        <div id="headerWrapper">
            <header id="header">
                <div id="logoWrapper">
                    <h1>Licences manager</h1>
                </div>
            </header>
        </div>
        <div id="mainWrapper">
            <main id="main">
                <div id="formWrapper">
                    <form action="login.php" method="POST">
                        <label for="username"><i class="fa fa-user"></i> Username:</label>
                        <input type="text" name="username" maxlength="20" required>
                        <label for="password"><i class="fa fa-lock"></i> Password: </label>
                        <div id="passwordWrapper">
                            <input type="password" name="password" id="password" required>  
                        </div>
                        <button type="submit">Login</button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>
</body>
</html>