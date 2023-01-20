<?php
$alldepart[0] = "No Department";
$alldepart[1] = "حوسبة ومعلوماتية حيوية";
$alldepart[2] = "ميكروبيولوجي";
$alldepart[3] = "حاسب";
$alldepart[4] = "جيولوجيا والغاز الطبيعي";
$alldepart[5] = "فيزياء";
$alldepart[6] = "رياضيات";
$alldepart[7] = "كيمياء حيوي";
$alldepart[8] = "كيمياء صناعي";
$alldepart[9] = "بايو تكنولوجي ";
$alldepart[10] = "رصد البيئي";
$alldepart[11] = "علوم البحار";
$alldepart[12] = "احصاء";
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
        // matgesh gambaha 
        header("location: ../signup.php?error=stmtfailed");
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
        header("location: ../signup.php?error=stmtfailed");
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

function createuser($conn, $name, $id,  $phone, $email, $pass, $address, $level, $department)
{
    $sql = "INSERT INTO users (userName,userNid,userPhone,userEmail,userPass,userAddress,userLevel,userDepart) 
    VALUES (?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssssii", $name, $id, $phone, $email, $hashpass, $address, $level, $department);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}
function updateinfo($conn, $name, $id,  $phone, $email, $pass, $address, $level, $department)
{
    if (emailexist($conn, $email)) {
        header("location: ../profile.php?error=emailexists");
        exit();
    }
    $sql = "UPDATE users SET userName = ?,
userPhone=?,
userEmail=?,
userPass=?,
userAddress=?,
userLevel=?,
userDepart=? WHERE users.userNid =" . $id . ";";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profile.php?error=stmtfailed");
        exit();
    }
    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssssii", $name, $phone, $email, $hashpass, $address, $level, $department);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION["userName"] = $_POST["name"];

    $_SESSION["userPhone"] = $_POST["phone"];
    $_SESSION["userEmail"] = $_POST["email"];
    $_SESSION["userPass"] = $_POST["pass"];
    $_SESSION["userAddress"] = $_POST["address"];
    $_SESSION["userLevel"] = $_POST["level"];
    // covertLevel($_SESSION["userLevel"]);
    $_SESSION["userDepart"] = $_POST["depart"];
    // convertDepart($_SESSION["userDepart"]);

}
// function covertLevel(&$level)
// {
//     if ($level == '1')
//         $level = "level 1";
//     if ($level == '2')
//         $level = "level 2";
//     if ($level == '3')
//         $level = "level 3";
//     if ($level == '4')
//         $level = "level 4";
// }
// function convertDepart(&$Depart)
// {
//     if ($Depart == 0)
//         $Depart = "No Department";
//     if ($Depart == 1)
//         $Depart = "حوسبة ومعلوماتية حيوية";
//     if ($Depart == 2)
//         $Depart = "ميكروبيولوجي";
//     if ($Depart == 3)
//         $Depart = "حاسب";
//     if ($Depart == 4)
//         $Depart = "جيولوجيا والغاز الطبيعي";
//     if ($Depart == 5)
//         $Depart = "فيزياء";
//     if ($Depart == 6)
//         $Depart = "رياضيات";
//     if ($Depart == 7)
//         $Depart = "كيمياء حيوي";
//     if ($Depart == 8)
//         $Depart = "كيمياء صناعي ";
//     if ($Depart == 9)
//         $Depart = "بايو تكنولوجي";
//     if ($Depart == 10)
//         $Depart = "رصد بيئي";
//     if ($Depart == 11)
//         $Depart = "علوم البحار";
//     if ($Depart == 12)
//         $Depart = "احصاء";
// }
function updatepassword($conn, $id, $pass, $passrepeat)
{
    if (!passmatch($pass, $passrepeat)) {
        header("location: ../newpassword.php?error=notmatch&id=$id");
        exit();
    } else {
        $sql = "UPDATE users SET userPass=? WHERE users.userNid =" . $id . ";";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("location: ../newpassword.php?error=stmtfailed");
            exit();
        }
        $hashpass = password_hash($pass, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "s", $hashpass);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    }
}
function idverification($conn, $id, $email)
{
    $sql = "SELECT * FROM users WHERE userEmail = ? and userNid= ? ;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../idverification.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss", $email, $id);
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
function loginuser($conn, $logemail, $logpass)
{
    $exist = emailexist($conn, $logemail);
    if ($exist === false) {
        header("location:../login.php?error=emaildoesntexist");
        exit();
    }

    $passhashed = $exist["userPass"];
    $checkpass = password_verify($logpass, $passhashed);
    if ($checkpass === false) {
        header("location: ../login.php?error=wrongpass");
        exit();
    }
    if ($checkpass === true) {
        session_start();
        // $_SESSION["userid"] = $exist["id"];
        $_SESSION["userName"] = $exist["userName"];
        $_SESSION["userNid"] = $exist["userNid"];
        $_SESSION["userPhone"] = $exist["userPhone"];
        $_SESSION["userEmail"] = $exist["userEmail"];
        $_SESSION["userPass"] = $logpass;
        $_SESSION["userAddress"] = $exist["userAddress"];
        $_SESSION["userLevel"] = $exist["userLevel"];
        // covertLevel($_SESSION["userLevel"]);
        $_SESSION["userDepart"] = $exist["userDepart"];
        // convertDepart($_SESSION["userDepart"]);
        header("location: ../index.php");
        exit();
    }
}
