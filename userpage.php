<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/backend.css">
    <title>Portfolio</title>
</head>

<body>

    <h1 id="welcome-text">Welcome, <?php echo $_SESSION['username'] . "!"; ?></h1><br>
    <?php
    if ($_SESSION['is_admin'] == 1) {
        echo "<a id='admin-link' href='adminpage.php'>Go back to admin page</a>";
    }
    ?>
    <form id="userpage-form" action="image_upload.php" method="post" enctype="multipart/form-data">
        <br>
        <h3>Upload a new image to the database:</h2><br>
            <input type="hidden" name="MAX_FILE_SIZE" value="10000000"><br><br>
            Select image to upload:
            <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>
            Type the name of the author:
            <input type="text" name="authorName" required><br><br>
            <input type="submit" value="Upload Image" name="submit"><br><br>


    </form>
    <?php


    $user_id = $_SESSION['user_id']; //look in login.php to see how $_SESSION is initialized
    //make two image_id => image_path associative arrays, one for left and one for right
    //select favourite pictures on right, other pictures on left. select image_path and then
    //if you click a picture on right, it is moved to the left. if you click on left, it is moved to the right
    //echo "<img src='path'>"
    /* <a href="image_upload.php/?picture_id=<php? echo id; ?>&user_id=(from session)" */
    // image_path = "Images/".image_name.".jpg"

    //make a class called Image with an id and path
    $server = "localhost";
    $user = "root";
    $pw = "";
    $dbname = "mydatabase";
    $con = new mysqli($server, $user, $pw, $dbname);

    class Image
    {
        private $picture_id;
        private $picture_path;

        function __construct($picture_id, $picture_path)
        {
            $this->picture_id = $picture_id;
            $this->picture_path = $picture_path;
        }

        function get_id()
        {
            return $this->picture_id;
        }
        function get_path()
        {
            return $this->picture_path;
        }
    }
    //$img = new Image(1,'Images/imgname.png');
    //$img->get_id();
    $favourite_num = 0;
    $other_num = 0;
    //favourite pictures of this user:
    $query = "SELECT userpictures.picture_id, pictures.image_path FROM userpictures INNER JOIN pictures WHERE userpictures.picture_id = pictures.picture_id AND userpictures.user_id = $user_id";


    $favourites = array();

    if ($result = $con->query($query)) {
        while ($row = $result->fetch_assoc()) {
            //aq userpictures.picture_id xom ar unda?
            $favourites[] = new Image($row['picture_id'], $row['image_path']);
            $favourite_num += 1;
        }
        $result->free_result();
    } else {
        echo "Error displaying favourite pictures: " . $con->error;
    }


    // other pictures
    $query = "SELECT pictures.picture_id, pictures.image_path FROM pictures WHERE picture_id not in (SELECT userpictures.picture_id FROM userpictures INNER JOIN pictures WHERE userpictures.picture_id = pictures.picture_id AND userpictures.user_id = $user_id)";

    $others = array();

    if ($result = $con->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $others[] = new Image($row['picture_id'], $row['image_path']);
            $other_num += 1;
        }
        $result->free_result();
    } else {
        echo "Error displaying favourite pictures: " . $con->error;
    }
    /* echo '<br><br>Favourite pictures:<pre>';
    print_r($favourites);
    echo '</pre>';

    echo '<br><br>Other pictures:<pre>';
    print_r($others);
    echo '</pre>'; */
    ?>
    <div id="container-container">
        <h1>Click on the images to remove or add them to favourites</h1><br><br>
        <div id="content-container">
            <div id="left-content">
                <?php
                //echo all other images
                echo "<h2>Other pictures:</h2><br>";
                foreach ($others as $image) {
                    echo "<a href='add_to_favourites.php?picture_id=" . $image->get_id() . "&user_id=" . "$user_id" . "'><img src=" . $image->get_path() . " width='100' height='100'></a>";
                }
                ?>
            </div>

            <div id="right-content">
                <?php
                //echo all favourite images
                echo "<h2>Favourite pictures:</h2><br>";
                foreach ($favourites as $image) {
                    echo "<a href='remove_from_favourites.php?picture_id=" . $image->get_id() . "&user_id=" . "$user_id" . "'><img src=" . $image->get_path() . " width='100' height='100'></a>";
                }
                ?>
            </div>

        </div>
    </div>

</body>

</html>