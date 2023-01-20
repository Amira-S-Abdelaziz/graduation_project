<?php
include_once "dbc.php";
include_once "functions.php";
if (idverification($conn, $_POST["id"],$_POST["email"])) {
    $id=$_POST["id"];
    header("location: ../newpassword.php?id=$id");
    exit();
} else {
    $email=$_POST["email"];
    header("location: ../idverification.php?error=Idnotcorrect&email=$email");
    exit();
}
