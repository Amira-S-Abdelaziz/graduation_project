<?php
if (isset($_POST["submit"])) {
    require_once "dbc.php";
    require_once "functions.php";
    $name=$_POST["name"];
    $id = $_POST["id"];
    $idrepeat = $_POST["idrepeat"];
    $phone=$_POST["phone"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $passrepeat = $_POST["passrepeat"];
    $address=$_POST["address"];
    $level=$_POST["level"];
    if (!idmatch($id, $idrepeat)) 
    {
        // hayrga3 tany 3la el sign up
        header("location: ../signup.php?error=iddontmatch");
        exit();
    } 
    if (idexist($conn,$id)) {
        // hayrga3 tany 3la el sign up
        header("location: ../signup.php?error=idexists");
        exit();
    }
    if (!passmatch($pass, $passrepeat)) {
        header("location: ../signup.php?error=passdontmatch");
        exit();
    }
    if (emailexist($conn,$email)) {
        header("location: ../signup.php?error=emailexists");
        exit();
    }
    createuser($conn,$name,$id,$phone,$email ,$pass,$address,$level);
} else {
    header("location: ../signup.php");
}
