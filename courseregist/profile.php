<?php
include_once "header.php";
include_once "include/functions.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="include/update.inc.php" method="post">
        <label> name </label>
        <br>
        <?php
        echo "<input type='text'  name='name' value='" . $_SESSION['userName'] . "'>";
        ?>
        <br>
        <label> phone number </label>
        <br>
        <?php
        echo "<input type='text'  name='phone' value='" . $_SESSION['userPhone'] . "'>";
        ?>
        <br>
        <label> e-mail </label>
        <br>
        <?php
        echo "<input type='email'  name='email' value='" . $_SESSION['userEmail'] . "'>";
        ?>
        <br>
        <label> password </label>
        <br>
        <?php
        echo "<input type='password'  name='pass' value='" . $_SESSION['userPass'] . "'>";
        ?>
        <br>
        <label> address </label>
        <br>
        <?php
        echo "<input type='text'  name='address' value='" . $_SESSION['userAddress'] . "'>";
        ?>
        <br>
        <label> level </label>
        <br>
        <?php
        echo "<select name='level'>";
        echo "<option value=" . $_SESSION["userLevel"] . ">level " . $_SESSION["userLevel"] . "</option>";
        for ($i = 1; $i <= 4; $i++)
            if ($i != $_SESSION["userLevel"])
                echo "<option value='$i'>level $i</option>"
        ?>
        </select>
        <br>
        <label> Department </label>
        <br>
        <select name='depart'>
            <?php
            echo "<option value=" . $_SESSION["userDepart"] . ">" . $alldepart[$_SESSION["userDepart"]] . "</option>";
            for ($i = 0; $i <= 12; $i++)
                if ($i != $_SESSION["userDepart"])
                    echo "<option value='$i'>" . $alldepart[$i] . "</option>";
            ?>
        </select>
        <br>
        <button type="submit" name="update">Update</button>
        <input type="reset">
    </form>
    <?php 
    //FIXME:  fixed ! ^^
    if (isset($_GET["error"])) {
        if ($_GET["error"] != "none")
            echo "Email already exists";
    }
    ?>
    <?php
    include_once "footer.php";
    ?>
</body>

</html>