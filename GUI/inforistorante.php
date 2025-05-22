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
    
    $sql = "SELECT ri.lat, ri.lon
            FROM ristorante ri
            WHERE ri.nome = '$nomeRistorante'";
    $result_coords = $conn->query($sql);
    
    if ($result_coords && $result_coords->num_rows > 0) {
        $row = $result_coords->fetch_assoc();
        $latitudine = $row["lat"];
        $longitudine = $row["lon"];
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informazioni Ristorante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    body {
      background-image: url('../img/restaurant-5521372_1280.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      background-blend-mode: multiply;
    }
</style>

</head>
<body class="bg-light" onload="caricaMappa(<?php echo $latitudine; ?>, <?php echo $longitudine; ?>)">
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">
                <i class="fas fa-utensils me-2"></i><?php echo htmlspecialchars($nomeRistorante); ?>
            </h1>
            <a href="../GUI/benvenuto.php" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-2"></i>Torna indietro
            </a>
        </div>
        
        <?php if (isset($result) && $result->num_rows > 0) { ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0"><i class="fas fa-star me-2"></i>Recensioni</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Voto</th>
                                <th>Data</th>
                                <th>Utente</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?php 
                                    for ($i = 1; $i <= 5; $i++) {
                                        if ($i <= $row["voto"]) {
                                            echo '<i class="fas fa-star text-warning"></i>';
                                        } else {
                                            echo '<i class="far fa-star text-warning"></i>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?php echo $row["data"]; ?></td>
                                <td><?php echo htmlspecialchars($row["username"]); ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php } else { ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>Nessuna recensione presente per questo ristorante
        </div>
        <?php } ?>
        
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0"><i class="fas fa-map-marked-alt me-2"></i>Posizione</h3>
            </div>
            <div class="card-body p-0">
                <div id="map" class="rounded-bottom" style="height: 500px; width: 100%;"></div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <script src="../script/mappa.js"></script>
</body>
</html>