<?php
    session_start();
    include("connessione.php");
?>

<?php
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordHASH = hash("sha256", $password);
    

    $sql = "SELECT * FROM utente WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $passwordDB = $row["password"];
        if ($passwordDB != $passwordHASH) {
            $_SESSION["errMessage"] = "Password Errata";
           header('Location: errore_loginreg.php');
        } else {
            $_SESSION["loggedUser"] = $username;
            $_SESSION["logged"] = true;
            header('Location: benvenuto.php');
        }
    } else {
        $_SESSION["errMessage"] = "Utente Inesistente";
        header('Location: errore_loginreg.php');
    }
?>


