<?php
    session_start();
    if($_SESSION["logged"] != false) {
        echo "<h1>Benvenuto " . $_SESSION["loggedUser"] . "</h1>";
        include("connessione.php");
        $sql = "SELECT * FROM utente WHERE username = '".$_SESSION["loggedUser"]."'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<p> Nome: " . $row["nome"]. "</p>";
                echo "<p> Cognome: " . $row["cognome"]. "</p>";
                echo "<p> Email: " . $row["email"]. "</p>";
                if($row["admin"] == 1) {
                    $_SESSION["admin"] = true;
                    header('Location: pannelloadmin.php');
                    exit;
                }
            }

            $sql = "SELECT COUNT(*) AS numero_recensioni 
            FROM recensione r
            JOIN utente u
            ON r.idutente = u.id_utente 
            WHERE u.username = '".$_SESSION["loggedUser"]."'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            echo "<p>Numero recensioni effettuate: " . $row["numero_recensioni"]. "</p>";

            if($row["numero_recensioni"] == 0) {
                echo "<p>Nessuna recensione effettuata</p>";
            } else {
                $sql = "SELECT ri.nome AS NomeRistorante, ri.indirizzo, re.voto, re.data 
                FROM ristorante ri
                JOIN recensione re
                ON re.codiceristorante = ri.codiceristorante
                JOIN utente u
                ON re.idutente = u.id_utente 
                WHERE u.username = '".$_SESSION["loggedUser"]."'";
                $result = $conn->query($sql);

                echo "<div class='table-responsive'>";
                echo "<table class='table table-striped'>";
                echo "<tr><th>Nome Ristorante</th><th>Indirizzo</th><th>Voto</th><th>Data</th></tr>";
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["NomeRistorante"] . "</td><td>" . $row["indirizzo"]. "</td><td>" . $row["voto"]. "</td><td>" . date('d/m/Y', strtotime($row["data"])) . "</td></tr>";
                }
                echo "</table>";
                echo "</div>";

            }
            
            echo '<br><form action="inseriscirecensione.php" method="post">';
            echo '<select name="ristorante">';
            $sql = "SELECT nome FROM ristorante";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<option value="'.$row["nome"].'">'.$row["nome"].'</option>';
                }
            }
            echo '</select><br>';
            echo 'Voto: ';
            for ($i=1; $i<=5; $i++) {
                echo '<input type="radio" name="voto" value="'.$i.'">'.$i.' ';
            }
            echo '<br><br><input type="submit" value="Inserisci Recensione">';
            echo '</form>';
            
            if(isset($_SESSION["esitoRecensione"])) {
                if($_SESSION["esitoRecensione"] == true) {
                    echo "<p class='success'>Recensione inserita con successo</p>";
                    unset($_SESSION["esitoRecensione"]);
                } else {
                    echo "<p class='error'>Impossibile aggiungere la recensione</p>";
                    unset($_SESSION["esitoRecensione"]);
                }
            }
        }
    }
?>  

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="styleBenvenuto.css">
</head>
<body>
    <br><a href="scriptlogout.php"><button type="button" class="btn btn-danger">Log-Out</button></a>
</body>
</html>


