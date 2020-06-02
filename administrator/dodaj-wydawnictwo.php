<?php

session_start();

if(!isset($_SESSION['zalogowany'])) {
    header('Location: ../index.php');
    exit();
} //ten IF jest na kazdej podstronie, gdzie user moze byc zalogowany
require_once('../connect.php');

    if (isset($_POST['wydawnictwo'])) {
        $wydawnictwo = $_POST['wydawnictwo'];
        require_once "../connect.php";

        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        if ($connection -> connect_errno != 0) {
            echo "Error: ".$connection -> connect_errno . "Opis: ".$connection -> connect_error;
        }
        else {
            $sql1 = "INSERT INTO wydawnictwo VALUES (NULL, '$wydawnictwo')";
            if ($connection->query($sql1)) {
                header('Location: wydawnictwa.php '); 
            }
            else {
                header('Location: ../blad.php ');
            }
        }
    }
    else {
    
    }
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
        <script src="../js/nicEdit.js"></script>
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
                    echo '<br/><b><a href="../logout.php">Wyloguj</a></b></div>';
                            
                ?>
            </div>
            <div>
                <?php include_once('menu.php'); ?>
            </div>
        </div> <!-- display: flex -->


        <div class="content">
            <div class="col-md-12" style="padding-top: 30px;">
                <div class="podtytul"> Dodaj nowe wydawnictwo </div>
                <form method="post">
                    <input name="wydawnictwo" type="text" placeholder="Nazwa wydawnictwa" required/> <br/><br/>
                    <input type="submit" value="Dodaj" />
                </form>
                <br/><br/>
                <p> Wydawnictwa: </p>
                <?php
                    $sql0 = "SELECT * FROM wydawnictwo";
                    $result0 = @$connection -> query($sql0);
                    while($row0 = mysqli_fetch_row($result0)) {
                        echo $row0[0].') '.$row0[1].'<br/>';
                    }
                ?>
            </div> 
        </div><!-- content -->
    </body>
</html>