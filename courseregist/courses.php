<?php
require_once "header.php";
include_once "include/functions.php";
require_once "include/dbc.php";
$sql = "SELECT * from `" . $_SESSION["userDepart"] . "` INNER JOIN courses ON `" . $_SESSION["userDepart"] . "`.`courseCode`=courses.`courseCode`;
";

$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: courses.php?error=stmtfailed");
    exit();
}

// mysqli_stmt_bind_param($stmt, "s", $_SESSION["userLevel"]);


mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$sql2 = "SELECT * from `" . $_SESSION["userNid"]."`" ;
$stmt2 = mysqli_stmt_init($conn2);
if (!mysqli_stmt_prepare($stmt2, $sql2)) {
    header("location: courses.php?error=stmtfailed");
    exit();
}

// mysqli_stmt_bind_param($stmt, "s", $_SESSION["userLevel"]);


mysqli_stmt_execute($stmt2);
$result2 = mysqli_stmt_get_result($stmt2);
$section1="";
$section2="";
while ($row = mysqli_fetch_assoc($result)) {
    if ($row['Section'] == 1) {
        $section1 .= "<tr>
<td>" . $row['courseCode'] . "</td>
<td>" . $row['courseName'] . "</td>
<td>" . $row['courseHours'] . "</td>
<td>" . $row['coursePrerequest1'];
        if ($row['coursePrerequest2'] == null)
            $section1 .= "</td></tr>";
        else
            $section1 .= "+" . $row['coursePrerequest2'] . "</td></tr>";
    } else {
        $section2 .= "<tr>
<td>" . $row['courseCode'] . "</td>
<td>" . $row['courseName'] . "</td>
<td>" . $row['courseHours'] . "</td>
<td>" . $row['coursePrerequest1'];
        if ($row['coursePrerequest2'] == null)
            $section2 .= "</td></tr>";
        else
            $section2 .= "+" . $row['coursePrerequest2'] . "</td></tr>";
    }
}
echo "section 1<br>";
echo "<table border='3'> ";
echo "<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Course Hours</th> 
    <th>Course Prereqirements</th> 
    </tr>
    ";
echo $section1;

echo "</table> ";
echo "section2<br>";
echo "<table border='3'> ";
echo "<tr>
    <th>Course Code</th>
    <th>Course Name</th>
    <th>Course Hours</th> 
    <th>Course Prereqirements</th> 
    </tr>
    ";
echo $section2;
echo "</table> ";
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
echo "</table> ";
while ($row2 = mysqli_fetch_assoc($result2)) {
echo "<pre>";
    print_r($row2);
    echo "</pre>";
}
mysqli_stmt_close($stmt);
