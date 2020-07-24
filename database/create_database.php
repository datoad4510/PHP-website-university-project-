<?php

$servername = "localhost";
$username = "root";
$password = "";

$con = new mysqli($servername, $username, $password);

if ($con->connect_errno) {
    echo "Connection failed: " . $con->connect_errno;
    exit();
}

//not working...
/* $query = "DROP DATABASE IF EXISTS 'my_database'";
$con->query($query); */

$query = "CREATE DATABASE mydatabase";
$con->query($query);

$con = new mysqli($servername, $username, $password, "mydatabase");
if ($con->connect_errno) {
    echo "Connection failed: " . $con->connect_errno;
}


//making a N:N connection below
$query = "CREATE TABLE User (
user_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(50) NOT NULL UNIQUE,
password VARCHAR(50) NOT NULL,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL,
gender VARCHAR(10) NOT NULL,
is_admin BIT(1) NOT NULL
)";
$con->query($query);
$query = "ALTER TABLE User ENGINE = InnoDB;";
$con->query($query);
$query = "ALTER TABLE User CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;";
$con->query($query);



$query = "CREATE TABLE Pictures (
picture_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
image_path VARCHAR(200) NOT NULL,
image_name VARCHAR(100) NOT NULL,
author_id INT(10) UNSIGNED
)";
$con->query($query);
$query = "ALTER TABLE Pictures ENGINE = InnoDB;";
$con->query($query);
$query = "ALTER TABLE Pictures CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;";
$con->query($query);

$query = "CREATE TABLE UserPictures (
userpicture_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
user_id INT(10) UNSIGNED,
picture_id INT(10) UNSIGNED
)";
$con->query($query);
$query = "ALTER TABLE UserPictures ENGINE = InnoDB;";
$con->query($query);
$query = "ALTER TABLE UserPictures CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;";
$con->query($query);
$query = "ALTER TABLE `UserPictures` ADD CONSTRAINT `FK_picture_id` FOREIGN KEY (`picture_id`) REFERENCES `pictures`(`picture_id`) ON DELETE CASCADE ON UPDATE CASCADE;";
$con->query($query);
$query = "ALTER TABLE `UserPictures` ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;";
$con->query($query);
$query = "ALTER TABLE `UserPictures` ADD UNIQUE 'unique_fields'(`user_id`, `picture_id`);";
$con->query($query);



//1:1 connection below
$query = "CREATE TABLE Competition (
competition_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
picture_id INT(10) NOT NULL UNIQUE,
competition_name VARCHAR(100) NOT NULL
)";
$con->query($query);
$query = "ALTER TABLE Competition ENGINE = InnoDB;";
$con->query($query);
$query = "ALTER TABLE Competition CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;";
$con->query($query);
$query = "ALTER TABLE `Competition` ADD CONSTRAINT `FK_competition_picture` FOREIGN KEY (`picture_id`) REFERENCES `pictures`(`picture_id`) ON DELETE CASCADE ON UPDATE CASCADE;";
$con->query($query);


//1:N connection below
$query = "CREATE TABLE Authors (
author_id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
author_name VARCHAR(100) NOT NULL UNIQUE
)";
$con->query($query);
$query = "ALTER TABLE Authors ENGINE = InnoDB;";
$con->query($query);
$query = "ALTER TABLE Authors CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci;";
$con->query($query);
$query = "ALTER TABLE `Pictures` ADD CONSTRAINT `FK_picture_author` FOREIGN KEY (`author_id`) REFERENCES `Authors`(`author_id`) ON DELETE CASCADE ON UPDATE CASCADE;";
$con->query($query);

//inserting initial data

$query = "INSERT INTO User (user_id,username,password,firstname,lastname,email,gender,is_admin) VALUES (1,'admin',md5('admin'),'David','Adamashvili','david.adamashvili@gmail.com','male',1)";
$con->query($query);


$query = "INSERT INTO Authors (author_id, author_name) VALUES (1,'Leonardo Davinci')";
$con->query($query);
$query = "INSERT INTO Authors (author_id, author_name) VALUES (2,'Niko Pirosmani')";
$con->query($query);


$query = "INSERT INTO Pictures (picture_id, image_path,image_name,author_id) VALUES (1,'Images/vaporwave.jpg','Vaporwave',1)";
$con->query($query);
$query = "INSERT INTO Pictures (picture_id, image_path,image_name,author_id) VALUES (2,'Images/background.jpg','Background',2)";
$con->query($query);

//user 1 likes pictures 1 and 2
$query = "INSERT INTO userpictures (userpicture_id,user_id, picture_id) VALUES (1,1,1)";
$con->query($query);
$query = "INSERT INTO userpictures (userpicture_id,user_id, picture_id) VALUES (2,1,2)";
$con->query($query);


$query = "INSERT INTO Competition (competition_id,picture_id, competition_name) VALUES (1,1,'Caucasus championship')";
$con->query($query);
$query = "INSERT INTO Competition (competition_id,picture_id, competition_name) VALUES (2,2,'Gldani picture competition')";
$con->query($query);


header("Location: ../index.html");

/* try{
    $conn = new PDO("mysql:host=$servername;",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo "Connected Successfully";
}
catch(PDOException $e){
    echo "Connection failed: ".$e->getMessage();
} */
