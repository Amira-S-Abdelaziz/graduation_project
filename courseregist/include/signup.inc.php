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
    $department=$_POST["depart"];
    $op=$_POST['submit'];
    if (!idmatch($id, $idrepeat)) 
    {
        // hayrga3 tany 3la el sign up
        header("location: ../signup.php?error=iddontmatch&op=$op");
        exit();
    } 
    if (idexist($conn,$id,"user")) {
        // hayrga3 tany 3la el sign up
        header("location: ../signup.php?error=idexists&op=$op");
        exit();
    }
    if (!idexist($conn,$id,"student"))
    {
        header("location: ../signup.php?error=studentnotexist&op=$op");
        exit();
    }
    if (!passmatch($pass, $passrepeat)) {
        header("location: ../signup.php?error=passdontmatch&op=$op");
        exit();
    }
    if (emailexist($conn,$email)) {
        header("location: ../signup.php?error=emailexists&op=$op");
        exit();
    }
    createuser($conn,$name,$id,$phone,$email ,$pass,$address,$level,$department);
} else {
    header("location: ../signup.php");
}
