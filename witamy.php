<?php
session_start();

if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true)) {
	if ($_SESSION['kto'] == '1') {
    header('Location: administrator/wypozyczenia.php');
  }
  else if ($_SESSION['kto'] == '2') {
    header('Location: czytelnik/wypozyczenia.php'); //przekierowanie po zalogowaniu
  } 
	exit();
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
      <div class="row" style="padding-top: 100px;">
        <div class="col-xl-12">
          <p style="font-size: 18px; text-align: center;">Rejestracja przebiegła poprawnie. Wróć do poprzedniej strony, aby się zalogować.</p>
          <p style="font-size: 18px; text-align: center;"><a href="index.php">STRONA GŁÓWNA</a></p>
          <br/>
          <br/>
        </div>
      </div>
    </div>
  </body>
</html>