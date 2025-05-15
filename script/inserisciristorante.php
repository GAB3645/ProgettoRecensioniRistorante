<?php
session_start();
include("../script/connessione.php");

$codiceristorante = $_POST["codiceristorante"];
$nome = $_POST["nome"];
$indirizzo = $_POST["indirizzo"];
$citta = $_POST["citta"];
$latitudine = $_POST["latitudine"];
$longitudine = $_POST["longitudine"];

$sql = "INSERT INTO ristorante (codiceristorante,nome, indirizzo, citta, lat, lon) VALUES ('$codiceristorante','$nome', '$indirizzo', '$citta','$latitudine', '$longitudine')";

if ($conn->query($sql) === TRUE) {
    $_SESSION["esito_inserimento"] = "successo";
} else {
    $_SESSION["esito_inserimento"] = "errore";
}

header("Location: ../GUI/pannelloadmin.php");
exit;
?>
