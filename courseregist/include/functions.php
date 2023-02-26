<?php
// FIXME:  fixed ! ^^
$alldepart[0] = "لا يوجد";
$alldepart[1] = "الرياضيات وتكنولوجيا المعلومات وعلوم الحاسب";
$alldepart[2] = "الرياضيات وعلوم الإحصاء";
$alldepart[3] = " الرياضيات";
$alldepart[4] = "الفيزياء و الفيزياء التطبيقية";
$alldepart[5] = "الكيمياء و الكيمياء الصناعية والتطبيقية";
$alldepart[6] = "الكيمياء و الكيمياء الحيوية";
$alldepart[7] = "  التكنولوجيا الحيوية";
$alldepart[8] = " الميكروبيولوجى";
$alldepart[9] = "الرصد البيئى وإدارة البيئة";
$alldepart[10] = "جيولوجيا البترول والغاز الطبيعى";
$alldepart[11] = "علوم البحار";
$alldepart[12] = "حوسبة";
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
function idexist($conn, $id, $table)
{
    $sql = "SELECT * FROM " . $table . "s WHERE " . $table . "Nid = ?;";
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

function createuser($conn, $name, $id,  $phone, $email, $pass, $address)
{
    $sql = "INSERT INTO users (userName,userNid,userPhone,userEmail,userPass,userAddress) 
    VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $id, $phone, $email, $hashpass, $address);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $sqlcreatetable = "CREATE TABLE if not exists studentresults.`" . $id . "` (
        `index` int(11) NOT NULL AUTO_INCREMENT,
        `courseCode` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
        `courseGrades` double NOT NULL DEFAULT 0,
        `term` int(11) NOT NULL,
        `coursePass` tinyint(1) NOT NULL DEFAULT 0,
        PRIMARY KEY (`index`),
        KEY `courseCode` (`courseCode`),
        CONSTRAINT `" . $id . "_ibfk_1` FOREIGN KEY (`courseCode`) REFERENCES `courseregist`.`courses` (`courseCode`)
       ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    $resultcreatetable = resfunction($conn, $sqlcreatetable);
    header("location: ../signup.php?error=none&op=Sign In");
    exit();
}
function updateinfo($conn, $name, $id,  $phone, $email, $pass, $address)
{
    //FIXME: fixed ! ^^
    if ($email != $_SESSION["userEmail"]) {
        if (emailexist($conn, $email)) {
            header("location: ../dashboard.php?error=emailexists");
            exit();
        }
    }
    $sql = "UPDATE users SET userName = ?,
    userPhone=?,
    userEmail=?,
    userPass=?,
    userAddress=?
    WHERE users.userNid ='" . $id . "';";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../dashboard.php?error=stmtfailed");
        exit();
    }
    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $phone, $email, $hashpass, $address);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION["userName"] = $_POST["name"];

    $_SESSION["userPhone"] = $_POST["phone"];
    $_SESSION["userEmail"] = $_POST["email"];
    $_SESSION["userPass"] = $_POST["pass"];
    $_SESSION["userAddress"] = $_POST["address"];
    // $_SESSION["userLevel"] = $_POST["level"];
    // covertLevel($_SESSION["userLevel"]);
    // $_SESSION["userDepart"] = $_POST["depart"];
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
        header("location:../signup.php?error=emaildoesntexist&op=Sign In");
        exit();
    }
    $passhashed = $exist["userPass"];
    $checkpass = password_verify($logpass, $passhashed);
    if ($checkpass === false) {
        header("location: ../signup.php?error=wrongpass&op=Sign In");
        exit();
    }
    if ($checkpass === true)
        session_start();
    // $_SESSION["userid"] = $exist["id"];
    $_SESSION["userName"] = $exist["userName"];
    $_SESSION["userNid"] = $exist["userNid"];
    $_SESSION["userPhone"] = $exist["userPhone"];
    $_SESSION["userEmail"] = $exist["userEmail"];
    $_SESSION["userPass"] = $logpass;
    $_SESSION["userAddress"] = $exist["userAddress"];
    $sqld = "SELECT * from students where studentNid=" . $_SESSION["userNid"];
    $result = mysqli_execute_query($conn, $sqld);
    $rowd = mysqli_fetch_assoc($result);
    // $_SESSION["userLevel"] = $exist["userLevel"];
    // covertLevel($_SESSION["userLevel"]);
    $sqladmin = "SELECT term FROM admin;";
    $resultadmin = resfunction($conn, $sqladmin);
    $rowadmin =  mysqli_fetch_assoc($resultadmin);
    $_SESSION["term"] = $rowadmin["term"];
    $_SESSION["userDepart"] = $rowd["studentDepart"];
    $_SESSION["userNid"] = $rowd["studentNid"];
    // TODO: $_SESSION["registedHours"] 
    //  هيبقا فيها الساعات اللي اتسجلت قبل كدا وهتبقا عبارة 
    // عن اراي فيها تفاصيل عن المواد الاختياري والاجباري وتابع انهي فرع
    //   التوتال دا فيه مجموع كل الل قبله 
    // جايز نحتاجه بعدين 
    $_SESSION["registedHours"]["Branch_0"]["required"] = 0;
    $_SESSION["registedHours"]["Branch_0"]["optional"] = 0;
    $_SESSION["registedHours"]["Branch_1"]["required"] = 0;
    $_SESSION["registedHours"]["Branch_1"]["optional"] = 0;
    $_SESSION["registedHours"]["Branch_2"]["required"] = 0;
    $_SESSION["registedHours"]["Branch_2"]["optional"] = 0;
    $_SESSION["registedHours"]["research"] = 0;
    $_SESSION["registedHours"]["total"] = 0;

    // TODO:  $_SESSION["canberegistedHours"]
    // دي هتعد الكورسات اللي هااا تتسجل لسه 
    // المفروض يكون فيها نفس تفاصيل الل فوق 
    $_SESSION["canberegistedHours"]["Branch_0"]["required"] = 0;
    $_SESSION["canberegistedHours"]["Branch_0"]["optional"] = 0;
    $_SESSION["canberegistedHours"]["Branch_1"]["required"] = 0;
    $_SESSION["canberegistedHours"]["Branch_1"]["optional"] = 0;
    $_SESSION["canberegistedHours"]["Branch_2"]["required"] = 0;
    $_SESSION["canberegistedHours"]["Branch_2"]["optional"] = 0;
    $_SESSION["canberegistedHours"]["research"] = 0;
    $_SESSION["canberegistedHours"]["total"] = 0;


    $sqlfordepart = "SELECT * FROM requested_hours WHERE departNumber=" . $_SESSION["userDepart"] . "";
    $resultfordepart = resfunction($conn, $sqlfordepart);
    $rowfordepart = mysqli_fetch_assoc($resultfordepart);
    // TODO: 
    // TODO: 
    // TODO: 
    // TODO: 
    //  الحاجات الل مطلوبة ف القسم
    $_SESSION["userDepartname"] = $rowfordepart["departName"];
    $_SESSION["Branch_0"]["required"] = $rowfordepart["requiredBranch_0"];
    $_SESSION["Branch_0"]["optional"] = $rowfordepart["optionalBranch_0"];
    $_SESSION["Branch_1"]["required"] = $rowfordepart["requiredBranch_1"];
    $_SESSION["Branch_1"]["optional"] = $rowfordepart["optionalBranch_1"];
    $_SESSION["Branch_1"]["name"] = $rowfordepart["nameBranch_1"];
    $_SESSION["Branch_2"]["required"] = $rowfordepart["requiredBranch_2"];
    $_SESSION["Branch_2"]["optional"] = $rowfordepart["optionalBranch_2"];
    $_SESSION["Branch_2"]["name"] = $rowfordepart["nameBranch_2"];
    $_SESSION["research"] = $rowfordepart["research"];
    $_SESSION["total"] = 142;
    $sqlcourses = "SELECT studentresults.`" . $_SESSION["userNid"] . "`.courseCode FROM studentresults.`" . $_SESSION["userNid"] . "` where studentresults.`" . $_SESSION["userNid"] . "`.term = '" . $_SESSION["term"] . "';";
    $resultcourses = resfunction($conn, $sqlcourses);

    while ($rowcourses =  mysqli_fetch_assoc($resultcourses)) {
        $sqllvl1 = "SELECT * FROM courses INNER join `0` on `0`.courseCode=courses.courseCode and courses.courseCode='" . $rowcourses["courseCode"] . "';";
        $resultlvl1 = resfunction($conn, $sqllvl1);
        $countlvl1 = mysqli_num_rows($resultlvl1);
        $sql = "SELECT * FROM courses INNER join `" . $_SESSION["userDepart"] . "` on `" . $_SESSION["userDepart"] . "`.courseCode=courses.courseCode and courses.courseCode='" . $rowcourses["courseCode"] . "';";
        $result = resfunction($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($countlvl1 == 0)
            $row = mysqli_fetch_assoc($result);
        else
            $row = mysqli_fetch_assoc($resultlvl1);

        $hour = 0;
        $ans = "";
        $ans .= " <tr>
            <td> " . $row["courseCode"] . " </td>
            <td>" . $row["courseName"] . " </td>";
        if (strpos($row["courseCode"], "400"))
            $ans .=
                "<td>" . ($row["courseHours"] / 2) . "</td>
            <td>" . $row["coursePrerequest1"];
        else
            $ans .=
                "<td>" . $row["courseHours"] . "</td>
            <td>" . $row["coursePrerequest1"];
        if ($row["coursePrerequest2"] != NULL)
            $ans .= "+" . $row["coursePrerequest2"] . "</td>";
        else
            $ans .= "</td>";

        if ($row["courseOptional"] == 1)
            $ans  .= "<td>اختياري</td></tr>";
        else
            $ans .= "<td>اجباري</td></tr>";
        if (strpos($row["courseCode"], "400"))
            $hour = $row["courseHours"] / 2;
        else
            $hour = $row["courseHours"];
        if (!strpos($rowcourses["courseCode"], "400")) {
            $_SESSION["canberegistedHours"]["total"] += $hour;
            if ($countlvl1 == 0 && $row["Section"] == 1 && $row["courseOptional"] == 1)
                $_SESSION["canberegistedHours"]["Branch_1"]["optional"] += $row["courseHours"];
            if ($countlvl1 == 0 && $row["Section"] == 1 && $row["courseOptional"] == 0)
                $_SESSION["canberegistedHours"]["Branch_1"]["required"] += $row["courseHours"];
            if ($countlvl1 == 0 && $row["Section"] == 2 && $row["courseOptional"] == 1)
                $_SESSION["canberegistedHours"]["Branch_2"]["optional"] += $row["courseHours"];
            if ($countlvl1 == 0 && $row["Section"] == 2 && $row["courseOptional"] == 0)
                $_SESSION["canberegistedHours"]["Branch_2"]["required"] += $row["courseHours"];
            if ($countlvl1 != 0 && $row["courseOptional"] == 1)
                $_SESSION["canberegistedHours"]["Branch_0"]["optional"] += $row["courseHours"];
            if ($countlvl1 != 0 && $row["courseOptional"] == 0)
                $_SESSION["canberegistedHours"]["Branch_0"]["required"] += $row["courseHours"];
        } else {
            $_SESSION["canberegistedHours"]["total"] += ($row["courseHours"] / 2);
            $_SESSION["canberegistedHours"]["research"] += ($row["courseHours"] / 2);
        }
        $_SESSION['Courses'][$rowcourses["courseCode"]] = $ans;
    }
    $_SESSION["GPA"] = 0.00;
    gpaandregistedhourse($conn, $_SESSION["userNid"]);

    // convertDepart($_SESSION["userDepart"]);
    // $courses = registedcourses($conn, $_SESSION["userNid"]);
    header("location: ../dashboard.php");
    exit();
}
function resfunction($con, $sql)
{
    $stmt = mysqli_stmt_init($con);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: courses.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}
