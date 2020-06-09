<?php

session_start();

if(!isset($_SESSION['zalogowany'])) {
    header('Location: ../index.php');
    exit();
} //ten IF jest na kazdej podstronie, gdzie user moze byc zalogownay
require_once('../connect.php');


if ((isset($_POST['k_tytul'])) && (isset($_POST['k_ilosc']))) {
        require_once "../connect.php";
        $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    
        $tytul = $_POST['k_tytul'];
        $autor = $_POST['k_autor'];
        $gatunek = $_POST['k_gatunek'];
        $wydawnictwo = $_POST['k_wydawnictwo'];
        $ilosc_nowa = $_POST['k_ilosc'];
        
        $ider = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;
        
        $sql2 = "SELECT * FROM ksiazka WHERE ksiazka.id_ksiazki = $ider";
        $rezultat2 = $connection -> query($sql2);
        echo $sql2;
        if ($row2 = mysqli_fetch_row($rezultat2)) {
            $ilosc_dost_pobrana = $row2[6];
            $ilosc_pobrana = $row2[5]; 
        }
       

        $ilosc_dost_nowa = 0;
        if ($connection -> connect_errno != 0) {
            echo "Error: ".$connection -> connect_errno . "Opis: ".$connection -> connect_error;
        }
        else {
            if ($ilosc_nowa <= $ilosc_pobrana) {
                $roznica = $ilosc_pobrana - $ilosc_nowa;
                $ilosc_dost_nowa = $ilosc_dost_pobrana - $roznica;
                echo $ilosc_dost_pobrana;
                echo $roznica;
            }
            else if ($ilosc_nowa > $ilosc_pobrana) {
                $roznica = $ilosc_nowa - $ilosc_pobrana;
                $ilosc_dost_nowa = $ilosc_dost_pobrana + $roznica;
                echo $ilosc_dost_pobrana;
                echo $roznica;
            }
            
            $sql1 = "UPDATE ksiazka SET tytul='$tytul', id_autora=$autor, id_gatunku=$gatunek, id_wydawnictwa=$wydawnictwo, ilosc_egz=$ilosc_nowa, ilosc_dost_egz=$ilosc_dost_nowa WHERE id_ksiazki=$ider";
            
            if ($connection->query($sql1)) {
               header('Location: ksiazki.php ');
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
                <?php 
                    $ider = (isset($_GET['id'])) ? (int)$_GET['id'] : 0;
                    $sql1 = "SELECT * FROM ksiazka WHERE ksiazka.id_ksiazki = $ider";
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
                                
                                echo "Edytujesz:<br/><table>";
                                echo "<tr>";
                                echo "<td>TYTUŁ</td>";
                                echo "<td>AUTOR</td>";
                                echo "<td>GATUNEK</td>";
                                echo "<td>WYDAWNICTWO</td>";
                                echo "<td>ILOŚĆ SZTUK</td>";
                                echo "</tr>";
                                    
                                echo "<td>".$row1[1]."</td>";
                                echo "<td>".$row2[0]." ".$row2[1]."</td>";
                                echo "<td>".$row3[0]."</td>";
                                echo "<td>".$row4[0]."</td>";
                                echo "<td>".$row1[5]."</td>";
                                echo "</tr></table>";
                                    
                                echo "<hr/>"; //tresc
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                    }
                ?>
                <form method="post">
                    <div style="width: 20%; float: left; padding-top: 5px;"> 
                        <label style="margin-bottom: 0;"> <p style="padding-bottom: 0px;">Tytuł książki</p> </label> <br/>
                        <label style="margin-bottom: 0;"> <p style="padding-bottom: 0px;">Wybierz autora</p> </label> <br/>
                        <label style="margin-bottom: 0;"> <p style="padding-bottom: 0px;">Wybierz gatunek</p> </label> <br/>
                        <label style="margin-bottom: 0;"> <p style="padding-bottom: 0px;">Wybierz wydawnictwo</p> </label> <br/> 
                        <label style="margin-bottom: 0;"> <p style="padding-bottom: 0px;">Ilość egzemplarzy</p> </label> <br/>
                    </div>
                    
                    <div style="width: 20%; float: left;"> 
                        <textarea name="k_tytul" type="text" style="height: 30px;"><?php echo $tytul; ?></textarea> <br/>
                        <select style="margin-bottom: 5px; height: 30px;" name="k_autor">
                            <?php 
                                $sql2 = "SELECT * FROM autor";
                                $result2 = @$connection -> query($sql2);
                                while($row2 = mysqli_fetch_row($result2)) {
                                    echo '<option value='.$row2[0].'>'.$row2[1].' '.$row2[2].'</option>';
                                }
                            ?>
                        </select> <br/>
                        <select style="margin-bottom: 5px; height: 30px;" name="k_gatunek">
                            <?php 
                                $sql3 = "SELECT * FROM gatunek";
                                $result3 = @$connection -> query($sql3);
                                while($row3 = mysqli_fetch_row($result3)) {
                                    echo '<option value='.$row3[0].'>'.$row3[1].'</option>';
                                }
                            ?>
                        </select> <br/>
                        <select style="margin-bottom: 5px; height: 30px;" name="k_wydawnictwo">
                            <?php 
                                $sql4 = "SELECT * FROM wydawnictwo";
                                $result4 = @$connection -> query($sql4);
                                while($row4 = mysqli_fetch_row($result4)) {
                                    echo '<option value='.$row4[0].'>'.$row4[1].'</option>';
                                }
                            ?>
                        </select> <br/>
                        <textarea name="k_ilosc" type="number" style="height: 30px;"><?php echo $ilosc; ?></textarea> <br/>
                    </div>
                    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>   
                <input type="submit" value="Zatwierdź zmiany" />
                </form>   
            </div>   
        </div><!-- content -->
    </body>
</html>