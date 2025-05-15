<?php
    session_start();
    include("../script/connessione.php");

    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordHASH = hash("sha256", $password);

    $sql = "SELECT * FROM utente WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $passwordDB = $row["password"];
        if ($passwordDB == $passwordHASH) {
            $_SESSION["loggedUser"] = $username;
            $_SESSION["logged"] = true;
            $_SESSION["idutente"] = $row["id_utente"];
            header('Location: ../GUI/benvenuto.php');
            exit;
        } else {
            $_SESSION["errMessage"] = "Password Errata";
        }
    } else {
        $_SESSION["errMessage"] = "Utente Inesistente";
    }

    header('Location: ../GUI/paginalogin.php');
    exit;
?>

