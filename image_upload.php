<?php
session_start();


if (isset($_FILES['fileToUpload']['name'])) {
    $server = "localhost";
    $user = "root";
    $pw = "";
    $dbname = "mydatabase";

    $con = new mysqli($server, $user, $pw, $dbname);
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }





    //upload image to database


    $target_path = "Images/";
    $target_path = $target_path . basename($_FILES["fileToUpload"]["name"]);
    //if there are spaces in the name, encode them because they can't be used
    //in src='' attributes of images
    $target_path = str_replace(' ', '%20', $target_path);
    $status = 1; //yvelaferi kargadaa
    $extension = pathinfo($target_path, PATHINFO_EXTENSION);
    if (isset($_POST["submit"])) {
        if (file_exists($target_path)) {
            echo "The file already exists";
            $status = 0;
        }
        if ($extension != "jpg" && $extension != "jpeg" && $extension != "jpeg" && $extension != "gif" && $extension != "png") {
            echo "<br><br>The file has to be an image.";
            $status = 0;
        }
    }
    if ($status == 0) {
        echo "<br><br>Your file could not be uploaded.";
        echo "<br><br> <a href='userpage.php'>Go back to user page</a>";
        exit();
    }

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_path)) {
    } else {
        echo "Error uploading file.";
        exit();
    }
    if ($status == 1) {
        echo "File has been uploaded!";
    }


    //if author doesn't exist, add to Authors

    //protect from sql injection
    $author_name = stripcslashes($_POST["authorName"]);
    $author_name = mysqli_real_escape_string($con, $author_name);
    $query = $con->prepare("SELECT author_id FROM Authors WHERE author_name = ?");
    $param_string = "s";
    $query->bind_param($param_string, $author_name);

    $result;
    $author_id;
    if ($query->execute()) {
        $result = $query->get_result();
        $row = $result->fetch_assoc();

        if (mysqli_num_rows($result) == 0) {
            //if no results, add this author
            $query = $con->prepare("INSERT INTO Authors (author_name) VALUES (?)");
            $param_string = "s";
            $query->bind_param($param_string, $author_name);
            if ($query->execute()) {
                echo "Inserted author " . $author_name . " into the database.<br><br>";

                //find out new $author_id
                $query = $con->prepare("SELECT author_id FROM Authors WHERE author_name = ?");
                $param_string = "s";
                $query->bind_param($param_string, $author_name);
                if ($query->execute()) {
                    $result = $query->get_result();
                    $row = $result->fetch_assoc();
                    $author_id = $row['author_id'];
                } else {
                    echo "Something went wrong: " . $con->error;
                    exit();
                }
            } else {
                echo "Something went wrong: " . $con->error;
                exit();
            }
        } else {
            $author_id = $row['author_id'];
        }
    } else {
        echo "Something went wrong: " . $con->error;
        exit();
    }

    //add file to database
    $result->free_result();
    $query = "INSERT INTO Pictures (image_path,image_name,author_id) VALUES (" . "'" . $target_path . "'" . "," . "'" . basename($_FILES["fileToUpload"]["name"], "." . $extension) . "'" . "," . $author_id . ")";
    if ($con->query($query)) {
        echo "<br><br>Inserted image into the database";
    } else {
        echo "<br><br>Problem with insertion " . $con->error;
    }

    $con->close();

    echo "<br><br> <a href='userpage.php'>Go back to user page</a>";
    exit();
}
