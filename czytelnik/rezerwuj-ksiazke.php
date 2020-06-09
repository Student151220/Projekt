<?php
session_start();

if(!isset($_SESSION['zalogowany'])) {
    header('Location: ../index.php');
    exit();
} //ten IF jest na kazdej podstronie, gdzie user moze byc zalogownay

if(isset($_SESSION['blokada']) && ($_SESSION['blokada']) == 'true') {
    header('Location: ../czytelnik/blokada.php');
}
require_once('../connect.php');

if (isset($_POST['rezerwacja'])) {
    $ider = (isset($_GET['id_ksiazki'])) ? (int)$_GET['id_ksiazki'] : 0; // id ksiazki - 2
    $idek = (isset($_GET['id_uzytkownika'])) ? (int)$_GET['id_uzytkownika'] : 0; // id uzytkownika - 4

    $id = $_SESSION['id'];
    $datas = date('d-m-Y');
    $data=date("Y-m-d", strtotime($datas));
    $ts = strtotime($data);
    $dataodb = date('Y-m-d H:i', strtotime('+47 hour +59 minute', $ts));
    
    $datao = date("Y-m-d", strtotime($dataodb));
    echo $datao;
    require_once "../connect.php";

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($connection -> connect_errno != 0) {
        echo "Error: ".$connection -> connect_errno . "Opis: ".$connection -> connect_error;
    }
    else {
        $sql1 = "INSERT INTO rezerwacja VALUES (NULL, $ider, $idek, NOW(), '$datao', 'nie')";
        
        if ($connection->query($sql1)) {
            $sql2 = "SELECT * FROM ksiazka WHERE id_ksiazki=$ider";
            $rezultat2 = @$connection -> query($sql2);
            $row2 = mysqli_fetch_row($rezultat2);
            $nowailosc = $row2[6] - 1;
            
            
            
            $sql3 = "UPDATE ksiazka SET ilosc_dost_egz='$nowailosc' WHERE id_ksiazki=$ider";
            if ($connection->query($sql3)) {
                header('Location: rezerwacje.php ');
            }
            else  {
                header('Location: ../blad.php ');
            }
            
        }
        else {
            header('Location: ../blad.php ');
        }
    }
    
    }
    else
    {
        
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
                        echo "<b>CZYTELNIK</b><br/><br/>";
                        echo $_SESSION['email'];    
                    echo '<br/><b><a href="../logout.php">Wyloguj</a></b></div>';
                    $sessionID = $_SESSION['id'];
                ?>
            </div>
            <div>
                <?php include_once('menu.php'); ?>
            </div>
        </div> <!-- display: flex -->
        <div class="content">
            <div class="col-md-12" style="padding-top: 30px;">
                <?php 
                    $ider = (isset($_GET['id_ksiazki'])) ? (int)$_GET['id_ksiazki'] : 0; 
                    $sql1 = "SELECT * FROM ksiazka WHERE ksiazka.id_ksiazki = $ider";
                    $k = 1;
                    $result1 = @$connection -> query($sql1);
                    if ($rezultat1 = @$connection -> query($sql1)) {
                        $ilosc = $rezultat1 -> num_rows;
                        if ($ilosc == 0) {
                            echo "Brak książek.";
                        }
                        else {
                            while($row1 = mysqli_fetch_row($rezultat1)) {
                                extract($row1);
                                $idek = $row1[0]; 
                                $tytul = $row1[1];
                                $autor = $row1[2];
                                $gatunek = $row1[3];
                                $wydawnictwo = $row1[4];
                                $ilosc = $row1[5];
                                $ilosc_dost = $row1[6];
                                
                                $sql2 = "SELECT imie, nazwisko FROM autor WHERE id_autora=$autor";
                                $rezultat2 = @$connection -> query($sql2);
                                $row2 = mysqli_fetch_row($rezultat2);
                                
                                $sql3 = "SELECT gatunek FROM gatunek WHERE id_gatunku=$gatunek";
                                $rezultat3 = @$connection -> query($sql3);
                                $row3 = mysqli_fetch_row($rezultat3);
                                
                                $sql4 = "SELECT wydawnictwo FROM wydawnictwo WHERE id_wydawnictwa=$wydawnictwo";
                                $rezultat4 = @$connection -> query($sql4);
                                $row4 = mysqli_fetch_row($rezultat4);
                                echo "Masz zamiar zarezerwować książkę: <br/>";
                                echo $row1[1]." autora: ".$row2[0]." ".$row2[1].", gatunek: ".$row3[0].", wydawnictwo: ".$row4[0];
                                
                                echo "<br/> Czy na pewno chcesz to zrobić? <br/>";
                            ?>
                            <form method="post">
                                <input type="submit" value="Rezerwuj" name="rezerwacja" />
                            </form>
                            <?php
                                echo "<hr/>"; //tresc
                                echo "</tr>";
                            }
                        echo "</table>";
                        }
                    }  
                ?>     
            </div>   
        </div> <!-- content -->
    </body>
</html>