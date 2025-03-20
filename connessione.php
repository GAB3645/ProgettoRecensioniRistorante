<?php
$servernameDB = "localhost";
$usernameDB = "root";
$passwordDB = "";
$dbnameDB = "ristorante_recensioni";

mysqli_report(MYSQLI_REPORT_OFF);


$conn = new mysqli($servernameDB, $usernameDB, $passwordDB, $dbnameDB);	

if ($conn->connect_error) {
  header("Location: errore.html");
}
?>