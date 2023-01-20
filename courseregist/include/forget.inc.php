<?php
include_once "dbc.php";
include_once "functions.php";
if (emailexist($conn, $_POST["email"])) {
    $email=$_POST["email"];
    header("location: ../idverification.php?email=$email");
    exit();
} else {
    header("location: ../forgetpass.php?error=emailnotexit");
    exit();
}
