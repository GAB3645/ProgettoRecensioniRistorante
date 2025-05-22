<?php
session_start();
include("../script/connessione.php");

if ($_SESSION["logged"] != false) {
    $username = $_SESSION["loggedUser"];

    if (isset($_POST["nuovapassword"])) {
        $nuovapassword = hash("sha256", $_POST["nuovapassword"]);

        $sql = "UPDATE utente SET password = '$nuovapassword' WHERE username = '$username'";

        if ($conn->query($sql) === TRUE) {
            $_SESSION["passwordCambioEsito"] = "success";
        } else {
            $_SESSION["passwordCambioEsito"] = "error";
        }
    } else {
        $_SESSION["passwordCambioEsito"] = "error";
    }

    header("Location: ../GUI/benvenuto.php");
    exit();
}
?>

