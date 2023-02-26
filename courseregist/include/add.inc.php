<?php
require_once "functions.php";
require_once "dbc.php";
session_start();


if (isset($_GET[1])) {
    $sqlfalse  = "UPDATE students
        SET regist = 0
        WHERE studentNid ='" . $_SESSION["userNid"] . "'";
    $resultfalse = resfunction($conn, $sqlfalse);
    $sqllvl1 = "SELECT * FROM courses INNER join `0` on `0`.courseCode=courses.courseCode and courses.courseCode='" . $_GET[1] . "';";
    $resultlvl1 = resfunction($conn, $sqllvl1);
    $countlvl1 = mysqli_num_rows($resultlvl1);
    $sql = "SELECT * FROM courses INNER join `" . $_SESSION["userDepart"] . "` on `" . $_SESSION["userDepart"] . "`.courseCode=courses.courseCode and courses.courseCode='" . $_GET[1] . "';";
    $result = resfunction($conn, $sql);
    $count = mysqli_num_rows($result);
    if ($countlvl1 == 0)
        $row = mysqli_fetch_assoc($result);
    else
        $row = mysqli_fetch_assoc($resultlvl1);

    if (isset($_SESSION['Courses'][$_GET[1]])) {
        // echo "<pre>";
        // print_r($row);
        // echo "</pre>";
        foreach ($_SESSION['Courses'] as $course => $info) {
            if ($course != $_GET[1]) {
                $sqlpre = "SELECT coursePrerequest1 ,	coursePrerequest2 from `" . $_SESSION["userDepart"] . "` where courseCode = '" . $course . "'";
                $rowpre = mysqli_fetch_assoc(resfunction($conn, $sqlpre));
                if ($rowpre["coursePrerequest1"] != NULL) {
                    if (isset($_SESSION['Courses'][$rowpre["coursePrerequest1"]]) && $rowpre["coursePrerequest1"] == $_GET[1]) {
                        header("location: ../dashboard.php?errorh=يجب عليك الغاء المقرر المعتمد علي هذا المقرر اولا");
                        exit();
                    }
                }
                if ($rowpre["coursePrerequest2"] != 'NULL') {
                    if (isset($_SESSION['Courses'][$rowpre["coursePrerequest2"]]) && $rowpre["coursePrerequest1"] == $_GET[1]) {
                        header("location: ../dashboard.php?errorh=يجب عليك الغاء المقرر المعتمد علي هذا المقرر اولا");
                        exit();
                    }
                }
            }
        }

        $sqldelete =
            "DELETE FROM studentresults.`" . $_SESSION["userNid"] . "` where studentresults.`" . $_SESSION["userNid"] . "`.term = '" . $_SESSION["term"] . "' and studentresults.`" . $_SESSION["userNid"] . "`.courseCode in (select courseregist.courses.courseCode from courseregist.courses where courseregist.courses.courseCode= '" . $_GET[1] . "') AND EXISTS(SELECT studentresults.`" . $_SESSION["userNid"] . "`.courseCode FROM studentresults.`" . $_SESSION["userNid"] . "` WHERE studentresults.`" . $_SESSION["userNid"] . "`.courseCode ='" . $_GET[1] . "')";
        $resultdelete = resfunction($conn, $sqldelete);
        if (!strpos($_GET[1], "400")) {
            $_SESSION["canberegistedHours"]["total"] -= $row["courseHours"];
            if ($countlvl1 == 0 && $row["Section"] == 1 && $row["courseOptional"] == 1)
                $_SESSION["canberegistedHours"]["Branch_1"]["optional"] -= $row["courseHours"];
            if ($countlvl1 == 0 && $row["Section"] == 1 && $row["courseOptional"] == 0)
                $_SESSION["canberegistedHours"]["Branch_1"]["required"] -= $row["courseHours"];
            if ($countlvl1 == 0 && $row["Section"] == 2 && $row["courseOptional"] == 1)
                $_SESSION["canberegistedHours"]["Branch_2"]["optional"] -= $row["courseHours"];
            if ($countlvl1 == 0 && $row["Section"] == 2 && $row["courseOptional"] == 0)
                $_SESSION["canberegistedHours"]["Branch_2"]["required"] -= $row["courseHours"];
            if ($countlvl1 != 0 && $row["courseOptional"] == 1)
                $_SESSION["canberegistedHours"]["Branch_0"]["optional"] -= $row["courseHours"];
            if ($countlvl1 != 0 && $row["courseOptional"] == 0)
                $_SESSION["canberegistedHours"]["Branch_0"]["required"] -= $row["courseHours"];
        } else {
            $_SESSION["canberegistedHours"]["total"] -= ($row["courseHours"] / 2);
            $_SESSION["canberegistedHours"]["research"] -= ($row["courseHours"] / 2);
        }
        unset($_SESSION['Courses'][$_GET[1]]);
        header("location: ../dashboard.php");
        exit();
    } else {
        $sqlcountcourses = "select count(courseCode) from studentresults.`" . $_SESSION["userNid"] . "` where studentresults.`" . $_SESSION["userNid"] . "`.term <> '" . $_SESSION["term"] . "'";
        $countcourses = mysqli_fetch_row(resfunction($conn2, $sqlcountcourses));
        $sqlfalse  = "UPDATE students
        SET regist = 0
        WHERE studentNid ='" . $_SESSION["userNid"] . "'";
        $resultfalse = resfunction($conn, $sqlfalse);
        $hour = 0;
        $ans = "";
        $ans .= " <tr>
            <td> " . $row["courseCode"] . " </td>
            <td>" . $row["courseName"] . " </td>";
        if (strpos($_GET[1], "400"))
            $ans .= "<td>" . ($row["courseHours"] / 2) . "</td>
            <td>" . $row["coursePrerequest1"];
        else
            $ans .= "<td>" . ($row["courseHours"]) . "</td>
            <td>" . $row["coursePrerequest1"];
        if ($row["coursePrerequest2"] != NULL)
            $ans .= "+" . $row["coursePrerequest2"] . "</td>";
        else
            $ans .= "</td>";

        if ($row["courseOptional"] == 1)
            $ans  .= "<td>اختياري</td></tr>";
        else
            $ans .= "<td>اجباري</td></tr>";
        // if (!strpos($row1["courseCode"], "400"))
        if (strpos($_GET[1], "400"))
            $hour = $row["courseHours"] / 2;
        else
            $hour = $row["courseHours"];
        if ($_SESSION["canberegistedHours"]["total"] + $hour > 21 &&  ($_SESSION["GPA"] >= 1 || $countcourses[0] == 0) && $_SESSION["term"][-1] != 3) {
            // $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?errorh=عدد الساعات المعتمدة المسجلة اكبر من 21 ساعة");
            exit();
        } else if ($_SESSION["canberegistedHours"]["total"] + $hour > 17 &&  ($_SESSION["GPA"] < 1  && $countcourses[0] != 0) && $_SESSION["term"][-1] != 3) {
            // $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?errorh=عدد الساعات المعتمدة المسجلة اكبر من 17 ساعة");
            exit();
        } else if ($_SESSION["canberegistedHours"]["total"] + $hour > 9 && $_SESSION["term"][-1] == 3) {
            // $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?errorh=عدد الساعات المعتمدة المسجلة اكبر من 9 ساعات");
            exit();
        }
        // ////////////////////////////////////////////////////////////////////////// 
        else if ($_SESSION["registedHours"]["total"] + $_SESSION["canberegistedHours"]["total"] + $hour > $_SESSION["total"]) {
            // $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?errorh=عدد الساعات اكبر من المطلوب لنيل درجة البكالوريوس");
            exit();
        } else if ($_SESSION["registedHours"]["Branch_2"]["required"] + $_SESSION["canberegistedHours"]["Branch_2"]["required"] + $hour > $_SESSION["Branch_2"]["required"]  && $countlvl1 == 0 && $row["Section"] == 2 && $row["courseOptional"] == 0) {
            // $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?errorh=عدد الساعات اكبر من المطلوب من الساعات الاجبارية في فرع " . $_SESSION["Branch_1"]["name"] . "");
            exit();
        } else if ($_SESSION["registedHours"]["Branch_1"]["required"] + $_SESSION["canberegistedHours"]["Branch_1"]["required"] + $hour > $_SESSION["Branch_1"]["required"]  && $countlvl1 == 0 && $row["Section"] == 1 && $row["courseOptional"] == 0) {
            // $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?errorh=عدد الساعات اكبر من المطلوب من الساعات الاجبارية في فرع " . $_SESSION["Branch_1"]["name"] . "");
            exit();
        } else if ($_SESSION["registedHours"]["Branch_2"]["optional"] + $_SESSION["canberegistedHours"]["Branch_2"]["optional"] + $hour > $_SESSION["Branch_2"]["optional"]  && $countlvl1 == 0 && $row["Section"] == 2 && $row["courseOptional"] == 1) {
            // $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?errorh=عدد الساعات اكبر من المطلوب من الساعات الاختيارية في فرع " . $_SESSION["Branch_2"]["name"] . "");
            exit();
        } else if ($_SESSION["registedHours"]["Branch_1"]["optional"] + $_SESSION["canberegistedHours"]["Branch_1"]["optional"] + $hour > $_SESSION["Branch_1"]["optional"]  && $countlvl1 == 0 && $row["Section"] == 1 && $row["courseOptional"] == 1) {
            // $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?errorh=عدد الساعات اكبر من المطلوب من الساعات الاختيارية في فرع " . $_SESSION["Branch_1"]["name"] . "");
            exit();
        }
        /////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////
        else if ($_SESSION["registedHours"]["Branch_0"]["optional"] + $_SESSION["canberegistedHours"]["Branch_0"]["optional"] + $hour > $_SESSION["Branch_0"]["optional"]  && $countlvl1 > 0  && $row["courseOptional"] == 1) {
            // $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?errorh=عدد الساعات اكبر من المطلوب من الساعات الاختيارية في مقررات المستوي الاول  ");
            exit();
        } else if ($_SESSION["registedHours"]["Branch_0"]["required"] + $_SESSION["canberegistedHours"]["Branch_0"]["required"] + $hour > $_SESSION["Branch_0"]["required"]  && $countlvl1 > 0  && $row["courseOptional"] == 0) {
            // $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?errorh=عدد الساعات اكبر من المطلوب من الساعات الاجبارية في مقررات المستوي الاول  ");
            exit();
        } else {
            if (!strpos($_GET[1], "400")) {
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
            $sql = "INSERT INTO `" . $_SESSION["userNid"] . "` (courseCode,term) VALUES ('" . $_GET[1] . "'," . $_SESSION["term"] . ")";
            $result = resfunction($conn2, $sql);
            $_SESSION['Courses'][$_GET[1]] = $ans;
            header("location: ../dashboard.php?1=done");
            exit();
        }
    }
}
// echo "done";
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
// echo "<pre>";
// print_r($_GET);
// echo "</pre>";
// // header("location: ../dashboard.php");