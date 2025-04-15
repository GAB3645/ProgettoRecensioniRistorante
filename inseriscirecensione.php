<?php
session_start();
include("connessione.php");

if(isset($_POST["ristorante"]) && isset($_POST["voto"])) {
    $nomeRistorante = $_POST['ristorante'];
    $voto = $_POST['voto'];
    $data = date("Y-m-d");

    $username = $_SESSION["loggedUser"];
    $sql = "SELECT id_utente FROM utente WHERE username = '".$username."'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idutente = $row["id_utente"];
    } else {
        header('Location: logout.php');
        exit;
    }

    $sql = "SELECT codiceristorante FROM ristorante WHERE nome = '".$nomeRistorante."'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $codiceRistorante = $row["codiceristorante"];

        $sql = "SELECT COUNT(*) AS numero_recensioni
        FROM recensione r
        JOIN utente u
        ON r.idutente = u.id_utente 
        WHERE u.username = '".$username."' AND r.codiceristorante = '".$codiceRistorante."'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            if($row["numero_recensioni"] == 0) {
                $sql = "INSERT INTO recensione (voto, idutente, codiceristorante) VALUES ('$voto', '$idutente', '$codiceRistorante')";
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

