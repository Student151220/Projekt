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
                <div class="tytul_podstrony">Wszystkie książki</div><a href="dodaj-ksiazke.php"><div class="dodajakt">Dodaj nową</div></a><div class="clear"></div> <hr/>
                <?php
                    $akt_id = (isset($_GET['id'])) ? (int)$_GET['id'] : 0; // pobiera z adresu jaka jest podstrona 
                    $ider = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;       // pobiera id z adresu             
                    $sql1 = "SELECT * FROM ksiazka";
                    $k = 1;
                    $result1 = @$connection -> query($sql1);
                    $ilu_uczniow = $result1 -> num_rows;
                    if ($rezultat1 = @$connection -> query($sql1)) {
                        $ilosc = $rezultat1 -> num_rows;
                        if ($ilosc == 0) {
                            echo "Brak książek."; 
                        }
                        else {
                            echo "<table>";
                            echo "<tr>";
                            echo "<td>TYTUŁ</td>";
                            echo "<td>AUTOR</td>";
                            echo "<td>GATUNEK</td>";
                            echo "<td>WYDAWNICTWO</td>";
                            echo "<td>ILOŚĆ SZTUK</td>";
                            echo "<td>ILOŚĆ DOSTĘPNYCH SZTUK</td>";
                            echo "<td>LINK DO WERSJI CYFROWEJ</td>";
                            echo "<td>EDYTUJ</td>";
                            echo "</tr>";
                                
                            while($row1 = mysqli_fetch_row($rezultat1)) {
                                echo "<tr>";
                                extract($row1);
                                $idek = $row1[0]; 
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
                                      
                                echo "<td>".$row1[1]."</td>";
                                echo "<td>".$row2[0]." ".$row2[1]."</td>";
                                echo "<td>".$row3[0]."</td>";
                                echo "<td>".$row4[0]."</td>";
                                echo "<td>".$row1[5]."</td>";
                                echo "<td>".$row1[6]."</td>";
                                echo "<td>".$row1[7]."</td>";
                                echo "<td><a href='edytuj-ksiazke.php?id=$idek'><div class='dodajakt'>Edytuj ksiażkę</div></a></td>";  
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