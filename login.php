<?php
	session_start();

	
	if(!isset($_POST['login']) || (!isset($_POST['haslo']))) {
		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection -> connect_errno != 0) { //nie uda sie ustanowic polaczenia
		echo "Error: ".$connection -> connect_errno . "Opis: ".$connection -> connect_error;
	}
	else { 

		$login = $_POST['login']; 
		$haslo = $_POST['haslo'];
	
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
        
		if ($rezultat = @$connection -> query(sprintf("SELECT * FROM uzytkownicy WHERE login = '%s' AND haslo = '%s'",
		mysqli_real_escape_string($connection, $login),
		mysqli_real_escape_string($connection, $haslo)))) 
		{

			$ilu_userow = $rezultat -> num_rows;
			if ($ilu_userow == 1) {
				$_SESSION['zalogowany'] = true;
				$wiersz = $rezultat -> fetch_assoc(); 
				$_SESSION['id'] = $wiersz['id_uzytkownika'];
				$_SESSION['user'] = $wiersz['login']; 
                $_SESSION['kto'] = $wiersz['id_roli']; 
               
                $sessionID = $_SESSION['id'];
				
				
                $sql1= "SELECT * FROM uzytkownicy WHERE id_uzytkownika = $sessionID";
                if ($rezultat1 = @$connection -> query($sql1)) {
                    $wiersz1 = $rezultat1 -> fetch_assoc(); //tablica asocjacyjna
                    $_SESSION['imie'] = $wiersz1['imie']; //wyciagamy kolumne id-ucznia
                    $_SESSION['nazwisko'] = $wiersz1['nazwisko']; //wyciagamy kolumne nazwisko
				    $_SESSION['email'] = $wiersz1['email']; //wyciagamy kolumne nazwisko   
                }
                
                $rezultat1 -> free_result();
                
				unset($_SESSION['blad']);
				$rezultat -> free_result(); //
               
				
                if ($_SESSION['kto'] == '1') {
                    header('Location: administrator/wypozyczenia.php');
				}
                else if ($_SESSION['kto'] == '2') {
                    header('Location: czytelnik/wypozyczenia.php'); 
                }
			}
			else { 
				$_SESSION['blad'] = '<div class="error-in-box"><span style = "color: red;"> Nieprawidlowy login lub haslo! </span></div>';
				header('Location: index.php');
			}
		}
		$connection -> close();
	}
?>