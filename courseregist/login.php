<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="refresh" content="3"> -->
    <!-- refresh every 3 second -->
    <!-- comment it while testing -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOG_IN</title>
</head>

<body>
    <?php
    include_once "header.php";
    ?>
    <h1>Log in</h1> <br>
    <form action="include/login.inc.php" method="post">

        <label> e-mail </label>
        <br>
        <input type="email" name="logemail" required>
        <br>
        <label> password </label>
        <br>
        <input type="password" name="logpass" required>
        <br>
        <input type="submit" name ='submit' value="Log in">

    </form>
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] === "emaildoesntexist") {
            echo "<p> Enter correct E-mail </p>";
        }
        if ($_GET["error"] === "wrongpass") {
            echo "<p> Enter correct Password </p>";
        }
        
    }
    ?>
    <a href="forgetpass.php"> forget pass?</a> <br>
    <?php
    include_once "footer.php";
    ?>
</body>

</html>