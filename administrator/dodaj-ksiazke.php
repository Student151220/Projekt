<?php

session_start();

if(!isset($_SESSION['zalogowany'])) {
    header('Location: ../index.php');
    exit();
} //ten IF jest na kazdej podstronie, gdzie user moze byc zalogownay
require_once('../connect.php');

    if ((isset($_POST['k_tytul'])) && (isset($_POST['k_ilosc']))) {
        $tytul = $_POST['k_tytul'];
        $autor = $_POST['k_autor'];
        $gatunek = $_POST['k_gatunek'];
        $wydawnictwo = $_POST['k_wydawnictwo'];
        $ilosc = $_POST['k_ilosc'];
        
        require_once "../connect.php";

        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        if ($connection -> connect_errno != 0) {
            echo "Error: ".$connection -> connect_errno . "Opis: ".$connection -> connect_error;
        }
        else {
            $sql1 = "INSERT INTO ksiazka VALUES (NULL, '$tytul', $autor, $gatunek, $wydawnictwo, $ilosc, $ilosc)";
            if ($connection->query($sql1)) {
                header('Location: ksiazki.php ');
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
            <div style="padding-bottom: 20px !important; padding-top: 20px !important; width: 100%;"> Dodaj nową ksiażkę </div>
            <div class="clear"></div> 
               
            <form method="post">
                <input name="k_tytul" type="text" placeholder="Tytuł książki" required/> <br/><br/> <!-- k_nazwa --> 

                <label> Wybierz autora </label>
                <select name="k_autor"> 
                    <?php 
                        $sql2 = "SELECT * FROM autor";
                        $result2 = @$connection -> query($sql2);
                        while($row2 = mysqli_fetch_row($result2))
                        {
                            echo '<option value='.$row2[0].'>'.$row2[1].' '.$row2[2].'</option>';
                        }
                    ?>
                </select>
                <br/><br/> 
                          
                <label> Wybierz gatunek </label>
                <select name="k_gatunek"> 
                    <?php 
                        $sql3 = "SELECT * FROM gatunek";
                        $result3 = @$connection -> query($sql3);
                        while($row3 = mysqli_fetch_row($result3)) {
                            echo '<option value='.$row3[0].'>'.$row3[1].'</option>';
                        }
                    ?>
                </select>
                <br/><br/>    
                          
                <label> Wybierz wydawnictwo </label>
                <select name="k_wydawnictwo"> <!-- k_sala -->
                    <?php 
                        $sql4 = "SELECT * FROM wydawnictwo";
                        $result4 = @$connection -> query($sql4);
                        while($row4 = mysqli_fetch_row($result4)) {
                            echo '<option value='.$row4[0].'>'.$row4[1].'</option>';
                        }
                    ?>
                </select>
                <br/><br/>    
                <input name="k_ilosc" type="number" placeholder="Ilość egzemplarzy" required/> <br/><br/> <!-- k_ilosc -->

                <br/><br/>  
                <input type="submit" value="Dodaj" />
            </form>
        </div> <!-- content -->
    </body>
</html>