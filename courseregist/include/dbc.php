<?php 
$servername="localhost";
$dbusername="root";
$dbpassword="";
$dbname="courseregist";
$dbname2="studentresults";

$conn=mysqli_connect($servername,$dbusername,$dbpassword,$dbname);
$conn2=mysqli_connect($servername,$dbusername,$dbpassword,$dbname2);
if (!$conn)
{
    die("connection failed: ".mysqli_connect_error());
}
if (!$conn2)
{
    die("connection failed: ".mysqli_connect_error());
}