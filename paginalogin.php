<?php
session_start();
?>

<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HomePage</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="form-container">
    <p class="title">Welcome back</p>
    <form action="scriptlogin.php" method="post" class="form">
      <input type="text" class="input" placeholder="Username" name="username" required>
      <input type="password" class="input" placeholder="Password" name="password" required>
      <button class="form-btn" type="submit">Log in</button>
    </form>

    <?php
    if (isset($_SESSION["errMessage"])) {
      echo "<p style='color:red;'>" . $_SESSION["errMessage"] . "</p>";
      unset($_SESSION["errMessage"]);
    }
    ?>

    <p class="sign-up-label">
      Don't have an account?<span class="sign-up-link"><a href="paginaregistrazione.php">Sign up</a></span>
    </p>
    <div class="buttons-container">
    </div>
  </div>

</body>

</html>

