<?php
include_once "functions.php";
include_once "dbc.php";
updatepassword($conn, $_POST["id"], $_POST["pass"], $_POST["passrepeat"]);
header("location: ../login.php");
exit();
