<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/stylePaginaregistrazione.css">
    <link rel="icon" type="image/png" href="../img/logo.jpg">
</head>

<body>

    <form action="../script/scriptregistrazione.php" method="post" class="form">
        <p class="title">Registrati</p>
        <label>
            <input required="" placeholder="Username" type="text" class="input" name="username">
        </label>

        <div class="flex">
            <label>
                <input required="" placeholder="Nome" type="text" class="input" name="name">
            </label>

            <label>
                <input required="" placeholder="Cognome" type="text" class="input" name="surname">
            </label>
        </div>

        <label>
            <input required="" placeholder="Email" type="email" class="input" name="email">
        </label>

        <label>
            <input required="" placeholder="Password" type="password" class="input" name="password">
        </label>
        <button class="submit">Invia</button>
    <?php
    if (isset($_SESSION["errMessage"])) {
        echo "<p style='color:red;'>" . $_SESSION["errMessage"] . "</p>";
        unset($_SESSION["errMessage"]);
    }
    ?>
        <p class="signin">Hai già un account? <a href="../GUI/paginalogin.php">Accedi</a></p>
    </form>



</body>

</html>

