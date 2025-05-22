<?php
session_start();
include("../script/connessione.php");

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header('Location: ../GUI/paginalogin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="icon" type="image/png" href="../img/logo.jpg">
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .admin-header {
            background-color: #0d6efd;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
        }
        .form-container {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container-fluid p-0">
    <div class="admin-header text-center">
        <div class="container">
            <h1><i class="fas fa-user-shield me-2"></i>Pannello Amministrazione</h1>
            <a href="../script/scriptlogout.php" class="btn btn-outline-light mt-3">
                <i class="fas fa-sign-out-alt me-2"></i>Log-Out
            </a>
        </div>
    </div>

    <div class="container my-5">
        <?php
        $sql = "SELECT ri.codiceristorante, ri.nome AS NomeRistorante, ri.indirizzo, ri.citta, COUNT(re.idrecensione) AS numero_recensioni, ri.lat, ri.lon 
                FROM ristorante ri
                LEFT JOIN recensione re ON ri.codiceristorante = re.codiceristorante
                GROUP BY ri.codiceristorante";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            echo '<div class="card shadow-sm mb-5">';
            echo '<div class="card-header bg-primary text-white">';
            echo '<h3 class="card-title mb-0"><i class="fas fa-utensils me-2"></i>Ristoranti Registrati</h3>';
            echo '</div>';
            echo '<div class="card-body">';
            echo '<div class="table-responsive">';
            echo '<table class="table table-hover">';
            echo '<thead class="table-light">';
            echo '<tr>
                    <th>Codice</th>
                    <th>Nome</th>
                    <th>Indirizzo</th>
                    <th>Città</th>
                    <th>Recensioni</th>
                    <th>LAT</th>
                    <th>LON</th>
                    <th>Azioni</th>
                  </tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["codiceristorante"] . '</td>';
                echo '<td>' . $row["NomeRistorante"] . '</td>';
                echo '<td>' . $row["indirizzo"] . '</td>';
                echo '<td>' . $row["citta"] . '</td>';
                echo '<td>' . $row["numero_recensioni"] . '</td>';
                echo '<td>' . $row["lat"] . '</td>';
                echo '<td>' . $row["lon"] . '</td>';
                echo '<td>
                        <form method="POST" action="../script/eliminaristorante.php">
                        <input type="hidden" name="codiceristorante" value="' . $row["codiceristorante"] . '">
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt me-1"></i>Elimina
                        </button>
                        </form>
                      </td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div class="alert alert-info">Nessun ristorante presente</div>';
        }
        ?>

        <?php
        if (isset($_SESSION["esito_inserimento"])) {
            if ($_SESSION["esito_inserimento"] === "successo") {
                echo '<div class="alert alert-success">Ristorante inserito con successo</div>';
            } else {
                echo '<div class="alert alert-danger">Impossibile aggiungere il ristorante</div>';
            }
            unset($_SESSION["esito_inserimento"]);
        }

        if (isset($_SESSION["esito_eliminazione"])) {
            if ($_SESSION["esito_eliminazione"] === "successo") {
                echo '<div class="alert alert-success">Ristorante eliminato con successo</div>';
            } else {
                echo '<div class="alert alert-danger">Errore durante l\'eliminazione del ristorante</div>';
            }
            unset($_SESSION["esito_eliminazione"]);
        }
        ?>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0"><i class="fas fa-plus-circle me-2"></i>Inserisci un nuovo ristorante</h3>
            </div>
            <div class="card-body">
                <form action="../script/inserisciristorante.php" method="POST" class="form-container">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="codiceristorante" class="form-label">Codice Ristorante</label>
                            <input type="text" class="form-control" id="codiceristorante" name="codiceristorante" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nome" class="form-label">Nome Ristorante</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="col-md-6">
                            <label for="indirizzo" class="form-label">Indirizzo</label>
                            <input type="text" class="form-control" id="indirizzo" name="indirizzo" required>
                        </div>
                        <div class="col-md-6">
                            <label for="citta" class="form-label">Città</label>
                            <input type="text" class="form-control" id="citta" name="citta" required>
                        </div>
                        <div class="col-12">
                            <input type="hidden" id="latitudine" name="latitudine" required>
                            <input type="hidden" id="longitudine" name="longitudine" required>
                            <label class="form-label">Seleziona la posizione sulla mappa</label>
                            <div id="map"></div>
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Aggiungi Ristorante
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="../script/mappaAdmin.js"></script>

</body>
</html>