<?php
require_once "header.php";
require_once "include/functions.php";
require_once "include/dbc.php";
if (!isset($_SESSION["userNid"])) { 
        header("location: signup.php");
        exit();
    
}

?>

<body>

    <!-- <form method="get"> -->
    <!-- <button name="submit" formaction="include/dashboard.inc.php"> -->

    <!-- الملف الشخصي -->
    <!-- </button> -->
    <!-- <select name="choose "> -->
    <!-- <option value=1> -->
    <!-- <button name="submit" formaction="include/dashboard.inc.php"> -->

    <!-- الملف الشخصي -->
    <!-- </button> -->
    <!-- </option> -->
    <!-- <option value=2> -->
    <!-- بيان الحالة -->
    <!-- </option> -->
    <!-- <option value=3> -->
    <!-- تسجيل المواد -->
    <!-- </option> -->
    <!-- <option value=4> -->
    <!-- المقررات المطلوبة -->
    <!-- </option> -->
    <!-- </select> -->
    <!-- </form> -->
    <!-- <div  > -->
    <!-- TODO: profile -->
    <div>
        <p>
            الملف الشخصي
        </p>
        <table>
            <?php

            // echo "<pre>";
            //                 print_r($countcourses);
            //                 echo "</pre>";        
            echo "<tr><td> GPA : </td>";
            echo "<td>" . $_SESSION["GPA"] . "</td><tr>";
            echo "<tr><td>الرقم القومي :</td>";
            echo "<td>" . $_SESSION["userNid"] . "</td></tr>";
            echo "<td> القسم : </td>";
            echo "<td>" . $_SESSION["userDepartname"] . "</td></tr>";
            echo "<tr><td>عدد الساعات المسجلة سابقا :</td>";
            echo "<td>" . $_SESSION["registedHours"]["total"] . "</td> </tr>";
            echo "<tr><td>العام الحالي :</td>";
            echo "<td>" . substr($_SESSION["term"], 0, 4) . "-" . substr($_SESSION["term"], 0, 4) - 1 . "</td> </tr>";
            echo "<tr><td>الترم الحالي :</td>";
            if ($_SESSION["term"][-1] == 1)
                echo "<td>الترم الاول</td> </tr>";
            if ($_SESSION["term"][-1] == 2)
                echo "<td>الترم الثاني</td> </tr>";
            if ($_SESSION["term"][-1] == 3)
                echo "<td>الترم الصيفي</td> </tr>";

            ?>
        </table>
        <form action="include/update.inc.php" method="post">
            <label> name </label>
            <br>
            <?php
            echo "<input type='text'  name='name' value='" . $_SESSION['userName'] . "'>";
            ?>
            <br>
            <label> phone number </label>
            <br>
            <?php
            echo "<input type='text'  name='phone' value='" . $_SESSION['userPhone'] . "'>";
            ?>
            <br>
            <label> e-mail </label>
            <br>
            <?php
            echo "<input type='email'  name='email' value='" . $_SESSION['userEmail'] . "'>";
            ?>
            <br>
            <label> password </label>
            <br>
            <?php
            echo "<input type='password'  name='pass' value='" . $_SESSION['userPass'] . "'>";
            ?>
            <br>
            <label> address </label>
            <br>
            <?php
            echo "<input type='text'  name='address' value='" . $_SESSION['userAddress'] . "'>";
            ?>
            <!-- <br>
            <label> level </label>
            <br> -->
            <?php
            // echo "<select name='level'>";
            // echo "<option value=" . $_SESSION["userLevel"] . ">level " . $_SESSION["userLevel"] . "</option>";
            // for ($i = 1; $i <= 4; $i++)
            //     if ($i != $_SESSION["userLevel"])
            //         echo "<option value='$i'>level $i</option>"
            ?>
            <!-- </select>
            <br>
            <label> Department </label>
            <br> -->
            <!-- <select name='depart'> -->
            <?php
            // echo "<option value=" . $_SESSION["userDepart"] . ">" . $alldepart[$_SESSION["userDepart"]] . "</option>";
            // for ($i = 0; $i <= 12; $i++)
            //     if ($i != $_SESSION["userDepart"])
            //         echo "<option value='$i'>" . $alldepart[$i] . "</option>";
            ?>
            <!-- </select> -->
            <br>
            <button type="submit" name="update">Update</button>
            <input type="reset">
        </form>
        <?php
        //FIXME:  fixed ! ^^
        if (isset($_GET["error"])) {
            if ($_GET["error"] != "none")
                echo "Email already exists";
        }
        ?>
    </div>
    <!-- TODO: show registed -->
    <p>
        المواد المسجلة مسبقا :
    </p>
    <div>

        <table border=3>
            <tr>
                <th>Course Code </th>
                <th>Course Name </th>
                <th>Course Hours</th>
                <th>Course Grades</th>
                <th>Course Pass</th>
            </tr>
            <?php
            $courses = registedcourses($conn, $_SESSION["userNid"]);
            echo $courses;
            ?>
        </table>

    </div>
    <!--------------------------------------------------------------------------------------------------------------->
    <!-- TODO: show the level and  courses -->
    <div>
        <p>
            المستوي الاول
        </p>

        <table border=3>
            <tr>
                <th> Course Code </th>
                <th>Course Name </th>
                <th>Course Hours</th>
                <th>Course prerequist</th>
                <th>Optional</th>
            </tr>
            <?php
            $arr = showlevelone($conn);
            echo $arr;
            ?>
        </table>
        <p>
            المستوي الثاني
        </p>
        <?php
        echo $_SESSION["Branch_1"]["name"];
        ?>
        <table border=3>
            <tr>
                <th> Course Code </th>
                <th>Course Name </th>
                <th>Course Hours</th>
                <th>Course prerequist</th>
                <th>Optional</th>
            </tr>
            <?php
            $arr = showleveldepartment($conn, 2, $_SESSION["userDepart"]);
            echo $arr[0];
            ?>
        </table>
        <!-- //////////////////////////////////////// -->
        <?php
        echo $_SESSION["Branch_2"]["name"];
        ?>
        <table border=3>
            <tr>
                <th> Course Code </th>
                <th>Course Name </th>
                <th>Course Hours</th>
                <th>Course prerequist</th>
                <th>Optional</th>
            </tr>
            <?php
            echo $arr[1];
            ?>
        </table>
        <p>
            المستوي الثالث
        </p>
        <?php
        echo $_SESSION["Branch_1"]["name"];
        ?>
        <table border=3>
            <tr>
                <th> Course Code </th>
                <th>Course Name </th>
                <th>Course Hours</th>
                <th>Course prerequist</th>
                <th>Optional</th>
            </tr>
            <?php
            $arr = showleveldepartment($conn, 3, $_SESSION["userDepart"]);
            echo $arr[0];
            ?>
        </table>
        <!-- //////////////////////////////////////// -->
        <?php
        echo $_SESSION["Branch_2"]["name"];
        ?>
        <table border=3>
            <tr>
                <th> Course Code </th>
                <th>Course Name </th>
                <th>Course Hours</th>
                <th>Course prerequist</th>
                <th>Optional</th>
            </tr>
            <?php
            echo $arr[1];
            ?>
        </table>
        <p>
            المستوي الرابع
        </p>
        <?php
        echo $_SESSION["Branch_1"]["name"];
        ?>
        <table border=3>
            <tr>
                <th> Course Code </th>
                <th>Course Name </th>
                <th>Course Hours</th>
                <th>Course prerequist</th>
                <th>Optional</th>
            </tr>
            <?php
            $arr = showleveldepartment($conn, 4, $_SESSION["userDepart"]);
            echo $arr[0];
            ?>
        </table>
        <!-- //////////////////////////////////////// -->
        <?php
        echo $_SESSION["Branch_2"]["name"];
        ?>
        <table border=3>
            <tr>
                <th> Course Code </th>
                <th>Course Name </th>
                <th>Course Hours</th>
                <th>Course prerequist</th>
                <th>Optional</th>
            </tr>
            <?php
            echo $arr[1];
            ?>
        </table>
    </div>
    <!-- TODO: to regist courses ------------------------------------------------------------------ -->
    <div>
        <form method="get">
            <?php

            $sqlfordepartr = "SELECT * FROM requested_hours WHERE departNumber=" . $_SESSION["userDepart"] . "";
            $resultfordepartr = resfunction($conn, $sqlfordepartr);
            $rowfordepartr = mysqli_fetch_assoc($resultfordepartr);
            // echo "<pre>";
            // print_r($rowfordepartr);
            // echo "</pre>";

            ?>
            <p>
                المستوي الاول
            </p>
            <table border=3>
                <tr>
                    <th> Course Code </th>
                    <th>Course Name </th>
                    <th>Course Hours</th>
                    <th>Course prerequist</th>
                    <th>Optional</th>
                    <th>add</th>
                </tr>
                <?php
                // FIXME: fixed ^^ 
                //   بيطلع مجموع الساعات غلط 
                // prints 33
                // echo " hours<br>";
                $c = coursescanberegistedlvl1($conn, $_SESSION["userNid"], $_SESSION["Branch_0"]["optional"], $_SESSION["Branch_0"]["required"]);
                echo $c;
                ?>
            </table>
            <p>
                المستوي الثاني
            </p>
            <?php
            if ($_SESSION["userDepart"] != 0)
                echo $_SESSION["Branch_1"]["name"];
            ?>
            <table border=3>
                <tr>
                    <th> Course Code </th>
                    <th>Course Name </th>
                    <th>Course Hours</th>
                    <th>Course prerequist</th>
                    <th>Optional</th>
                    <th>add</th>

                </tr>
                <?php
                if ($_SESSION["userDepart"] != 0) {

                    $sec1 = coursescanberegisted($conn, $_SESSION["userNid"], $_SESSION["Branch_1"]["optional"], $_SESSION["Branch_1"]["required"], $_SESSION["userDepart"], 2, 1);
                    echo $sec1;
                } ?>
            </table>
            <!-- //////////////////////////////////////// -->
            <?php
            if ($_SESSION["userDepart"] != 0)

                echo $_SESSION["Branch_2"]["name"];
            ?>
            <table border=3>
                <tr>
                    <th> Course Code </th>
                    <th>Course Name </th>
                    <th>Course Hours</th>
                    <th>Course prerequist</th>
                    <th>Optional</th>
                    <th>add</th>

                </tr>
                <?php
                if ($_SESSION["userDepart"] != 0) {
                    $sec2 = coursescanberegisted($conn, $_SESSION["userNid"], $_SESSION["Branch_2"]["optional"], $_SESSION["Branch_2"]["required"], $_SESSION["userDepart"], 2, 2);
                    echo $sec2;
                }
                ?>
            </table>
            <p>
                المستوي الثالث
            </p>
            <?php
            if ($_SESSION["userDepart"] != 0)
                echo $_SESSION["Branch_1"]["name"];
            ?>
            <table border=3>
                <tr>
                    <th> Course Code </th>
                    <th>Course Name </th>
                    <th>Course Hours</th>
                    <th>Course prerequist</th>
                    <th>Optional</th>
                    <th>add</th>

                </tr>
                <?php
                if ($_SESSION["userDepart"] != 0) {
                    $sec1 = coursescanberegisted($conn, $_SESSION["userNid"], $_SESSION["Branch_1"]["optional"], $_SESSION["Branch_1"]["required"], $_SESSION["userDepart"], 3, 1);
                    echo $sec1;
                }
                ?>

            </table>
            <!-- //////////////////////////////////////// -->
            <?php
            if ($_SESSION["userDepart"] != 0)

                echo $_SESSION["Branch_2"]["name"];
            ?>
            <table border=3>
                <tr>
                    <th> Course Code </th>
                    <th>Course Name </th>
                    <th>Course Hours</th>
                    <th>Course prerequist</th>
                    <th>Optional</th>
                    <th>add</th>

                </tr>
                <?php
                if ($_SESSION["userDepart"] != 0) {
                    $sec2 = coursescanberegisted($conn, $_SESSION["userNid"], $_SESSION["Branch_2"]["optional"], $_SESSION["Branch_2"]["required"], $_SESSION["userDepart"], 3, 2);
                    echo $sec2;
                }
                ?>
            </table>
            <p>
                المستوي الرابع
            </p>
            <?php
            if ($_SESSION["userDepart"] != 0)
                echo $_SESSION["Branch_1"]["name"];
            ?>
            <table border=3>
                <tr>
                    <th> Course Code </th>
                    <th>Course Name </th>
                    <th>Course Hours</th>
                    <th>Course prerequist</th>
                    <th>Optional</th>
                    <th>add</th>

                </tr>
                <?php
                if ($_SESSION["userDepart"] != 0) {
                    $sec1 = coursescanberegisted($conn, $_SESSION["userNid"], $_SESSION["Branch_1"]["optional"], $_SESSION["Branch_1"]["required"], $_SESSION["userDepart"], 4, 1);
                    echo $sec1;
                }
                ?>

            </table>
            <!-- //////////////////////////////////////// -->
            <?php
            if ($_SESSION["userDepart"] != 0)
                echo $_SESSION["Branch_2"]["name"];
            ?>
            <table border=3>
                <tr>
                    <th> Course Code </th>
                    <th>Course Name </th>
                    <th>Course Hours</th>
                    <th>Course prerequist</th>
                    <th>Optional</th>
                    <th>add</th>

                </tr>
                <?php
                if ($_SESSION["userDepart"] != 0) {
                    $sec2 = coursescanberegisted($conn, $_SESSION["userNid"], $_SESSION["Branch_2"]["optional"], $_SESSION["Branch_2"]["required"], $_SESSION["userDepart"], 4, 2);
                    echo $sec2;
                }
                ?>
            </table>
            <table>
                <?php
                echo "<tr><td> عدد الساعات الذي تم تسجيلها هذا الترم : </td>";
                echo "<td>" . $_SESSION["canberegistedHours"]["total"] . "</td></tr>";
                ?>
            </table>
            <p>
                المقررات التي قمت بتسجيلها هذا الترم
            </p>
            <table border=3>
                <tr>
                    <th> Course Code </th>
                    <th>Course Name </th>
                    <th>Course Hours</th>
                    <th>Course prerequist</th>
                    <th>Optional</th>
                    <!-- <th>add</th> -->

                </tr>
                <?php
                // if (isset($_GET[1])) {
                //     if (isset($_SESSION['Courses'][$_GET[1]]))
                //         unset($_SESSION['Courses'][$_GET[1]]);
                //     else
                //         $_SESSION['Courses'][$_GET[1]] = 1;
                // }
                // header("location: ../dashboard.php");
                if (isset($_SESSION['Courses'])) {
                    foreach ($_SESSION['Courses'] as $course => $info) {
                        echo  $info;
                    }
                }
                // echo $_SESSION["term"];
                // echo "<br>";
                // echo $_SESSION["GPA"];
                // echo "<br>";

                // echo "<br>";
                // echo $_SESSION["registedHours"]["total"];
                // echo "<br>";

                // echo $_SESSION["registedHours"]["total"] + $_SESSION["canberegistedHours"]["total"];
                // echo "<br>";

                // echo $_SESSION["term"][-1];
                // echo "<pre>";
                // print_r($_SESSION);
                // echo "</pre>";
                // echo "<br>";
                ?>

                <button type='submit' formaction='include/insertcourses.inc.php' name="submit" value='submit'>Submit</button>
        </form>
    </div>
    <div>
        <?php
        if (isset($_GET["errorh"])) {
            echo $_GET["errorh"];
        }
        ?>
    </div>
