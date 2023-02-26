<?php
if (isset($_POST["submit"]))
{
    $logemail=trim($_POST["logemail"]);
    $logpass=$_POST["logpass"];

    require_once "dbc.php";
    require_once "functions.php";
    
     loginuser($conn,$logemail,$logpass);
}
else 
{
    header("location: ../signup?op=Sign In");
    exit();
}