function showlevelone($con)
{
    $sql = "SELECT * FROM `0` INNER JOIN courses ON `0`.courseCode = courses.courseCode";
    $result = resfunction($con, $sql);
    $sec = "";
    // $registedcoursesc22 = "";
    while ($row = mysqli_fetch_assoc($result)) {
        // if ($rowc2['Section'] == 1) {
        $sec .= " <tr>
            <td> " . $row["courseCode"] . " </td>
            <td>" . $row["courseName"] . " </td>
            <td>" . $row["courseHours"] . "</td>
            <td>" . $row["coursePrerequest1"];
        if ($row["coursePrerequest2"] != NULL)
            $sec .= "+" . $row["coursePrerequest2"] . "</td>";
        else
            $sec .= "</td>";

        if ($row["courseOptional"] == 1)
            $sec .= "<td>اختياري</td></tr>";
        else
            $sec .= "<td>اجباري</td></tr>";
    }
    return $sec;
}
function showleveldepartment($con, $level, $userDepart)
{
    $sql = "SELECT * FROM `"
        . $userDepart .
        "` INNER JOIN courses ON `"
        . $userDepart .
        "`.courseCode = courses.courseCode AND (`"
        . $userDepart .
        "`.courseCode LIKE '% " . $level . "__' OR `" . $userDepart . "`.courseCode LIKE '% " . $level . "___');";
    $result = resfunction($con, $sql);
    $sec1 = "";
    $sec2 = "";
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['Section'] == 1) {
            $sec1 .= " <tr>
        <td> " . $row["courseCode"] . " </td>
        <td>" . $row["courseName"] . " </td>
        <td>" . $row["courseHours"] . "</td>
        <td>" . $row["coursePrerequest1"];
            if ($row["coursePrerequest2"] != NULL)
                $sec1 .= "+" . $row["coursePrerequest2"] . "</td>";
            else
                $sec1 .= "</td>";

            if ($row["courseOptional"] == 1)
                $sec1 .= "<td>اختياري</td></tr>";
            else
                $sec1 .= "<td>اجباري</td></tr>";
            // echo "<pre>";
            // print_r($rowc1);
            // echo "</pre>";
        } else {
            $sec2 .= " <tr>
        <td> " . $row["courseCode"] . " </td>
        <td>" . $row["courseName"] . " </td>
        <td>" . $row["courseHours"] . "</td>
        <td>" . $row["coursePrerequest1"];
            if ($row["coursePrerequest2"] != NULL)
                $sec2 .= "+" . $row["coursePrerequest2"] . "</td>";
            else
                $sec2 .= "</td>";

            if ($row["courseOptional"] == 1)
                $sec2 .= "<td>اختياري</td></tr>";
            else
                $sec2 .= "<td>اجباري</td></tr>";
        }
    }
    return array(0 => $sec1, 1 => $sec2);
}

