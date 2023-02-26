<?php
session_start();
require_once "functions.php";
require_once "dbc.php";
if (isset($_GET["submit"])) {
    $sqlcountcourses = "select count(courseCode) from studentresults.`" . $_SESSION["userNid"] . "` where studentresults.`" . $_SESSION["userNid"] . "`.term <> '" . $_SESSION["term"] . "'";
    $countcourses = mysqli_fetch_row(resfunction($conn2, $sqlcountcourses));
    if ($_SESSION["canberegistedHours"]["total"] < 15 &&  ($_SESSION["GPA"] >= 1 || $countcourses[0] == 0) && $_SESSION["term"][-1] != 3) {
        // $_SESSION['Courses'][$_GET[1]] = $ans;
        header("location: ../dashboard.php?errorh=عدد الساعات المعتمدة المسجلة اقل من 15 ساعة");
        exit();
    } else if ($_SESSION["canberegistedHours"]["total"] < 10 &&  ($_SESSION["GPA"] < 1  && $countcourses[0] != 0) && $_SESSION["term"][-1] != 3) {
        // $_SESSION['Courses'][$_GET[1]] = $ans;
        header("location: ../dashboard.php?errorh=عدد الساعات المعتمدة المسجلة اقل من 10 ساعات");
        exit();
    } else {
        $sqltrue = "UPDATE students
        SET regist = 1
        WHERE studentNid ='" . $_SESSION["userNid"] . "'";
        $resulttrue = resfunction($conn, $sqltrue);

        header("location: ../dashboard.php?errorh=تم تسجيل المقررات بنجاح");
        exit();
    }
}
