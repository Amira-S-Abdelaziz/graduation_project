<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="refresh" content="3"> -->
    <!-- refresh every 3 second -->
    <!-- comment it while testing -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New password</title>
</head>

<body>
    <?php
    include_once "header.php";
    ?>
    <h1>New Password</h1>
    <form action="include/newpassword.inc.php" method="post">
        <label>enter new password</label>
        <br>
        <input type="password" name="pass">
        <br>
        <label>enter password again</label>
        <br>
        <input type="password" name="passrepeat">
        <br>
        <?php
        echo "<input type='text' name='id' hidden value=" . $_GET["id"] . ">";
        ?>
        <input type="submit" name="submit">
    </form>
    <?php
    if (isset($_GET["error"]))
        echo "enter correct password";
    ?>
    <?php
    include_once "footer.php";
    ?>
</body>

</html>