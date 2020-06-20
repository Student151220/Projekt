<?php
    session_start();
    require_once('../connect.php');

    if (isset($_POST['rezerwacja'])) {
        require_once "../connect.php";
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        $ider = (isset($_GET['id'])) ? (int)$_GET['id'] : 0; //id_wypozyczenia
        $id_ksiazki = (isset($_GET['id_ksiazki'])) ? (int)$_GET['id_ksiazki'] : 0; //id_ksiazki

        $datas = date('d-m-Y');
        $data=date("Y-m-d", strtotime($datas));
        $ts = strtotime($data);
        
        $sql2 = "SELECT id_uzytkownika FROM wypozyczenie WHERE id_wypozyczenia=$ider";
        $rezultat2 = $connection -> query($sql2);
        $row2 = mysqli_fetch_row($rezultat2);
        $iduz = $row2[0];
    
        $sql5 = "SELECT * FROM wypozyczenie WHERE id_uzytkownika=$iduz AND czy_oddana='nie' AND data_oddania < '$data'"; // zalegle
        $rezultat5 = $connection -> query($sql5);
        $row5 = mysqli_fetch_row($rezultat5);
        $ile_wypozyczen_zaleglych = $rezultat5 -> num_rows;
        
        $sql6 = "SELECT * FROM wypozyczenie WHERE id_uzytkownika=$iduz AND czy_oddana='nie' AND data_oddania > '$data'"; //terminowe
        $rezultat6 = $connection -> query($sql6);
        $row6 = mysqli_fetch_row($rezultat6);
        $ile_wypozyczen = $rezultat5 -> num_rows;

        if ($connection -> connect_errno != 0) {
            echo "Error: ".$connection -> connect_errno . "Opis: ".$connection -> connect_error;
        }
        else {
            $sql8 = "DELETE FROM rezerwacja WHERE id_ksiazki = $id_ksiazki AND id_uzytkownika = $iduz";
            $rezultat8 = $connection -> query($sql8);
        //    $row8 = mysqli_fetch_row($rezultat8);

            $sql1 = "UPDATE wypozyczenie SET czy_oddana='tak', data_oddania='$data' WHERE id_wypozyczenia=$ider";
            if ($connection->query($sql1)) {

                        $sql7 = "SELECT * FROM ksiazka WHERE id_ksiazki=$id_ksiazki";
                        $rezultat7 = @$connection -> query($sql7);
                        $row7 = mysqli_fetch_row($rezultat7);
                        $nowailosc = $row7[6] + 1;
                        $sql8 = "UPDATE ksiazka SET ilosc_dost_egz='$nowailosc' WHERE id_ksiazki=$id_ksiazki";
                        $rezultat8 = @$connection -> query($sql8);
                        $row8 = mysqli_fetch_row($rezultat8);
                        header('Location: wypozyczenia.php ');   
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
                <div class="tytul_podstrony">Potwierdź oddanie książki po wypożyczeniu</div><div class="clear"></div> <hr/>
                <?php
                    $datas = date('d-m-Y');
                    $data=date("Y-m-d", strtotime($datas));
                    $akt_id = (isset($_GET['id'])) ? (int)$_GET['id'] : 0; // pobiera z adresu jaka jest podstrona 
                    $ider = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;       // pobiera id z adresu             
                    $sql1 = "SELECT * FROM wypozyczenie WHERE id_wypozyczenia=$ider";
                    
                    $result1 = @$connection -> query($sql1);
                    if ($rezultat1 = @$connection -> query($sql1)) {
                        $ilosc = $rezultat1 -> num_rows;
                        if ($ilosc == 0) {
                            echo "Nie ma takiego wypożyczenia.";
                        }
                        else {
                            while($row1 = mysqli_fetch_row($rezultat1)) {
                                extract($row1);
                                $idek = $row1[0]; //id rezerwacji 
                                $iduz = $row1[1];
                                $idks = $row1[2];
                                
                                $sql2 = "SELECT imie, nazwisko FROM uzytkownicy WHERE id_uzytkownika=$iduz";
                                $rezultat2 = @$connection -> query($sql2);
                                $row2 = mysqli_fetch_row($rezultat2);
                                
                                $sql3 = "SELECT tytul, id_autora FROM ksiazka WHERE id_ksiazki=$idks";
                                $rezultat3 = @$connection -> query($sql3);
                                $row3 = mysqli_fetch_row($rezultat3);
                                $idau = $row3[1];                                      
                                
                                $sql4 = "SELECT imie, nazwisko FROM autor WHERE id_autora=$idau";
                                $rezultat4 = @$connection -> query($sql4);
                                $row4 = mysqli_fetch_row($rezultat4);
                                
                                $sql5 = "SELECT * FROM wypozyczenie WHERE id_uzytkownika=$iduz AND czy_oddana='nie' ";
                                $rezultat5 = @$connection -> query($sql5);
                                $row5 = mysqli_fetch_row($rezultat5);
                                
                                echo "<p>Masz zamiar potwierdzić oddanie wypożyczonej pozycji:</p> <br/>";
                                echo $row2[0]." ".$row2[1].", pozycja: ".$row4[0]." ".$row4[1]." - ".$row3[0];
                                echo "<br/>Czy na pewno chcesz to zrobić?<br/><br/>";
                                
                            ?>
                            <form method="post">
                                <input type="submit" value="Potwierdź" name="rezerwacja" />
                            </form>
                            <?php
                                echo "<hr/>"; //tresc
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                    }
                ?>
            </div> <!-- content -->
        </div>
    </body>
</html>