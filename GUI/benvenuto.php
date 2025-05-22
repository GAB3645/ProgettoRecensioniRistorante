<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="../css/styleBenvenuto.css">
    <link rel="icon" type="image/png" href="../img/logo.jpg">
</head>
<body>
<?php
session_start();
if ($_SESSION["logged"] != false) {
    echo "<h1>Benvenuto " . htmlspecialchars($_SESSION["loggedUser"]) . "</h1>";
    include("../script/connessione.php");

    $stmt = $conn->prepare("SELECT * FROM utente WHERE username = ?");
    $stmt->bind_param("s", $_SESSION["loggedUser"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<p> Nome: " . htmlspecialchars($row["nome"]) . "</p>";
        echo "<p> Cognome: " . htmlspecialchars($row["cognome"]) . "</p>";
        echo "<p> Email: " . htmlspecialchars($row["email"]) . "</p>";
        if ($row["admin"] == 1) {
            $_SESSION["admin"] = true;
            header('Location: ../GUI/pannelloadmin.php');
            exit;
        }
    }

    $stmt = $conn->prepare("SELECT r.idrecensione, ri.nome AS NomeRistorante, ri.indirizzo, r.voto, r.data 
                            FROM ristorante ri
                            JOIN recensione r ON r.codiceristorante = ri.codiceristorante
                            JOIN utente u ON r.idutente = u.id_utente 
                            WHERE u.username = ?");
    $stmt->bind_param("s", $_SESSION["loggedUser"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "<p>Nessuna recensione effettuata</p>";
    } else {
        echo '<form method="post" action="../script/eliminarecensioni.php">';
        echo "<table border='1'><tr>
                <th>Seleziona</th>
                <th>Nome Ristorante</th>
                <th>Indirizzo</th>
                <th>Voto</th>
                <th>Data</th>
              </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td><input type='checkbox' name='recensioni[]' value='" . $row["idrecensione"] . "' onchange='toggleDeleteButton()'></td>
                    <td>" . htmlspecialchars($row["NomeRistorante"]) . "</td>
                    <td>" . htmlspecialchars($row["indirizzo"]) . "</td>
                    <td>" . htmlspecialchars($row["voto"]) . "</td>
                    <td>" . date('d/m/Y', strtotime($row["data"])) . "</td>
                  </tr>";
        }
        echo "</table><br>";
        echo "<button type='submit' id='eliminaBtn' disabled>ELIMINA</button>";
        echo "</form>";

        if (isset($_SESSION["recensioniEliminate"])) {
            echo "<p>Recensioni eliminate: " . htmlspecialchars($_SESSION["recensioniEliminate"]) . "</p>";
            unset($_SESSION["recensioniEliminate"]);
        }
    }

    echo '<br><form action="../script/inseriscirecensione.php" method="post">';
    echo '<select name="ristorante">';
    $sql = "SELECT nome FROM ristorante";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . htmlspecialchars($row["nome"]) . '">' . htmlspecialchars($row["nome"]) . '</option>';
        }
    }
    echo '</select><br>';
    echo 'Voto: ';
    for ($i = 1; $i <= 5; $i++) {
        echo '<input type="radio" name="voto" value="' . $i . '">' . $i . ' ';
    }
    echo '<br><br><input type="submit" value="Inserisci Recensione">';

    if (isset($_SESSION["esitoRecensione"])) {
        if ($_SESSION["esitoRecensione"] == true) {
            echo "<p class='success'>Recensione inserita con successo</p>";
        } else {
            echo "<p class='error'>Impossibile aggiungere la recensione</p>";
        }
        unset($_SESSION["esitoRecensione"]);
    }
    echo '</form>';

    echo '<br><form action="../script/cambiopassword.php" method="post">
            <label for="nuova_password">Nuova Password:</label>
            <input type="password" name="nuovapassword" required>
            <button type="submit">Cambia Password</button>
          </form>';

    if (isset($_SESSION["passwordCambioEsito"])) {
        if ($_SESSION["passwordCambioEsito"] == "success") {
            echo "<p>Password modificata con successo!</p>";
        } elseif ($_SESSION["passwordCambioEsito"] == "error") {
            echo "<p>Impossibile modificare la password: la nuova password è uguale alla precedente.</p>";
        }
        unset($_SESSION["passwordCambioEsito"]);
    }

    echo '<br><form action="../GUI/inforistorante.php" method="post">';
    echo '<select name="ristorante">';
    $sql = "SELECT nome FROM ristorante";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="'.$row["nome"].'">'.$row["nome"].'</option>';
        }
    }   
    echo '</select><br>';
    echo '<input type="submit" value="Vedi informazioni">';
    echo '</form>';
}
?>
<br><a href="../script/scriptlogout.php"><button type="button" class="btn btn-danger">Log-Out</button></a>
</body>
<script src="../script/benvenuto.js"></script>
</html>
