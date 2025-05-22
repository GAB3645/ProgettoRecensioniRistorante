<?php
session_start();
include("connessione.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["recensioni"])) {
    $recensioni = $_POST["recensioni"];
    $recensioniEliminate = 0;

    foreach ($recensioni as $idRecensione) {
        $sql = "DELETE FROM recensione WHERE idrecensione = $idRecensione";
        if ($conn->query($sql)) {
            $recensioniEliminate++;
        }
    }

    $_SESSION["recensioniEliminate"] = $recensioniEliminate;
} else {
    $_SESSION["recensioniEliminate"] = 0;
}

header("Location: ../GUI/benvenuto.php");
exit;
?>
