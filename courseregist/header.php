<?php
session_start();
?>

<body>
        <ul>
                <?php
                if (isset($_SESSION["userid"])) {
                        echo "<li>" . $_SESSION['username'] . "</li>";
                        echo "<li><a href='profile.php'>Profile</a></li>";
                        echo "<li><a href='include/logout.inc.php'>Log Out</a></li>";
                } else {
                        echo "<li><a href='signup.php'>Sign up</a></li>";
                        echo "<li><a href='login.php'>Log in</a> <br> </li>";
                }
                ?>
                <!--
        لو عايزين تضيفوا 
        about 
        ونبقا نملاها بعدين ماشي
        لو مش عايزين فاكس
        -->
        </ul>

</body>