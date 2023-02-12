<!DOCTYPE html>
<html lang="en">

<head>
    <!-- <meta http-equiv="refresh" content="3"> -->
    <!-- refresh every 3 second -->
    <!-- comment it while testing -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign up</title>
    <link rel="stylesheet" href="signup.css">
</head>

<body>
    <?php
    include_once "header.php";
    include_once "include/functions.php";
    ?>
    <!-- <h1>Sign up</h1> <br> -->
    <!-- byro7 3la el data base -->




    <div class="login-wrap">
        <div class="login-html">
            <?php
            if (isset($_GET["op"])) {
                if ($_GET["op"] == "Sign Up") {
                    echo "<input id='tab-1' type='radio' name='tab' class='sign-up' checked ><label for='tab-1' class='tab'>Sign up</label>";
                    echo "<input id='tab-2' type='radio' name='tab' class='sign-in'><label for='tab-2' class='tab'>Sign in</label>";
                } else if ($_GET["op"] == "Sign In") {
                    echo "<input id='tab-1' type='radio' name='tab' class='sign-up'><label for='tab-1' class='tab'>Sign up</label>";
                    echo "<input id='tab-2' type='radio' name='tab' class='sign-in' checked ><label for='tab-2' class='tab'>Sign in</label>";
                }
            } else {
                echo "<input id='tab-1' type='radio' name='tab' class='sign-up' checked ><label for='tab-1' class='tab'>Sign up</label>";
                echo "<input id='tab-2' type='radio' name='tab' class='sign-in'><label for='tab-2' class='tab'>Sign in</label>";
            }
            ?>
            <div class="login-form">

                <div class="sign-up-htm">



                    <!-------------------------------------------------------------------------------------------------->
                    <form action="include/signup.inc.php" method="post">

                        <div class="group">
                            <input type="text" class="input" required name="name" placeholder="Full Name" />
                        </div>
                        <div class="group">
                            <input type="text" name="id" class="input" placeholder="National id">
                        </div>
                        <div class="group">
                            <input type="text" placeholder=" National id again" required name="idrepeat" class="input">
                        </div>
                        <div class="group">
                            <input type=" text" required name="phone" class="input" placeholder="phone number">
                        </div>
                        <div class="group">
                            <input type="email" required name="email" class="input" placeholder="E-mail">
                        </div>
                        <div class="group">
                            <input type="password" placeholder=" password" required name="pass" class="input">
                        </div>
                        <div class="group">
                            <input type="password" placeholder=" password again" required name="passrepeat" class="input">
                        </div>
                        <div class="group">

                            <input type="text" required name="address" class="input" placeholder="address">

                        </div>





                        <div class="group">
                            <label> level </label>
                            <br>
                            <select required name="level">
                                <?php
                                for ($i = 1; $i <= 4; $i++)
                                    echo "<option value='$i'>level $i</option>"
                                ?>
                            </select>
                            <br>
                            <label> Department </label>
                            <br>
                            <select required name="depart">
                                <?php
                                for ($i = 0; $i <= 12; $i++)
                                    echo "<option value='$i'>" . $alldepart[$i] . "</option>";
                                ?>
                            </select>
                            <br>
                            <input type="submit" name="submit" value="Sign Up">

                        </div>
                        <?php
                        if (isset($_GET["error"])) {
                            if ($_GET["error"] == "iddontmatch") {
                                echo "<p> Enter correct id </p>";
                            }
                            if ($_GET["error"] == "idexists") {
                                echo "<p> National id already exists </p>";
                            }
                            if ($_GET["error"] == "passdontmatch") {
                                echo "<p> Enter correct password </p>";
                            }
                            if ($_GET["error"] == "emailexists") {
                                echo "<p> E-mail already exists </p>";
                            }
                            if ($_GET["error"] == "studentnotexist") {
                                echo "<p> student doesn't exist </p>";
                            }
                            // if ($_GET["error"] == "none") {
                            //     header("location: login.php");
                            //     exit();
                            // }
                        }
                        ?>

                    </form>
                </div>
                <!-- 
        sign up error messages
     -->

                <!-------------------------------------------------------------------------------------------------->

                <div class="sign-in-htm">
                    <form action="include/login.inc.php" method="post">

                        <div class="group">
                            <label class="label"> e-mail </label>
                            <input type="email" name="logemail" class="input" required>

                        </div>
                        <div class="group">
                            <label class="label"> password </label>
                            <input type="password" name="logpass" class="input" required>
                        </div>
                        <div class="group">
                            <input type="submit" name='submit' value="Sign In">
                        </div>
                        <a href="forgetpass.php"> forget pass?</a> <br>
                    </form>

                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] === "emaildoesntexist") {
                            echo "<p> Enter correct E-mail </p>";
                        }
                        if ($_GET["error"] === "wrongpass") {
                            echo "<p> Enter correct Password </p>";
                        }
                    }
                    ?>
                    <?php
                    include_once "footer.php";
                    ?>
                </div>

                <!-------------------------------------------------------------------------------------------------->

            </div>

        </div>

    </div>


    <!-- check -->
    <?php
    // if (!$_POST)
    //     echo "empty";
    // else {
    //     echo "<pre>";
    //     print_r($_POST);
    //     echo "</pre>";
    // }
    ?>
    <?php
    include_once "footer.php";
    ?>
</body>

</html>

<!-- <label> name as in national id </label>
        <br>
        <input type="text" required name="name">
        <br>
        <label> national id </label>
        <br>
        <input type="text" name="id">
        <br>
        <label> national id "again"</label>
        <br>
        <input type="text" placeholder="must be identical" required name="idrepeat">
        <br>
        <label> phone number </label>
        <br>
        <input type=" text" required name="phone">
        <br>
        <label> e-mail </label>
        <br>
        <input type="email" required name="email">
        <br>
        <label> password </label>
        <br>
        <input type="password" placeholder=" use special chars and nums" required name="pass">
        <br>
        <label> password "again"</label>
        <br>
        <input type="password" placeholder=" use special chars and nums" required name="passrepeat">
        <br>
        <label> address </label>
        <br>
        <input type="text" required name="address">
        <br> -->
<!-- <label> level </label>
        <br>
        <select required name="level">
            <?php
            // for ($i = 1; $i <= 4; $i++)
            //  echo "<option value='$i'>level $i</option>"
            ?>
        </select>
        <br>
        <label> Department </label>
        <br>
        <select required name="depart">
            <?php
            //for ($i = 0; $i <= 12; $i++)
            //echo "<option value='$i'>" . $alldepart[$i] . "</option>";
            ?>
        </select>
        <br>
        <button type="submit" name="submit">Sign up</button>
        <input type="reset"> -->