</body>
<?php
include_once "footer.php";
?>

<!-- TODO: qurieris -->
<!-- SELECT * FROM courseregist.courses INNER JOIN courseregist.`1` ON courseregist.courses.courseCode =courseregist.`1`.`courseCode` and (`1`.courseCode LIKE "% 2__" OR `1`.courseCode LIKE "% 2___" ) and `1`.courseCode NOT IN (SELECT studentresults.`30102230300226`.courseCode FROM studentresults.`30102230300226` where studentresults.`30102230300226`.coursePass = 1); -->
<!-- SELECT * FROM courseregist.courses INNER JOIN courseregist.`0` ON courseregist.courses.courseCode =courseregist.`0`.`courseCode` and `0`.courseCode NOT IN (SELECT studentresults.`30102230300226`.courseCode FROM studentresults.`30102230300226` where studentresults.`30102230300226`.coursePass = 1); -->
<!-- TODO: show avalibale courses according to passed prerequist -->

<!-- SELECT * FROM courseregist.courses INNER JOIN courseregist.`7` ON courseregist.courses.courseCode =courseregist.`7`.`courseCode` and (`7`.courseCode LIKE "% 2__" OR `7`.courseCode LIKE "% 2___" ) and `7`.courseCode NOT IN (SELECT studentresults.`30102230300225`.courseCode FROM studentresults.`30102230300225` where studentresults.`30102230300225`.coursePass = 1) and (`7`.`coursePrerequest1` IS NULL OR `7`.`coursePrerequest1` in (SELECT studentresults.`30102230300225`.courseCode FROM studentresults.`30102230300225` where studentresults.`30102230300225`.coursePass = 1)) and (`7`.`coursePrerequest2` IS NULL OR `7`.`coursePrerequest2` in (SELECT studentresults.`30102230300225`.courseCode FROM studentresults.`30102230300225` where studentresults.`30102230300225`.coursePass = 1)); -->