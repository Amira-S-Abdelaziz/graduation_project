<?php
session_start();
if (isset($_SESSION["userNid"])) {
    header("location: dashboard.php");
    exit();
} else {
    header("location: signup.php");
    exit();
}
