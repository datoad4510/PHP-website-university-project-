<?php
//davicvat vigaca url-it ar shemovides
session_start();
if ($_SESSION['is_admin'] != true) {
    exit("Entry forbidden.");
}

$server = "localhost";
$user = "root";
$pw = "";
$dbname = "mydatabase";
$con = new mysqli($server, $user, $pw, $dbname);

$query = "DELETE FROM `user` WHERE `user`.`user_id` =" . $_GET['user_id'];




if ($result = $con->query($query)) {
    header("Location: adminpage.php");
} else {
    echo "Error deleting : " . $con->error;
    exit();
}
