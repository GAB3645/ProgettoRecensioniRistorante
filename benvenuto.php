<?php
    session_start();
    if($_SESSION["logged"] != false) {
        echo "Benvenuto " . $_SESSION["loggedUser"];
    } else {
        $_SESSION["errMessage"] = "Sessione Scaduta";
        header('Location: errore_loginreg.php');
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
</head>
<body>
<br><a href="scriptlogout.php"><button type="button" class="btn btn-danger">Log-Out</button></a>
</body>
</html>