<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="refresh" content="3"> -->
    <!-- refresh every 3 second -->
    <!-- comment it while testing -->

    <meta charset="UTF-8">
    <title>HOME</title>
</head>

<body>
    <?php
    include_once "header.php";
    ?>
    <div>
        <h1>This is a website for course regestration</h1>
        <!-- 
             كلام يتكتب + تنسيقات وكدا
         -->
    </div>
    <form action="include/regist.inc.php" method="post">
        <input type="submit" name="regist" value="Regist Your Courses">
    </form>
    <?php
    // require_once "include/regist.inc.php";
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "nologin")
            echo "<p>You have to log in first!";
    }
    ?>
    <?php
    include_once "footer.php";
    ?>
</body>

</html>