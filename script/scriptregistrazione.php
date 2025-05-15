<?php
    session_start();
    include("../script/connessione.php");
?>

<?php
    $username = $_POST['username'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordHASH = hash("sha256",$password);

    $sql = "SELECT * FROM utente WHERE username = '$username'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION["errMessage"] = "Username già esistente";
        header('Location: ../script/paginaregistrazione.php');
    } else {
        $sql = "SELECT * FROM utente WHERE email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $_SESSION["errMessage"] = "Email già esistente";
            header('Location: ../script/paginaregistrazione.php');
        } else {
            $sql = "INSERT INTO utente (username, nome, cognome, email, password)
            VALUES ('$username', '$name', '$surname', '$email', '$passwordHASH')";
            if ($conn->query($sql) === TRUE) {
                $_SESSION["loggedUser"] = $username;
                $_SESSION["logged"] = true;
                header('Location: ../GUI/benvenuto.php');
            } else {
                $_SESSION["errMessage"] = "Errore durante la registrazione";
                header('Location: ../script/paginaregistrazione.php');
            }
        }
    }

?>

