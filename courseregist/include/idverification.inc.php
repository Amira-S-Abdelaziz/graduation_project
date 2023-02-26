<?php
include_once "dbc.php";
include_once "functions.php";
if (idverification($conn, trim($_POST["id"]),trim($_POST["email"]))) {
    $id=trim($_POST["id"]);
    header("location: ../newpassword.php?id=$id");
    exit();
} else {
    $email=trim($_POST["email"]);
    header("location: ../idverification.php?error=Idnotcorrect&email=$email");
    exit();
}
