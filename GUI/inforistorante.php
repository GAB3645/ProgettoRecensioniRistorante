<?php

session_start();
include("../script/connessione.php");

if (isset($_POST["ristorante"])) {
    $nomeRistorante = $_POST["ristorante"];

    $sql = "SELECT re.voto, re.data, u.username 
            FROM recensione re 
            JOIN utente u ON re.idutente = u.id_utente 
            JOIN ristorante ri ON re.codiceristorante = ri.codiceristorante 
            WHERE ri.nome = '$nomeRistorante'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Voto</th><th>Data</th><th>Utente</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["voto"]. "</td><td>" . $row["data"]. "</td><td>" . $row["username"]. "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>Nessuna recensione presente</h2>";
    }
}


    $sql = "SELECT ri.lat, ri.lon
            FROM ristorante ri
            WHERE ri.nome = '$nomeRistorante'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $latitudine = $row["lat"];
        $longitudine = $row["lon"];
    }
    var_dump($latitudine);
    var_dump($longitudine);


?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="../css/styleInforistorante.css">
     <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
</head>
<body onload="caricaMappa(<?php echo $latitudine; ?>, <?php echo $longitudine; ?>)">
    <br><a href="../GUI/benvenuto.php"><button type="button" class="btn btn-primary">Indietro</button></a>

    <div id="map" style="width: 800px; height: 600px; margin-top: 50px; margin-left: auto; margin-right: auto;"></div>

</body>

<script src="../script/mappa.js"></script>
</html>

