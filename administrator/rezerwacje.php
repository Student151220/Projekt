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
                    echo '<br/><b><a href="../logout.php">Wyloguj</a></b></div>';
                            
                ?>
            </div>
            <div>
                <?php include_once('menu.php'); ?>
            </div>
        </div> <!-- display: flex -->


        <div class="content">
            <div class="col-md-12" style="padding-top: 30px;">
                <div class="tytul_podstrony">Wszystkie rezerwacje</div><div class="clear"></div> 
                <hr/>
                <?php
                    $datas = date('d-m-Y');
                    $data=date("Y-m-d", strtotime($datas));
                    
                    $akt_id = (isset($_GET['id'])) ? (int)$_GET['id'] : 0; // pobiera z adresu jaka jest podstrona
                    $ider = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;       // pobiera id z adresu             
                    $sql1 = "SELECT * FROM rezerwacja WHERE czy_odebrana='nie' AND data_odebrania > '$data'";
                        
                    $result1 = $connection -> query($sql1);
                    if ($rezultat1 = $connection -> query($sql1)) {
                        $ilosc = $rezultat1 -> num_rows;
                        if ($ilosc == 0) {
                            echo "Brak rezerwacji.";
                        }
                        else {
                            echo "<table>";
                            echo "<tr>";
                            echo "<td>UŻYTKOWNIK</td>";
                            echo "<td>TYTUŁ KSIĄŻKI</td>";
                            echo "<td>TERMIN REZERWACJI</td>";
                            echo "<td>PLANOWANY TERMIN ODEBRANIA</td>";
                            echo "<td>POTWIERDŹ</td>";
                            echo "</tr>";
                        
                            while($row1 = mysqli_fetch_row($rezultat1)) {
                                echo "<tr>";
                                extract($row1);
                                $idek = $row1[0]; //id rezerwacji
                                $idks = $row1[1];
                                $iduz = $row1[2];
                                $data_rez = $row1[3];
                                $data_odb = $row1[4];
                                
                                $sql2 = "SELECT * FROM uzytkownicy WHERE id_uzytkownika=$iduz";
                                $rezultat2 = @$connection -> query($sql2);
                                $row2 = mysqli_fetch_row($rezultat2);
                                
                                
                                $sql3 = "SELECT * FROM ksiazka WHERE id_ksiazki=$idks";
                                $rezultat3 = @$connection -> query($sql3);
                                $row3 = mysqli_fetch_row($rezultat3);
                                $idau = $row3[2];
                                $tytul = $row3[1];
                                $idgat = $row3[3];
                                $idwyd = $row3[4];
                                
                                $sql4 = "SELECT imie, nazwisko FROM autor WHERE id_autora=$idau";
                                $rezultat4 = $connection -> query($sql4);
                                $row4 = mysqli_fetch_row($rezultat4);
                                
                                
                                echo "<td>".$row2[1]." ".$row2[2]."</td>";
                                echo "<td>".$row3[1]."</td>";
                                echo "<td>".$row1[3]."</td>";
                                echo "<td>".$row1[4]."</td>";
                                
                                echo "<td><a href='potwierdz-odebranie.php?id=$idek&id_ksiazki=$idks'><div class='dodajakt'>Potwierdź odebranie</div></a></td>";

                                echo "</tr>";
                            }

                            echo "</table>";
                        }
                    }
                ?>
            </div> <!--tresc -->
        </div> <!-- content -->
    </body>
</html>