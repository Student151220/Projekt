<?php

session_start();
require_once('../connect.php');

if(!isset($_SESSION['zalogowany'])) {
    header('Location: ../index.php');
    exit();
} //ten IF jest na kazdej podstronie, gdzie user moze byc zalogownay

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
            <div class="tytul_podstrony" style="margin-top: 20px;">Moje rezerwacje</div><div class="clear"></div> <hr/>
            <?php
                $ider = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;       // pobiera id z adresu 
                $datas = date('d-m-Y');
                $data = date("Y-m-d", strtotime($datas));
                $sql1 = "SELECT * FROM rezerwacja WHERE id_uzytkownika=$sessionID AND data_odebrania > '$data' AND czy_odebrana='nie' ";
                if ($rezultat1 = $connection -> query($sql1)) {
                    $ilosc = $rezultat1 -> num_rows;
                    if ($ilosc == 0) {
                        echo "Brak rezerwacji.";
                    } else {
                        echo "<table>";
                        echo "<tr>";
                        echo "<td>TYTUŁ</td>";
                        echo "<td>AUTOR</td>";
                        echo "<td>GATUNEK</td>";
                        echo "<td>WYDAWNICTWO</td>";
                        echo "<td>CZAS REZERWACJI</td>";
                        echo "<td>CZAS NA ODEBRANIE</td>";
                        echo "<td>ANULUJ</td>";
                        echo "</tr>";
                    
                        while($row1 = mysqli_fetch_row($rezultat1)) {
                            echo "<tr>";
                            extract($row1);
                            $idek = $row1[0]; //id rezerwacji
                            $idks = $row1[1];
                            $iduz = $row1[2];
                            $data_rez = $row1[3];
                            
                            $sql2 = "SELECT * FROM ksiazka WHERE id_ksiazki=$idks";
                            $rezultat2 = $connection -> query($sql2);
                            
                            while($row2 = mysqli_fetch_row($rezultat2)) {
                                extract($row2);
                                $tytul = $row2[1];
                                $idautora = $row2[2];
                                $idgatunku = $row2[3];
                                $idwydawnictwa = $row2[4];
                                $ilosc_dost = $row2[6];
                            }
                            
                            $sql3 = "SELECT * FROM autor WHERE id_autora=$idautora";
                            $rezultat3 = @$connection -> query($sql3);
                            while($row3 = mysqli_fetch_row($rezultat3)) {
                                extract($row3);
                                $autorimie = $row3[1];
                                $autornazwisko = $row3[2];
                            }
                            
                            $sql4 = "SELECT * FROM gatunek WHERE id_gatunku=$idgatunku";
                            $rezultat4 = @$connection -> query($sql4);
                            while($row4 = mysqli_fetch_row($rezultat4)) {
                                extract($row4);
                                $gatunek = $row4[1];
                            }
                            
                            $sql5 = "SELECT * FROM wydawnictwo WHERE id_wydawnictwa=$idwydawnictwa";
                            $rezultat5 = @$connection -> query($sql5);
                            while($row5 = mysqli_fetch_row($rezultat5)) {
                                extract($row5);
                                $wydawnictwo = $row5[1];
                            }
                            
                            $ts = strtotime($data_rez);
                            //echo "<td>".date('Y-m-d H:i', strtotime('+71 hour +59 minute', $ts))."</td>";
                            
                            echo "<td>".$tytul."</td>";
                            echo "<td>".$autorimie." ".$autornazwisko."</td>";
                            echo "<td>".$gatunek."</td>";
                            echo "<td>".$wydawnictwo."</td>";
                            echo "<td>".$data_rez."</td>";
                            echo "<td>".date('Y-m-d H:i', strtotime('+71 hour +59 minute', $ts))."</td>";
                            
                            $rezerwacja_odebrana = $row1[5];
                            if ($rezerwacja_odebrana == 'nie') {
                                echo "<td><a href='anuluj-rezerwacje.php?id=$idks'><div class='dodajakt'>Anuluj rezerwację</div></a></td>";
                            }
                            else {
                                echo "<td>Wypożyczona</td>";
                            }      
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            ?> 
        </div> <!--tresc -->
    </body>
</html>