<?php
include_once "functions.php";
include_once "dbc.php";
session_start();
updateinfo(
    $conn,
    trim($_POST["name"]),
    trim($_SESSION["userNid"]),
    trim($_POST["phone"]),
    trim($_POST["email"]),
    $_POST["pass"],
    $_POST["address"]
);
header("location: ../dashboard.php?error=none");
exit();
