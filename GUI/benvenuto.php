<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../img/logo.jpg">
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
<body class="bg-light">
<div class="container">
    <?php
    session_start();
    if ($_SESSION["logged"] != false) {
        $username = $_SESSION["loggedUser"];
        echo '
        <div class="text-center mb-5">
            <h1 class="display-4 text-primary fw-bold">
                <i class="fas fa-user-circle me-2"></i>Benvenuto ' . $username . '
            </h1>
            <p class="lead text-muted">Gestisci il tuo profilo e le tue recensioni</p>
        </div>';

        include("../script/connessione.php");

        $sql = "SELECT * FROM utente WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo '
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0"><i class="fas fa-id-card me-2"></i>Il tuo profilo</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 text-muted">Nome</p>
                            <h5 class="fw-bold">' . $row["nome"] . '</h5>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p class="mb-1 text-muted">Cognome</p>
                            <h5 class="fw-bold">' . $row["cognome"] . '</h5>
                        </div>
                        <div class="col-12 mb-3">
                            <p class="mb-1 text-muted">Email</p>
                            <h5 class="fw-bold">' . $row["email"] . '</h5>
                        </div>
                    </div>
                </div>
            </div>';

            if ($row["admin"] == 1) {
                $_SESSION["admin"] = true;
                header('Location: ../GUI/pannelloadmin.php');
                exit;
            }
        }

        $sql = "SELECT r.idrecensione, ri.nome AS NomeRistorante, ri.indirizzo, r.voto, r.data 
                FROM ristorante ri
                JOIN recensione r ON r.codiceristorante = ri.codiceristorante
                JOIN utente u ON r.idutente = u.id_utente 
                WHERE u.username = '$username'";
        $result = $conn->query($sql);

        echo '<div class="card shadow-sm mb-5">';
        echo '<div class="card-header bg-primary text-white">';
        echo '<h3 class="card-title mb-0"><i class="fas fa-star me-2"></i>Le tue recensioni</h3>';
        echo '</div>';
        echo '<div class="card-body">';

        if ($result->num_rows == 0) {
            echo '<div class="alert alert-info">Nessuna recensione effettuata</div>';
        } else {
            echo '<form method="post" action="../script/eliminarecensioni.php">';
            echo '<div class="table-responsive">';
            echo '<table class="table table-hover">';
            echo '<thead class="table-light">';
            echo '<tr>
                    <th width="50px">Seleziona</th>
                    <th>Ristorante</th>
                    <th>Indirizzo</th>
                    <th>Voto</th>
                    <th>Data</th>
                  </tr>';
            echo '</thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td><input class="form-check-input" type="checkbox" name="recensioni[]" value="' . $row["idrecensione"] . '" onchange="toggleDeleteButton()"></td>
                        <td>' . $row["NomeRistorante"] . '</td>
                        <td>' . $row["indirizzo"] . '</td>
                        <td>';

                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $row["voto"]) {
                        echo '<i class="fas fa-star text-warning"></i>';
                    } else {
                        echo '<i class="far fa-star text-warning"></i>';
                    }
                }
                echo '</td>
                        <td>' . date('d/m/Y', strtotime($row["data"])) . '</td>
                      </tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '<div class="text-end mt-3">';
            echo '<button type="submit" id="eliminaBtn" class="btn btn-danger" disabled>';
            echo '<i class="fas fa-trash-alt me-2"></i>Elimina selezionate';
            echo '</button>';
            echo '</div>';
            echo '</form>';

            if (isset($_SESSION["recensioniEliminate"])) {
                echo '<div class="alert alert-success mt-3">Recensioni eliminate: ' . $_SESSION["recensioniEliminate"] . '</div>';
                unset($_SESSION["recensioniEliminate"]);
            }
        }
        echo '</div>';
        echo '</div>';

        // Form per nuova recensione
        echo '<div class="card shadow-sm mb-5">';
        echo '<div class="card-header bg-primary text-white">';
        echo '<h3 class="card-title mb-0"><i class="fas fa-plus-circle me-2"></i>Aggiungi nuova recensione</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<form action="../script/inseriscirecensione.php" method="post" class="needs-validation" novalidate>';
        echo '<div class="mb-3">';
        echo '<label for="ristorante" class="form-label">Ristorante</label>';
        echo '<select class="form-select" name="ristorante" id="ristorante" required>';
        $sql = "SELECT nome FROM ristorante";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row["nome"] . '">' . $row["nome"] . '</option>';
            }
        }
        echo '</select>';
        echo '</div>';
        
        echo '<div class="mb-3">';
        echo '<label class="form-label">Voto</label><br>';
        echo '<div class="btn-group" role="group">';
        for ($i = 1; $i <= 5; $i++) {
            echo '<input type="radio" class="btn-check" name="voto" id="voto'.$i.'" value="'.$i.'" autocomplete="off" required>';
            echo '<label class="btn btn-outline-warning" for="voto'.$i.'">';
            for ($j = 1; $j <= $i; $j++) {
                echo '<i class="fas fa-star"></i>';
            }
            echo '</label>';
        }
        echo '</div>';
        echo '</div>';
        
        echo '<div class="text-end">';
        echo '<button type="submit" class="btn btn-success">';
        echo '<i class="fas fa-paper-plane me-2"></i>Inserisci Recensione';
        echo '</button>';
        echo '</div>';
        
        if (isset($_SESSION["esitoRecensione"])) {
            if ($_SESSION["esitoRecensione"] == true) {
                echo '<div class="alert alert-success mt-3">Recensione inserita con successo!</div>';
            } else {
                echo '<div class="alert alert-danger mt-3">Impossibile aggiungere la recensione</div>';
            }
            unset($_SESSION["esitoRecensione"]);
        }
        echo '</form>';
        echo '</div>';
        echo '</div>';

        // Cambio password
        echo '<div class="card shadow-sm mb-5">';
        echo '<div class="card-header bg-primary text-white">';
        echo '<h3 class="card-title mb-0"><i class="fas fa-key me-2"></i>Cambia password</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<form action="../script/cambiopassword.php" method="post">';
        echo '<div class="mb-3">';
        echo '<label for="nuova_password" class="form-label">Nuova Password</label>';
        echo '<input type="password" class="form-control" name="nuovapassword" id="nuova_password" required>';
        echo '</div>';
        echo '<div class="text-end">';
        echo '<button type="submit" class="btn btn-primary">';
        echo '<i class="fas fa-save me-2"></i>Cambia Password';
        echo '</button>';
        echo '</div>';
        echo '</form>';
        
        if (isset($_SESSION["passwordCambioEsito"])) {
            if ($_SESSION["passwordCambioEsito"] == "success") {
                echo '<div class="alert alert-success mt-3">Password modificata con successo!</div>';
            } elseif ($_SESSION["passwordCambioEsito"] == "error") {
                echo '<div class="alert alert-danger mt-3">Impossibile modificare la password: la nuova password è uguale alla precedente.</div>';
            }
            unset($_SESSION["passwordCambioEsito"]);
        }
        echo '</div>';
        echo '</div>';

        // Info ristorante
        echo '<div class="card shadow-sm mb-5">';
        echo '<div class="card-header bg-primary text-white">';
        echo '<h3 class="card-title mb-0"><i class="fas fa-info-circle me-2"></i>Informazioni ristorante</h3>';
        echo '</div>';
        echo '<div class="card-body">';
        echo '<form action="../GUI/inforistorante.php" method="post">';
        echo '<div class="mb-3">';
        echo '<label for="ristorante_info" class="form-label">Seleziona ristorante</label>';
        echo '<select class="form-select" name="ristorante" id="ristorante_info">';
        $sql = "SELECT nome FROM ristorante";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="'.$row["nome"].'">'.$row["nome"].'</option>';
            }
        }   
        echo '</select>';
        echo '</div>';
        echo '<div class="text-end">';
        echo '<button type="submit" class="btn btn-info text-white">';
        echo '<i class="fas fa-search me-2"></i>Vedi informazioni';
        echo '</button>';
        echo '</div>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
    ?>
    
    <div class="text-center">
        <a href="../script/scriptlogout.php" class="btn btn-danger btn-lg px-4 gap-3">
            <i class="fas fa-sign-out-alt me-2"></i>Logout
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../script/benvenuto.js"></script>
</body>
</html>