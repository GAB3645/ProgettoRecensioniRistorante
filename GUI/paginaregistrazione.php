<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="../img/logo.jpg">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            background-image: url('../img/restaurant-5521372_1280.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-blend-mode: multiply;
        }
        .registration-card {
            max-width: 500px;
            width: 100%;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            background: white;
        }
        .registration-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #0d6efd;
            text-align: center;
        }
        .submit-btn {
            width: 100%;
            padding: 0.5rem;
            font-weight: 500;
        }
        .name-fields {
            display: flex;
            gap: 15px;
        }
        .name-fields .form-group {
            flex: 1;
        }
    </style>
</head>

<body class="d-flex justify-content-center">

    <div class="registration-card">
        <div class="text-center mb-4">
            <i class="fas fa-user-plus fa-3x text-primary mb-3"></i>
            <h1 class="registration-title">Registrati</h1>
        </div>
        
        <form action="../script/scriptregistrazione.php" method="post">
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" placeholder="Username" name="username" required>
                </div>
            </div>
            
            <div class="mb-3 name-fields">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                        <input type="text" class="form-control" placeholder="Nome" name="name" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                        <input type="text" class="form-control" placeholder="Cognome" name="surname" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                </div>
            </div>
            
            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Password" name="password" required>
                </div>
            </div>
            
            <button class="btn btn-primary submit-btn" type="submit">
                <i class="fas fa-paper-plane me-2"></i>Registrati
            </button>

            <?php
            if (isset($_SESSION["errMessage"])) {
                echo '<div class="alert alert-danger mt-3">' . $_SESSION["errMessage"] . '</div>';
                unset($_SESSION["errMessage"]);
            }
            ?>
            
            <div class="text-center mt-3">
                <p class="text-muted">
                    Hai già un account? <a href="../GUI/paginalogin.php" class="text-decoration-none">Accedi</a>
                </p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>