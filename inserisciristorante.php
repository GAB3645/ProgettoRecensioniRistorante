<?php
session_start();
include("connessione.php");

$codiceristorante = $_POST["codiceristorante"];
$nome = $_POST["nome"];
$indirizzo = $_POST["indirizzo"];
$citta = $_POST["citta"];

$sql = "INSERT INTO ristorante (codiceristorante,nome, indirizzo, citta) VALUES ('$codiceristorante','$nome', '$indirizzo', '$citta')";

if ($conn->query($sql) === TRUE) {
    $_SESSION["esito_inserimento"] = "successo";
} else {
    $_SESSION["esito_inserimento"] = "errore";
}

header("Location: pannelloadmin.php");
exit;
?>
