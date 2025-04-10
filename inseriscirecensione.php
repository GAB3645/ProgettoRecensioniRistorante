<?php
session_start();
include("connessione.php");

if(isset($_POST["ristorante"]) && isset($_POST["voto"])) {
    $nomeRistorante = $_POST['ristorante'];
    $voto = $_POST['voto'];
    $data = date("Y-m-d");
    $idutente = $_SESSION["loggedUser"];

    $sql = "SELECT codiceristorante FROM ristorante WHERE nome = '".$nomeRistorante."'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $codiceRistorante = $row["codiceristorante"];

        $sql = "INSERT INTO recensione (idutente, voto, data, codiceristorante) VALUES ('$idutente', '$voto', '$data', '$codiceRistorante')";
        $result = $conn->query($sql);

        if ($result === TRUE) {
            $_SESSION["esitoRecensione"] = true;
            header('Location: benvenuto.php');
        } else {
            $_SESSION["esitoRecensione"] = false;
            header('Location: benvenuto.php');
        }
    } else {
        $_SESSION["esitoRecensione"] = false;
        header('Location: benvenuto.php');
    }
}
?>

