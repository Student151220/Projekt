<?php
session_start();

//przekierowanie po zalogowaniu na czytelnika lub administratora
if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true))
{
	if ($_SESSION['kto'] == '1') {
        header('Location: administrator/rezerwacje.php');
    } 
    else if ($_SESSION['kto'] == '2') {
        header('Location: czytelnik/rezerwacje.php'); 
    }

	exit();
}


// obsługa formularza rejestracji
if (isset($_POST['i_email'])) {
    $login = $_POST['i_login'];
    $imie = $_POST['i_imie'];
    $nazwisko = $_POST['i_nazwisko'];
    $email = $_POST['i_email'];
    $haslo = $_POST['i_haslo'];
    $datas = $_POST['i_data'];
    $tel = $_POST['i_tel'];
    $data=date("Y-m-d", strtotime($datas));
        
    require_once "connect.php";

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
    if ($connection -> connect_errno != 0) { //nie uda sie ustanowic polaczenia
        echo "Error: ".$connection -> connect_errno . "Opis: ".$connection -> connect_error;
    } 
    else {
        $sql1 = "SELECT * FROM uzytkownicy WHERE login = '$login'";
        $result1 = @$connection -> query($sql1);
        $czy_jest_user = $result1 -> num_rows;
            
        if ($czy_jest_user == 0) {     
            if ($connection->query("INSERT INTO uzytkownicy VALUES (NULL, '$imie', '$nazwisko', '$data', '$email', '$login', '$haslo', '$tel', 2, 'nie')")) {
                header('Location: witamy.php');
            }     
        }
        else { 
            ?>
                <script>
                    alert("Wybrany login jest już zajęty. Wybierz inny login");
                </script>
            <?php
            }
        }
    }
?>

<html lang="pl_PL">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.css">
	    <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="header">
            <h1 style="padding-top: 45px;">Wirtualna biblioteka</h1>
        </div>
        <div class="container">
            <div class="row justify-content-around" style="padding-top: 100px;">
                <div class="col-md-5 text-center login" style="padding-top: 45px; padding-bottom: 50px;">
                    <b>Logowanie</b><br/><br/>

                    <form action="login.php" method="post" >
                        <br/><br/>
                        <input type="text" name="login" placeholder="Login"/>
                        <input type="password" name="haslo" placeholder="Hasło"/><br/><br/>
                        <input type="submit" value="Zaloguj" />
                    </form>
                    <p> Dane do wersji demo:</p>
                    <p> admin: login: jkowalski, hasło: 123 <br/>czytelnik: login: czytelnik1, hasło: 123</p>
                    <?php
                        if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
                    ?>
                </div>

                <div class="col-md-2" style="padding-top: 45px;"></div>

                <div class="col-md-5 text-center register" style="padding-top: 45px;">
                    <b>Rejestracja dla czytelników</b><br/><br/>
                    <form method="post">
                        <input name="i_login" type="text" placeholder="Login"/> <br/>
                        <input name="i_haslo" type="password" placeholder="Hasło"/> <br/>
                        <input name="i_imie" type="text" placeholder="Imię"/> <br/>
                        <input name="i_nazwisko" type="text"  placeholder="Nazwisko"/> <br/>
                        <input name="i_email" type="text" placeholder="E-mail"/> <br/>
                        <input name="i_tel" type="text" placeholder="Telefon"/> <br/>
                        <input name="i_data" type="date" placeholder="Data urodzenia"/> <br/><br/>
                        <input type="submit" value="Zarejestruj" />
                    </form>
                </div>
                <br/>
                <br/>
    
            </div>
        </div>
    </body>
</html>