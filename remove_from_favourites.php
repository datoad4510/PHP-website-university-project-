<?php
session_start();
$user_id = $_GET['user_id'];
$picture_id = $_GET['picture_id'];
$server = "localhost";
$user = "root";
$pw = "";
$dbname = "mydatabase";
echo "$user_id<br><br>";
$con = new mysqli($server, $user, $pw, $dbname);
//aq ar unda dacva radgan users ar sheyavs
$query = "DELETE FROM `userpictures` WHERE user_id =" . $user_id . " AND picture_id=" . $picture_id;
if ($con->query($query)) {
    header("Location: userpage.php");
} else {
    echo $con->error;
}
