<?php

session_start();
require_once('../connect.php');
require_once "../connect.php";

if(!isset($_SESSION['zalogowany'])) {
    header('Location: ../index.php');
    exit();
} //ten IF jest na kazdej podstronie, gdzie user moze byc zalogownay

$connection = @new mysqli($host, $db_user, $db_password, $db_name);
$sessionID = $_SESSION['id'];

$sql0 = "SELECT imie, nazwisko, login, haslo, email FROM uzytkownicy WHERE id_uzytkownika=$sessionID";
if ($rezultat0 = @$connection -> query($sql0)) {
    $row0 = mysqli_fetch_row($rezultat0);
    $s_imie = $row0[0];
    $s_nazwisko = $row0[1];
    $s_login = $row0[2];
    $s_haslo = $row0[3];
    $s_email = $row0[4];
}

if (isset($_POST['zatwierdz'])) {
    if (isset($_POST['i_haslo']) ? $haslo = $_POST['i_haslo'] : $haslo = $s_haslo) {
        $sql1 = "UPDATE uzytkownicy SET haslo='$haslo' WHERE id_uzytkownika=$sessionID";
        $connection->query($sql1);
    }
    if (isset($_POST['i_imie']) ? $imie = $_POST['i_imie'] : $imie = $s_imie) {
        $sql2 = "UPDATE uzytkownicy SET imie='$imie' WHERE id_uzytkownika=$sessionID";
        $connection->query($sql2);
    }
    if (isset($_POST['i_nazwisko']) ? $nazwisko = $_POST['i_nazwisko'] : $nazwisko = $s_nazwisko) {
        $sql3 = "UPDATE uzytkownicy SET nazwisko='$nazwisko' WHERE id_uzytkownika=$sessionID";
        $connection->query($sql3);
    }
    if (isset($_POST['i_email']) ? $email = $_POST['i_email'] : $haslo = $s_email) {
        $sql4 = "UPDATE uzytkownicy SET email='$email' WHERE id_uzytkownika=$sessionID";
        $connection->query($sql4);
    }
    if (@$connection->query($sql1) || @$connection->query($sql2) || @$connection->query($sql3) || @$connection->query($sql4)) {
        header('Location: moje-dane.php ');
    }
    else {
        header('Location: ../blad.php ');
    }
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
                <div class="tytul_podstrony">Edytuj swoje dane</div><div class="clear"></div> <hr/>
                <b>Edycja danych osobowych</b><br/><br/>
                <?php  
                    $sql1 = "SELECT imie, nazwisko, login, haslo, email FROM uzytkownicy WHERE id_uzytkownika=$sessionID";
                    if ($rezultat1 = @$connection -> query($sql1)) {
                        $row1 = mysqli_fetch_row($rezultat1);
                    }
                ?>
                    
                <form method="post">
                    <div style="padding-top: 18px; width: 6%; float: left;">
                        <p>Imię:</p>
                        <p>Nazwisko:</p>
                        <p>Hasło:</p>
                        <p>Email:</p>
                    </div>
                    <div style="padding-top: 13px; width: 12%; float: left;">
                        <textarea name="i_imie" type="text" style="height: 30px;"><?php echo $row1[0]; ?></textarea> <br/>
                        <textarea name="i_nazwisko" type="text" style="height: 30px;"><?php echo $row1[1]; ?></textarea> <br/>
                        <textarea name="i_haslo" type="password" style="height: 30px;"><?php echo $row1[3]; ?></textarea> <br/>
                        <textarea name="i_email" type="text" style="height: 30px;"><?php echo $row1[4]; ?></textarea> <br/>
                    </div>
                    <br/><br/><br/><br/><br/><br/><br/><br/>
                    <input type="submit" value="Zatwierdź dane" name="zatwierdz" />
                </form>
            </div>
        </div> <!-- content -->
    </body>
</html>