<?php
include_once "functions.php";
include_once "dbc.php";
session_start();
updateinfo(
    $conn,
    $_POST["name"],
    $_SESSION["userNid"],
    $_POST["phone"],
    $_POST["email"],
    $_POST["pass"],
    $_POST["address"],
    $_POST["level"],
    $_POST["depart"]
);
header("location: ../profile.php?error=none");
exit();