function gpaandregistedhourse($con, $userNid)
{
    $addnotpass = array();
    $hours = 0;
    $hoursadd = 0;
    $ans = 0;
    $gba = 0;
    $sqlcourses = "SELECT * FROM studentresults.`" . $userNid . "` where studentresults.`" . $userNid . "`.term not in (select courseregist.admin.term from courseregist.admin);";
    $resultcourses = resfunction($con, $sqlcourses);
    while ($rowcourses =  mysqli_fetch_assoc($resultcourses)) {
        $sqllvl1 = "SELECT * FROM courses INNER join `0` on `0`.courseCode=courses.courseCode and courses.courseCode='" . $rowcourses["courseCode"] . "';";
        $resultlvl1 = resfunction($con, $sqllvl1);
        $countlvl1 = mysqli_num_rows($resultlvl1);
        $sql = "SELECT * FROM courses INNER join `" . $_SESSION["userDepart"] . "` on `" . $_SESSION["userDepart"] . "`.courseCode=courses.courseCode and courses.courseCode='" . $rowcourses["courseCode"] . "';";
        $result = resfunction($con, $sql);
        $count = mysqli_num_rows($result);
        if ($countlvl1 == 0)
            $row = mysqli_fetch_assoc($result);
        else
            $row = mysqli_fetch_assoc($resultlvl1);

        $hour = 0;

        if ($rowcourses["coursePass"] == 1) {
            if (strpos($row["courseCode"], "400"))
                $hour = $row["courseHours"] / 2;
            else
                $hour = $row["courseHours"];
        }
        if ($rowcourses["courseGrades"] >= 60 && $rowcourses["coursePass"] && !strpos($row["courseCode"], "400")) {
            $ans += ($rowcourses["courseGrades"] - 50) * 0.1 * $row["courseHours"];
            $hours += $row["courseHours"];
            // $addnotpass[$row["courseCode"]]["pass"] = $rowcourses["coursePass"];
            // $addnotpass[$row["courseCode"]]["hours"] = $row["courseHours"];
        } else if ($rowcourses["coursePass"]) {
            // $addnotpass[$row["courseCode"]]["pass"] = $rowcourses["coursePass"];
            // $addnotpass[$row["courseCode"]]["hours"] = $row["courseHours"];
            if (strpos($row["courseCode"], "400"))
                $hoursadd += ($row["courseHours"] / 2);
            else
                $hoursadd += $row["courseHours"];
        }
        // TODO: اتعدلت بسبب امنية !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        else if (!$rowcourses["coursePass"]) {
            if (isset($addnotpass[$row["courseCode"]]["pass"])) {
                if ($addnotpass[$row["courseCode"]]["pass"] != 1) {
                    $addnotpass[$row["courseCode"]]["pass"] = 0;
                    $addnotpass[$row["courseCode"]]["hours"] = $row["courseHours"];
                    $addnotpass[$row["courseCode"]]["hours"] = $row["courseHours"];
                }
            } else {
                $addnotpass[$row["courseCode"]]["pass"] = $rowcourses["coursePass"];
                $addnotpass[$row["courseCode"]]["hours"] = $row["courseHours"];
            } // $hours += $row["courseHours"];
        }
        if (!strpos($row["courseCode"], "400")) {
            $_SESSION["registedHours"]["total"] += $hour;
            if ($countlvl1 == 0 && $row["Section"] == 1 && $row["courseOptional"] == 1)
                $_SESSION["registedHours"]["Branch_1"]["optional"] += $hour;
            if ($countlvl1 == 0 && $row["Section"] == 1 && $row["courseOptional"] == 0)
                $_SESSION["registedHours"]["Branch_1"]["required"] += $hour;
            if ($countlvl1 == 0 && $row["Section"] == 2 && $row["courseOptional"] == 1)
                $_SESSION["registedHours"]["Branch_2"]["optional"] += $hour;
            if ($countlvl1 == 0 && $row["Section"] == 2 && $row["courseOptional"] == 0)
                $_SESSION["registedHours"]["Branch_2"]["required"] += $hour;
            if ($countlvl1 != 0 && $row["courseOptional"] == 1)
                $_SESSION["registedHours"]["Branch_0"]["optional"] += $hour;
            if ($countlvl1 != 0 && $row["courseOptional"] == 0)
                $_SESSION["registedHours"]["Branch_0"]["required"] += $hour;
        } else {
            $_SESSION["registedHours"]["total"] += ($hour / 2);
            $_SESSION["registedHours"]["research"] += ($hour / 2);
        }
    }
    foreach ($addnotpass as $course => $info) {
        if ($addnotpass[$course]["pass"] == 0) {
            $hours += $addnotpass[$course]["hours"];
        }
    }
    if ($ans != 0 && $hours != 0)
        $_SESSION["GPA"] = round($ans / $hours,2);
    else
        $_SESSION["GPA"] = 0.00;
}

