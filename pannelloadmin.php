<?php
session_start();
include("connessione.php");

if (!isset($_SESSION["admin"]) || $_SESSION["admin"] !== true) {
    header('Location: paginalogin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pannello Admin</title>
    <link rel="stylesheet" href="stylePannelloadmin.css">
</head>
<body>

    <h1>Pannello di Amministrazione</h1>

    <a href="scriptlogout.php">
        <button type="button">Log-Out</button>
    </a>

    <hr>

    <?php
    $sql = "SELECT ri.codiceristorante, ri.nome AS NomeRistorante, ri.indirizzo, ri.citta, COUNT(re.idrecensione) AS numero_recensioni 
            FROM ristorante ri
            LEFT JOIN recensione re ON ri.codiceristorante = re.codiceristorante
            GROUP BY ri.codiceristorante";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<div class='table-responsive'>";
        echo "<table class='table'>";
        echo "<tr><th>Codice Ristorante</th><th>Nome Ristorante</th><th>Indirizzo</th><th>Città</th><th>Numero Recensioni</th><th>Azioni</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["codiceristorante"] . "</td>";
            echo "<td>" . $row["NomeRistorante"] . "</td>";
            echo "<td>" . $row["indirizzo"]. "</td>";
            echo "<td>" . $row["citta"]. "</td>";
            echo "<td>" . $row["numero_recensioni"]. "</td>";
            echo "<td>
                    <form method='POST' action='eliminaristorante.php'>
                    <input type='hidden' name='codiceristorante' value='" . $row["codiceristorante"] . "'>
                    <button type='submit'>Elimina</button>
                    </form>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p>Nessun ristorante presente</p>";
    }
    ?>

    <hr>

    <?php
    if (isset($_SESSION["esito_inserimento"])) {
        if ($_SESSION["esito_inserimento"] === "successo") {
            echo "<p style='color: green;'>Ristorante inserito con successo</p>";
        } else {
            echo "<p style='color: red;'>Impossibile aggiungere il ristorante</p>";
        }
        unset($_SESSION["esito_inserimento"]);
    }

    if (isset($_SESSION["esito_eliminazione"])) {
        if ($_SESSION["esito_eliminazione"] === "successo") {
            echo "<p style='color: green;'>Ristorante eliminato con successo</p>";
        } else {
            echo "<p style='color: red;'>Errore durante l'eliminazione del ristorante</p>";
        }
        unset($_SESSION["esito_eliminazione"]);
    }
    ?>

    <h2>Inserisci un nuovo ristorante</h2>
    <form class="form" action="inserisciristorante.php" method="POST">

    <label for="codiceristorante">Codice Ristorante:</label>
    <input type="text" id="codiceristorante" name="codiceristorante" required>

    <label for="nome">Nome Ristorante:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="indirizzo">Indirizzo:</label>
    <input type="text" id="indirizzo" name="indirizzo" required>

    <label for="citta">Città:</label>
    <input type="text" id="citta" name="citta" required>

    <button type="submit">Aggiungi Ristorante</button>
</form>


</body>
</html>
