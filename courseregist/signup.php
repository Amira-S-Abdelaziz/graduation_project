<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="refresh" content="3"> -->
    <!-- refresh every 3 second -->
    <!-- comment it while testing -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up</title>
</head>

<body>
    <?php
    include_once "header.php";
    ?>
    <h1>Sign up</h1> <br>
    <!-- byro7 3la el data base -->
    <form action="include/signup.inc.php" method="post">
        <label> name as in national id </label>
        <br>
        <input type="text" required name="name">
        <br>
        <label> national id </label>
        <br>
        <input type="text" name="id">
        <br>
        <label> national id "again"</label>
        <br>
        <input type="text" placeholder="must be identical" required name="idrepeat">
        <br>
        <label> phone number </label>
        <br>
        <input type=" text" required name="phone">
        <br>
        <label> e-mail </label>
        <br>
        <input type="email" required name="email">
        <br>
        <label> password </label>
        <br>
        <input type="password" placeholder=" use special chars and nums" required name="pass">
        <br>
        <label> password "again"</label>
        <br>
        <input type="password" placeholder=" use special chars and nums" required name="passrepeat">
        <br>
        <label> address </label>
        <br>
        <input type="text" required name="address">
        <br>
        <label> level </label>
        <br>
        <select required name="level">
            <option value='1'>level 1 </option>
            <option value='2'>level 2 </option>
            <option value='3'>level 3 </option>
            <option value='4'>level 4 </option>
        </select>
        <br>
        <button type="submit" name="submit">Sign up</button>
        <input type="reset">
    </form>
    <!-- 
        sign up error messages
     -->
    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "iddontmatch") {
            echo "Enter correct id";
        }
        if ($_GET["error"] == "idexists") {
            echo "<p> National id already exists </p>";
        }
        if ($_GET["error"] == "passdontmatch") {
            echo "<p> Enter correct password </p>";
        }
        if ($_GET["error"] == "emailexists") {
            echo "<p> E-mail already exists </p>";
        }
        if ($_GET["error"] == "none") {
            header("location: login.php");
            exit();
        }
    }
    ?>
    <!-- check -->
    <?php
    // if (!$_POST)
    //     echo "empty";
    // else {
    //     echo "<pre>";
    //     print_r($_POST);
    //     echo "</pre>";
    // }
    ?>
    <?php
    include_once "footer.php";
    ?>
</body>

</html>