<?php
    session_start();
    echo "<p style = color:red;>Errore, ".$_SESSION["errMessage"]."</p>";
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
    <a href="paginalogin.html">Torna Indietro</a>
</body>
</html>
