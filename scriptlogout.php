<?php
    session_start();
    if (isset($_SESSION["loggedUser"])) {
        if (isset($_POST["logout"])) {
            session_unset();
            session_destroy();
            header('Location: paginalogin.php');
            exit;
        } else {
            echo "<script>
            if(confirm('Sei sicuro di voler effettuare il logout?')) {
                document.location.href = 'paginalogin.php';
            } else {
                document.location.href = 'benvenuto.php';
            }
            </script>";
            exit;
        }
    } else {
        header('Location: paginalogin.php');
        exit;
    }
?>

