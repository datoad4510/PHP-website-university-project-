<?php
//davicvat vigaca url-it ar shemovides
session_start();
if ($_SESSION['is_admin'] != true) {
    exit("Entry forbidden.");
}

echo "<h1 id='welcome-text'> Welcome to the admin page</h1>";
echo "<br><a id='user-link' href='userpage.php'>Go to user page</a><br><br>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/backend.css">
    <title>Portfolio</title>
</head>

<body>
    <form id="adminpage-form" action="admin_insert_user.php" method="post">
        <h2>Register a new user</h2><br>
        <label for="username">Username: </label>
        <input type="text" name="username" required><br><br>
        <label for="password">Password: </label>
        <input type="password" name="password" required><br><br>
        <label for="firstname">First name: </label>
        <input type="text" name="firstname" required><br><br>
        <label for="lastname">Last name: </label>
        <input type="text" name="lastname" required><br><br>
        <label for="email">Email: </label>
        <input type="email" name="email" required><br><br>
        <label for="gender">Gender: </label><br><br>
        <input type="radio" id="male" name="gender" value="male" required>
        <label for="male">Male</label><br>
        <input type="radio" id="female" name="gender" value="female" required>
        <label for="female">Female</label><br>
        <input type="radio" id="other" name="gender" value="other" required>
        <label for="other">Other</label><br><br>
        <label for="is_admin">Is admin: </label>
        <!--         if isset(is_admin) use is_admin = 1-->
        <input type="checkbox" id="is_admin" name="is_admin" value="1"><br><br>
        <input type="submit" name="add" id="add" value="Register">
    </form>






    <?php
    //display users
    $server = "localhost";
    $user = "root";
    $pw = "";
    $dbname = "mydatabase";
    $con = new mysqli($server, $user, $pw, $dbname);

    $query = $con->prepare("SELECT * FROM User");

    $result;

    if ($query->execute()) {
        $result = $query->get_result();
        echo "<table id='admin-table' border = 1>";
        echo "<tr><th  colspan='4' id='table-heading'>Currently registered users</th><tr>";
        echo "<tr><th>id</th><th>Username</th></tr>";
        while ($row = $result->fetch_assoc()) {
            //$user_id = $row['user_id'];
            $class_admin = "";
            if ($row['is_admin'] == 1) {
                $class_admin = "class = 'admin'";
            }
            echo "<tr><td>" . $row['user_id'] . "</td><td $class_admin>" . $row['username'] . "</td><td><a href='admin_delete_user.php?user_id=" . $row['user_id'] . "'>Delete</a></td><td><a href='admin_update_user.php?user_id=" . $row['user_id'] . "'>Update</a></td>";
        }
        echo "</table>";
    } else {
        echo "Something went wrong: " . $con->error;
    }
    $result->free_result();
    $con->close();

    ?>
    <div id="logging-container">
        <h1>Using files to log user info:</h1><br><br>
        Log user info into database\user_information.txt

        <form action="" method="post">
            <br>
            <input type="submit" name="log" id="log" value="log" /><br>
        </form><br><br>

        Show user info contained in database\user_information.txt

        <form action="" method="post">
            <br>
            <input type="submit" name="show" id="show" value="show" /><br>
        </form><br><br>

        <?php

        //user information logging to file and reading from file
        if (isset($_POST['log'])) {
            $server = "localhost";
            $user = "root";
            $pw = "";
            $dbname = "mydatabase";

            $con = new mysqli($server, $user, $pw, $dbname);
            if ($con->connect_error) {
                die("Connection failed: " . $con->connect_error);
            }


            $query = $con->prepare("SELECT * FROM User");

            $result;

            if ($query->execute()) {
                $result = $query->get_result();
                $file = fopen("database/user_information.txt", "w+") or exit("Unable to open file!");

                while ($row = $result->fetch_assoc()) {
                    foreach ($row as $key => $value) {
                        $info = "$key" . ": " . "$value\n";
                        fwrite($file, $info);
                    }
                    $gap = "\n\n\n\n";
                    fwrite($file, $gap);
                }

                fclose($file);
            } else {
                echo "Something went wrong: " . $con->error;
            }
            $result->free_result();
            $con->close();
        } elseif (isset($_POST['show'])) {
            //new line to <br>
            echo "<div id='logged-data'>";
            echo nl2br(file_get_contents("database/user_information.txt"));
            echo "</div>";
        }

        ?>
    </div>
</body>

</html>