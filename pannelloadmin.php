<?php
session_start();
include("connessione.php");


if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header('Location: paginalogin.php');
    exit;
}


$sql = "SELECT ri.codiceristorante, ri.nome AS NomeRistorante, ri.indirizzo, ri.citta, COUNT(re.idrecensione) AS numero_recensioni 
FROM ristorante ri
LEFT JOIN recensione re ON ri.codiceristorante = re.codiceristorante
GROUP BY ri.codiceristorante";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped'>";
    echo "<tr><th>Codice Ristorante</th><th>Nome Ristorante</th><th>Indirizzo</th><th>Città</th><th>Numero Recensioni</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["codiceristorante"] . "</td><td>" . $row["NomeRistorante"] . "</td><td>" . $row["indirizzo"]. "</td><td>" . $row["citta"]. "</td><td>" . $row["numero_recensioni"]. "</td></tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "<p>Nessuna ristorante presente</p>";
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

