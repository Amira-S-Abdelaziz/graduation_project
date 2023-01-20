<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="refresh" content="3"> -->
    <!-- refresh every 3 second -->
    <!-- comment it while testing -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Verification</title>
</head>

<body>
    <?php
    include_once "header.php";
    ?>
    <h1>Verify your email</h1>
    Enter Your ID<br>
    <form action="include/idverification.inc.php" method="post">
        <input type = "text" name="id">
        <br>
        <br>
        <?php
        echo "<input type='email' name='email' hidden value=" . $_GET["email"] . ">";
        ?>
        <input type="submit" name="forget" value ="verify">
        <!-- check if ID correct or not -->
    </form>
    <?php
    if (isset($_GET["error"]))
    echo "ID isn't correct";
    ?>
    <?php
    include_once "footer.php";
    ?>
</body>

</html>