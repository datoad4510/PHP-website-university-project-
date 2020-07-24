<?php
session_start();
$user_id = $_GET['user_id'];
$picture_id = $_GET['picture_id'];
$server = "localhost";
$user = "root";
$pw = "";
$dbname = "mydatabase";
$con = new mysqli($server, $user, $pw, $dbname);
//aq ar unda dacva radgan users ar sheyavs
$query = "INSERT INTO userpictures (user_id, picture_id) VALUES ($user_id,$picture_id)";
if ($con->query($query)) {
    header("Location: userpage.php");
} else {
    echo $con->error;
}