function registedcourses($con, $userNid)
{
    $courses = "";
    $sqlcourses = "SELECT * FROM studentresults.`" . $userNid . "` where studentresults.`" . $userNid . "`.term not in (select courseregist.admin.term from courseregist.admin);";
    $resultcourses = resfunction($con, $sqlcourses);
    while ($rowcourses =  mysqli_fetch_assoc($resultcourses)) {
        $sqllvl1 = "SELECT * FROM courses INNER join `0` on `0`.courseCode=courses.courseCode and courses.courseCode='" . $rowcourses["courseCode"] . "';";
        $resultlvl1 = resfunction($con, $sqllvl1);
        $countlvl1 = mysqli_num_rows($resultlvl1);
        $sql = "SELECT * FROM courses INNER join `" . $_SESSION["userDepart"] . "` on `" . $_SESSION["userDepart"] . "`.courseCode=courses.courseCode and courses.courseCode='" . $rowcourses["courseCode"] . "';";
        $result = resfunction($con, $sql);
        $count = mysqli_num_rows($result);
        if ($countlvl1 == 0)
            $row = mysqli_fetch_assoc($result);
        else
            $row = mysqli_fetch_assoc($resultlvl1);

        $courses .= " <tr>
        <td> " . $row["courseCode"] . " </td>
        <td>" . $row["courseName"] . " </td>";
        if (strpos($row["courseCode"], "400"))
            $courses .= "<td>" . $row["courseHours"] / 2 . "</td>
        <td>" . $rowcourses["courseGrades"] . "</td>";
        else
            $courses .= "<td>" . $row["courseHours"] . "</td>
        <td>" . $rowcourses["courseGrades"] . "</td>";
        if ($rowcourses["coursePass"] == 1) {

            $courses .= "<td>yes</td></tr>";
        } else
            $courses .= "<td>no</td></tr>";
    }
    return $courses;
}

