<?php
require_once "header.php";
include_once "include/functions.php";
require_once "include/dbc.php";
// TODO:
// show courses of the department divided into 2 branches and optional and not optional
/*******************************/

$sql = "SELECT * from `" . $_SESSION["userDepart"] . "` INNER JOIN courses ON `" . $_SESSION["userDepart"] . "`.`courseCode`=courses.`courseCode`;
";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: courses.php?error=stmtfailed");
    exit();
}
if ($_SESSION["userDepart"] == 0) {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // stored in variables then print them
    $optional = "";
    $notoptional = "";
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['courseOptional'] == 1) {
            $optional .= "<tr>
<td>" . $row['courseCode'] . "</td>
<td>" . $row['courseName'] . "</td>
<td>" . $row['courseHours'] . "</td>
<td>" . $row['coursePrerequest1'];
            if ($row['coursePrerequest2'] == null)
                $optional .= "</td></tr>";
            else
                $optional .= "+" . $row['coursePrerequest2'] . "</td></tr>";
        } else if ($row['courseOptional'] == 0) {
            $notoptional .= "<tr>
<td>" . $row['courseCode'] . "</td>
<td>" . $row['courseName'] . "</td>
<td>" . $row['courseHours'] . "</td>
<td>" . $row['coursePrerequest1'];
            if ($row['coursePrerequest2'] == null)
                $notoptional .= "</td></tr>";
            else
                $notoptional .= "+" . $row['coursePrerequest2'] . "</td></tr>";
        }
    }
    $sqlfordepart = "SELECT * FROM requested_hours WHERE departNumber=" . $_SESSION["userDepart"] . "";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sqlfordepart)) {
        header("location: courses.php?error=stmtfailed");
        exit();
    }

    // mysqli_stmt_bind_param($stmt, "s", $_SESSION["userLevel"]);


    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    // echo "<pre>";
    
    echo " 
A student should study 36 credit hours :<br>
( 30 required and 6 optional ) <br>";
    // echo $row["nameBranch_1"] . "<br>";
    echo "required<br>";
    echo "<table border='3'> ";
    echo "<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Course Hours</th> 
    <th>Course Prereqirements</th> 
    </tr>
    ";
    echo $notoptional;
    echo "</table> ";
    echo "optional<br>";
    echo "<table border='3'> ";
    echo "<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Course Hours</th> 
    <th>Course Prereqirements</th> 
    </tr>
    ";
    echo $optional;
    echo "</table> ";
    // // echo $row["nameBranch_2"] . "<br>";
    // echo "required <br>";
    // echo "<table border='3'> ";
    // echo "<tr>
    // <th>Course Code</th>
    // <th>Course Name</th>
    // <th>Course Hours</th> 
    // <th>Course Prereqirements</th> 
    // </tr>
    // ";
    // echo $section2notoptional;
    // echo "</table> ";
    // echo "optional<br>";
    // echo "<table border='3'> ";
    // echo "<tr>
    // <th>Course Code</th>
    // <th>Course Name</th>
    // <th>Course Hours</th> 
    // <th>Course Prereqirements</th> 
    // </tr>
    // ";
    // echo $section2optional;
    // echo "</table> ";
} else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // stored in variables then print them
    $section1optional = "";
    $section1notoptional = "";
    $section2optional = "";
    $section2notoptional = "";
    while ($row = mysqli_fetch_assoc($result)) {
        if ($row['Section'] == 1 && $row['courseOptional'] == 1) {
            $section1optional .= "<tr>
<td>" . $row['courseCode'] . "</td>
<td>" . $row['courseName'] . "</td>
<td>" . $row['courseHours'] . "</td>
<td>" . $row['coursePrerequest1'];
            if ($row['coursePrerequest2'] == null)
                $section1optional .= "</td></tr>";
            else
                $section1optional .= "+" . $row['coursePrerequest2'] . "</td></tr>";
        } else if ($row['Section'] == 1 && $row['courseOptional'] == 0) {
            $section1notoptional .= "<tr>
<td>" . $row['courseCode'] . "</td>
<td>" . $row['courseName'] . "</td>
<td>" . $row['courseHours'] . "</td>
<td>" . $row['coursePrerequest1'];
            if ($row['coursePrerequest2'] == null)
                $section1notoptional .= "</td></tr>";
            else
                $section1notoptional .= "+" . $row['coursePrerequest2'] . "</td></tr>";
        } else if ($row['Section'] == 2 && $row['courseOptional'] == 1) {
            $section2optional .= "<tr>
<td>" . $row['courseCode'] . "</td>
<td>" . $row['courseName'] . "</td>
<td>" . $row['courseHours'] . "</td>
<td>" . $row['coursePrerequest1'];
            if ($row['coursePrerequest2'] == null)
                $section2optional .= "</td></tr>";
            else
                $section2optional .= "+" . $row['coursePrerequest2'] . "</td></tr>";
        } else if ($row['Section'] == 2 && $row['courseOptional'] == 0) {
            $section2notoptional .= "<tr>
<td>" . $row['courseCode'] . "</td>
<td>" . $row['courseName'] . "</td>
<td>" . $row['courseHours'] . "</td>
<td>" . $row['coursePrerequest1'];
            if ($row['coursePrerequest2'] == null)
                $section2notoptional .= "</td></tr>";
            else
                $section2notoptional .= "+" . $row['coursePrerequest2'] . "</td></tr>";
        }
    }
    $sqlfordepart = "SELECT * FROM requested_hours WHERE departNumber=" . $_SESSION["userDepart"] . "";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sqlfordepart)) {
        header("location: courses.php?error=stmtfailed");
        exit();
    }

    // mysqli_stmt_bind_param($stmt, "s", $_SESSION["userLevel"]);


    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    // echo "<pre>";
    echo " 
