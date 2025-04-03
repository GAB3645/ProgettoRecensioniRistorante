<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>

    <form action="scriptregistrazione.php" method="post" class="form">
        <p class="title">Register </p>
        <label>
            <input required="" placeholder="" type="text" class="input" name="username">
            <span>Username</span>
        </label>

        <div class="flex">
            <label>
                <input required="" placeholder="" type="text" class="input" name="name">
                <span>Firstname</span>
            </label>

            <label>
                <input required="" placeholder="" type="text" class="input" name="surname">
                <span>Lastname</span>
            </label>
        </div>

        <label>
            <input required="" placeholder="" type="email" class="input" name="email">
            <span>Email</span>
        </label>

        <label>
            <input required="" placeholder="" type="password" class="input" name="password">
            <span>Password</span>
        </label>
        <button class="submit">Submit</button>
    <?php
    if (isset($_SESSION["errMessage"])) {
        echo "<p style='color:red;'>" . $_SESSION["errMessage"] . "</p>";
        unset($_SESSION["errMessage"]);
    }
    ?>
        <p class="signin">Already have an account? <a href="paginalogin.php">Signin</a></p>
    </form>



</body>

</html>

