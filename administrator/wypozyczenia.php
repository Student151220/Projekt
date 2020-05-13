<?php

session_start();
require_once('../connect.php');

?>

<!DOCTYPE html>
<html lang="pl_PL">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="../css/bootstrap.css">
      
    <script src="../js/bootstrap.min.js"></script>
  </head>
  <body>
  
    <?php
        $connection = mysqli_connect($host, $db_user, $db_password, $db_name);
        mysqli_select_db($connection, "biblioteka");
    ?>

    <!-- header -->
    <div class="dis-flex nav-bar">
      <div>
        <?php
          echo '<div class="show_logged_user">'.$_SESSION['imie'].' '.$_SESSION['nazwisko'].'</div>';
          echo '<div class="user_role">';
            echo "<b>ADMINISTRATOR</b><br/><br/>";
            echo $_SESSION['email'];    
            echo '<br/><b><a href="../logout.php">Wyloguj</a></b>';
          echo '</div>';            
        ?>
      </div>
      <div>
        <?php include_once('menu.php'); ?>
      </div>
    </div> <!-- display: flex -->


    <div class="content">
      <div class="col-md-12" style="padding-top: 30px;">
        <div class="tytul_podstrony">Wszystkie wypożyczenia</div>
        <div class="clear"></div> 
        <hr/>
        <?php
                 
        ?>
        </div>
    </div> <!-- content -->




  </body>
</html>