// TODO: 
// $op => 0 or 1
// 0 if not optional courses
// 1 if optional courses
// $section => -1 or 1 or 2
// -1 if no departement
// 1 if section 1 of a department
// 2 if no departement
function userhours($con, $userNid, $depart, $op, $section = -1)
{
    if ($section == -1) {
        $sql = "SELECT SUM(courseregist.courses.courseHours) 
    FROM courseregist.courses 
    INNER JOIN studentresults.`" . $userNid . "` 
    on 
    studentresults.`" . $userNid . "`.courseCode = courseregist.courses.courseCode and studentresults.`" . $userNid . "`.courseCode not like '% 400'
    and studentresults.`" . $userNid . "`.coursePass=1 
    and studentresults.`" . $userNid . "`.courseCode in 
    (SELECT courseregist.`" . $depart . "`.courseCode from courseregist.`" . $depart . "` where courseregist.`" . $depart . "`.courseOptional=" . $op . "); ";
        $result = resfunction($con, $sql);
        $ans = mysqli_fetch_row($result);
        return $ans[0];
    } else {
        $sql = "SELECT SUM(courseregist.courses.courseHours) 
    FROM courseregist.courses 
    INNER JOIN studentresults.`" . $userNid . "` 
    ON 
    studentresults.`" . $userNid . "`.courseCode = courseregist.courses.courseCode 
    and studentresults.`" . $userNid . "`.courseCode not like '% 400'
    and studentresults.`" . $userNid . "`.coursePass=1 
    and studentresults.`" . $userNid . "`.courseCode in 
    (SELECT courseregist.`" . $depart . "`.courseCode from courseregist.`" . $depart . "` where courseregist.`" . $depart . "`.courseOptional=" . $op . " and
    courseregist.`" . $depart . "`.Section=" . $section . "  ); ";
        $result = resfunction($con, $sql);
        $ans = mysqli_fetch_row($result);
        return $ans[0];
    }
}
function coursescanberegistedlvl1($con, $userNid, $hoursop, $hoursonotp)
{

    $ophours = userhours($con, $userNid, 0, 1);
    $notophours = userhours($con, $userNid, 0, 0);
    $showop = 0;
    $shownotop = 0;
    if ($ophours < $hoursop)
        $showop = 1;
    if ($notophours < $hoursonotp)
        $shownotop = 1;

    $sql = "SELECT * FROM courseregist.courses 
        INNER JOIN courseregist.`0` 
        ON 
        courseregist.courses.courseCode =courseregist.`0`.`courseCode`
        and `0`.courseCode NOT IN 
        (SELECT studentresults.`" . $userNid . "`.courseCode FROM studentresults.`" . $userNid . "` where studentresults.`" . $userNid . "`.coursePass = 1) ";
    $result = resfunction($con, $sql);

    $courses = "";
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["courseOptional"] == 1  && $showop == 1) {

            // if ($rowc2['Section'] == 1) {
            $courses .= " <tr>
            <td> " . $row["courseCode"] . " </td>
            <td>" . $row["courseName"] . " </td>
            <td>" . $row["courseHours"] . "</td>
            <td>" . $row["coursePrerequest1"];
            // $_SESSION["allCourses"][$row["courseCode"]]
            if ($row["coursePrerequest2"] != NULL)
                $courses .= "+" . $row["coursePrerequest2"] . "</td>";
            else
                $courses .= "</td>";

            if ($row["courseOptional"] == 1)
                $courses .= "<td>اختياري</td>";
            else
                $courses .= "<td>اجباري</td>";
            if (isset($_SESSION['Courses'][$row["courseCode"]])) {
                $courses .= "<td><button type='submit' formaction='include/add.inc.php' name=1 value='" . $row["courseCode"] . "'>cancel</button></td></tr>";
                // $courses .= "<input  type='text' name='" . $row["courseCode"] . "' value='" . $row["courseHours"] . "'></td></tr>";
            } else {
                $courses .= "<td><button type='submit' formaction='include/add.inc.php' name=1 value='" . $row["courseCode"] . "'>add</button></td></tr>";
                // $courses .= "<input  type='text' name='" . $row["courseCode"] . "' value='" . $row["courseHours"] . "'></td></tr>";
            }
        } else if ($row["courseOptional"] == 0  && $shownotop == 1) {
            $courses .= " <tr>
            <td> " . $row["courseCode"] . " </td>
            <td>" . $row["courseName"] . " </td>
            <td><label>" . $row["courseHours"] . "</label></td>
            <td>" . $row["coursePrerequest1"];
            if ($row["coursePrerequest2"] != NULL)
                $courses .= "+" . $row["coursePrerequest2"] . "</td>";
            else
                $courses .= "</td>";

            if ($row["courseOptional"] == 1)
                $courses .= "<td>اختياري</td>";
            else
                $courses .= "<td>اجباري</td>";
            if (isset($_SESSION['Courses'][$row["courseCode"]])) {
                $courses .= "<td><button type='submit' formaction='include/add.inc.php' name=1 value='" . $row["courseCode"] . "'>cancel</button></td></tr>";
                // $courses .= "<input  type='text' name='" . $row["courseCode"] . "' value='" . $row["courseHours"] . "'></td></tr>";
            } else {
                $courses .= "<td><button type='submit' formaction='include/add.inc.php' name=1 value='" . $row["courseCode"] . "'>add</button></td></tr>";
                // $courses .= "<input  type='text' name='" . $row["courseCode"] . "' value='" . $row["courseHours"] . "'></td></tr>";
            }
        }
    }
    return $courses;
}
function coursescanberegisted($con, $userNid, $hoursop, $hoursonotp, $depart, $level, $section)
{
    $ophours = userhours($con, $userNid, $depart, 1, $section);
    $notophours = userhours($con, $userNid, $depart, 0, $section);
    $showop = 0;
    $shownotop = 0;
    if ($ophours < $hoursop)
        $showop = 1;
    if ($notophours < $hoursonotp)
        $shownotop = 1;
    // echo $ophours ." ".$notophours;
    $sql = "SELECT * FROM courseregist.courses 
    INNER JOIN courseregist.`" . $depart . "` ON 
    courseregist.courses.courseCode =courseregist.`" . $depart . "`.`courseCode` 
    AND (`" . $depart . "`.courseCode LIKE '% " . $level . "__' OR `" . $depart . "`.courseCode LIKE '% " . $level . "___' ) 
    AND `" . $depart . "`.courseCode NOT IN (SELECT studentresults.`" . $userNid . "`.courseCode FROM studentresults.`" . $userNid . "` where studentresults.`" . $userNid . "`.coursePass = 1 and studentresults.`" . $userNid . "`.courseCode Not like '% 400') 
    AND (`" . $depart . "`.`coursePrerequest1` IS NULL OR `" . $depart . "`.`coursePrerequest1` in (SELECT studentresults.`" . $userNid . "`.courseCode FROM studentresults.`" . $userNid . "` where (studentresults.`" . $userNid . "`.coursePass = 1 OR studentresults.`" . $userNid . "`.term ='" . $_SESSION["term"] . "'))) 
    AND (`" . $depart . "`.`coursePrerequest2` IS NULL OR `" . $depart . "`.`coursePrerequest2` in (SELECT studentresults.`" . $userNid . "`.courseCode FROM studentresults.`" . $userNid . "` where (studentresults.`" . $userNid . "`.coursePass = 1 OR studentresults.`" . $userNid . "`.term ='" . $_SESSION["term"] . "')))
    and courseregist.`" . $depart . "`.Section =" . $section . ";";

    $result = resfunction($con, $sql);
    $courses = "";
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row["courseOptional"] == 1  && $showop == 1) {

            // if ($rowc2['Section'] == 1) {
            $courses .= " <tr>
            <td> " . $row["courseCode"] . " </td>
            <td>" . $row["courseName"] . " </td>
            <td>" . $row["courseHours"] . "</td>
            <td>" . $row["coursePrerequest1"];
            if ($row["coursePrerequest2"] != NULL)
                $courses .= "+" . $row["coursePrerequest2"] . "</td>";
            else
                $courses .= "</td>";

            if ($row["courseOptional"] == 1)
                $courses .= "<td>اختياري</td>";
            else
                $courses .= "<td>اجباري</td>";
            if (isset($_SESSION['Courses'][$row["courseCode"]])) {
                $courses .= "<td><button type='submit' formaction='include/add.inc.php' name=1 value='" . $row["courseCode"] . "'>cancel</button></td></tr>";
                // $courses .= "<input  type='text' name='" . $row["courseCode"] . "' value='" . $row["courseHours"] . "'></td></tr>";
            } else {
                $courses .= "<td><button type='submit' formaction='include/add.inc.php' name=1 value='" . $row["courseCode"] . "'>add</button></td></tr>";
                // $courses .= "<input  type='text' name='" . $row["courseCode"] . "' value='" . $row["courseHours"] . "'></td></tr>";
            }
        } else if ($row["courseOptional"] == 0  && $shownotop == 1) {
            if (strpos($row["courseCode"], "400") && $_SESSION["registedHours"]["research"]  == 4)
                continue;
            $courses .= " <tr>
            <td> " . $row["courseCode"] . " </td>
            <td>" . $row["courseName"] . " </td>";
            if (strpos($row["courseCode"], "400"))
                $courses .= "<td>" . $row["courseHours"] - $_SESSION["registedHours"]["research"] . "</td>
            <td>" . $row["coursePrerequest1"];
            else
                $courses .= "<td>" . $row["courseHours"] . "</td>
            <td>" . $row["coursePrerequest1"];
            if ($row["coursePrerequest2"] != NULL)
                $courses .= "+" . $row["coursePrerequest2"] . "</td>";
            else
                $courses .= "</td>";

            if ($row["courseOptional"] == 1)
                $courses .= "<td>اختياري</td>";
            else
                $courses .= "<td>اجباري</td>";
            if (isset($_SESSION['Courses'][$row["courseCode"]])) {
                $courses .= "<td><button type='submit' formaction='include/add.inc.php' name=1 value='" . $row["courseCode"] . "'>cancel</button></td></tr>";
                // $courses .= "<input  type='text' name='" . $row["courseCode"] . "' value='" . $row["courseHours"] . "'></td></tr>";
            } else {
                $courses .= "<td><button type='submit' formaction='include/add.inc.php' name=1 value='" . $row["courseCode"] . "'>add</button></td></tr>";
                // $courses .= "<input  type='text' name='" . $row["courseCode"] . "' value='" . $row["courseHours"] . "'></td></tr>";
            }
        }
    }
    return $courses;
}
