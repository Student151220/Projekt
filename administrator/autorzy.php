<?php

session_start();

if(!isset($_SESSION['zalogowany'])) {
    header('Location: ../index.php');
    exit();
} 
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
                <div class="tytul_podstrony">Autorzy</div><a href="dodaj-autora.php"><div class="dodajakt">Dodaj autora</div></a><div class="clear"></div> <hr/>
                <?php 
                    $sql1 = "SELECT imie, nazwisko, id_autora FROM autor ORDER BY autor.nazwisko DESC";
                    if ($rezultat1 = @$connection -> query($sql1)) {
                        $ilosc = $rezultat1 -> num_rows;
                        if ($ilosc == 0) {
                            echo "Brak autorów.";
                        }
                        else {
                            while($row1 = mysqli_fetch_row($rezultat1)) {
                                extract($row1);
                                $idek = $row1[2]; 
                                    
                                echo '<div style="padding-top: 23px; width: 100%; float: left;"><p>'.$row1[0].' '.$row1[1].'</p></div>';
                            }
                        }
                    } 
                ?>   
            </div>
        </div>
    </body>
</html>