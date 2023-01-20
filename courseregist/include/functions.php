<?php
function idmatch($id, $idrepeat)
{
    if ($id === $idrepeat)
        return true;
    else
        return false;
}
function passmatch($pass, $passrepeat)
{
    if ($pass === $passrepeat)
        return true;
    else
        return false;
}
function idexist($conn, $id)
{
    $sql = "SELECT * FROM users WHERE userNid = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location : ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}
function emailexist($conn, $email)
{
    $sql = "SELECT * FROM users WHERE userEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location : ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function createuser($conn, $name, $id,  $phone, $email, $pass, $address, $level)
{
    $sql = "INSERT INTO users (userName,userNid,userPhone,userEmail,userPass,userAddress,userLevel) 
    VALUES (?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location : ../signup.php?error=stmtfailed");
        exit();
    }
    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssssi", $name, $id, $phone, $email, $hashpass, $address, $level);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}

function loginuser($conn,$logemail,$logpass)
{
    $exist= emailexist($conn, $logemail);
    if ($exist===false)
    {
        header("location:../login.php?error=emaildoesntexist");
        exit();
    }

    $passhashed= $exist["userPass"];
    $checkpass = password_verify($logpass,$passhashed);
    if ($checkpass === false)
    {
        header("location: ../login.php?error=wrongpass");
        exit();
    }
    else if ($checkpass===true)
    {
        session_start();
        $_SESSION["userid"]=$exist["id"];
        $_SESSION["username"]=$exist["userName"];
        header("location: ../index.php");
        exit();
    }
}