A student should study " . $row["requiredBranch_0"] + $row["optionalBranch_0"] . " credit hours for faculty requirements :<br>
( " . $row["requiredBranch_0"] . " required and " . $row["optionalBranch_0"] . " optional ) <br>";
    echo " 
A student should study " . $row["requiredBranch_1"] + $row["optionalBranch_1"] . " credit hours for " . $row["nameBranch_1"] . " :<br>
( " . $row["requiredBranch_1"] . " required and " . $row["optionalBranch_1"] . " optional ) <br>";
    echo " 
A student should study " . $row["requiredBranch_2"] + $row["optionalBranch_2"] . " credit hours for " . $row["nameBranch_2"] . " :<br>
( " . $row["requiredBranch_2"] . " required and " . $row["optionalBranch_2"] . " optional ) <br>";
    echo "
In addition to 4 credit hours for reseach <br>";
    echo $row["nameBranch_1"] . "<br>";
    echo "required<br>";
    echo "<table border='3'> ";
    echo "<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Course Hours</th> 
    <th>Course Prereqirements</th> 
    </tr>
    ";
    echo $section1notoptional;
    echo "</table> ";
    echo "optional<br>";
    echo "<table border='3'> ";
    echo "<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Course Hours</th> 
    <th>Course Prereqirements</th> 
    </tr>
    ";
    echo $section1optional;
    echo "</table> ";
    echo $row["nameBranch_2"] . "<br>";
    echo "required <br>";
    echo "<table border='3'> ";
    echo "<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Course Hours</th> 
    <th>Course Prereqirements</th> 
    </tr>
    ";
    echo $section2notoptional;
    echo "</table> ";
    echo "optional<br>";
    echo "<table border='3'> ";
    echo "<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Course Hours</th> 
    <th>Course Prereqirements</th> 
    </tr>
    ";
    echo $section2optional;
    echo "</table> ";
}
// <td>".$row['courseCode']."</td>
// <td>Course Name</td>
// <td>Course Hours</td> 
// <td>Course Prereqirements</td> 
// </th>";
// [courseCode] => C 211
//     [courseOptional] => 0
//     [coursePrerequest1] => Fac C 101
//     [coursePrerequest2] => 
//     [Section] => 2
//     [courseName] => مقدمة فى نظم التشغيل
//     [courseHours] => 3
// }
// while ($row2 = mysqli_fetch_assoc($result2)) {
// echo "<pre>";
//     print_r($row2);
//     echo "</pre>";
// }
// $sql2 = "SELECT * from `" . $_SESSION["userNid"]."`" ;
// $stmt2 = mysqli_stmt_init($conn2);
// if (!mysqli_stmt_prepare($stmt2, $sql2)) {
//     header("location: courses.php?error=stmtfailed");
//     exit();
// }
// mysqli_stmt_execute($stmt2);
// $result2 = mysqli_stmt_get_result($stmt2);

mysqli_stmt_close($stmt);
