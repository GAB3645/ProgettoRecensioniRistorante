<?php
session_start();
include("connessione.php");

$nome = $_POST["nome"];
$indirizzo = $_POST["indirizzo"];
$citta = $_POST["citta"];

$sql = "INSERT INTO ristorante (nome, indirizzo, citta) VALUES ('$nome', '$indirizzo', '$citta')";

if ($conn->query($sql) === TRUE) {
    $_SESSION["esito_inserimento"] = "successo";
} else {
    $_SESSION["esito_inserimento"] = "errore";
}

header("Location: pannelloadmin.php");
exit;
?>
