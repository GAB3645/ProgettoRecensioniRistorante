<?php
session_start();
include("connessione.php");

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header('Location: paginalogin.php');
    exit;
}

$codice = $_POST["codiceristorante"];

$sql1 = "DELETE FROM recensione WHERE codiceristorante = '$codice'";
$conn->query($sql1);

$sql2 = "DELETE FROM ristorante WHERE codiceristorante = '$codice'";
if ($conn->query($sql2) === TRUE) {
    $_SESSION["esito_eliminazione"] = "successo";
} else {
    $_SESSION["esito_eliminazione"] = "errore";
}

$conn->close();
header("Location: pannelloadmin.php");
exit;

