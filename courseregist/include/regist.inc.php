<?php
//طلاما هنستعمل حاجة من حاجة ال
// session
//يبقا لازم نبدأها الاول !
session_start();
if (isset($_POST["regist"])) {
    if (isset($_SESSION["userName"])) {
        header("location: ../regist.php");
        exit();
    } else {
        header("location: ../index.php?error=nologin");
        exit();
    }
}
