<?php
    session_start();
    if($_SESSION["logged"] != false) {
        echo "<h1>Benvenuto " . $_SESSION["loggedUser"] . "</h1>";
        include("connessione.php");
        $sql = "SELECT * FROM utente WHERE username = '".$_SESSION["loggedUser"]."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<p> Nome: " . $row["nome"]. "</p>";
                echo "<p> Cognome: " . $row["cognome"]. "</p>";
                echo "<p> Email: " . $row["email"]. "</p>";
            }
        }
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
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <br><a href="scriptlogout.php"><button type="button" class="btn btn-danger">Log-Out</button></a>
</body>
</html>

