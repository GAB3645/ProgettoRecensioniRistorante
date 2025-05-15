<?php
    session_start();
    if (isset($_SESSION["loggedUser"])) {
        if (isset($_POST["logout"])) {
            session_unset();
            session_destroy();
            header('Location: ../GUI/paginalogin.php');
            exit;
        } else {
            echo "<script>
            if(confirm('Sei sicuro di voler effettuare il logout?')) {
                document.location.href = '../GUI/paginalogin.php';
            } else {
                document.location.href = '../GUI/benvenuto.php';
            }
            </script>";
            exit;
        }
    } else {
        header('Location: ../GUI/paginalogin.php');
        exit;
    }
?>

