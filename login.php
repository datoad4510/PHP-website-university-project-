<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style.css">
    <script src="https://kit.fontawesome.com/1acc259e03.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="Javascript/jquery.js"></script>
    <title>Portfolio</title>
</head>

<body id="contact-body">
    <header>
        <nav>
            <ul>
                <li class="menu-item-container">
                    <a href="index.html">Home</a>
                </li>

                <li class="menu-item-container">
                    <a href="about.html">About Me</a>
                </li>

                <li class="menu-item-container">
                    <a href="projects.html">Projects</a>
                </li>

                <li class="menu-item-container">
                    <a href="login.php">Log in</a>
                </li>

                <li id="arrow-container">
                    <i id="dropdown-button" class="arrow fas fa-arrow-down fa-2x"></i>
                </li>
            </ul>
        </nav>
    </header>

    <div class="form-container">
        <form action="" method="post">
            <legend>Log in:</legend>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>


            <input type="submit" value="Log in"><br><br>

            <a id="signup-link" href="signup.php">Sign Up</a>

            <?php
            //radgan formashi yvelaferi required aris, erti mainc rom iyos isset, yvela iqneba isset amitom ar davwerot yvela if-shi
            if (isset($_POST["username"])) {
                $server = "localhost";
                $user = "root";
                $pw = "";
                $dbname = "mydatabase";

                $con = new mysqli($server, $user, $pw, $dbname);
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }


                $username = stripcslashes($_POST["username"]);
                $username = mysqli_real_escape_string($con, $username);

                $password = stripcslashes($_POST["password"]);
                $password = mysqli_real_escape_string($con, $password);


                $query = $con->prepare("SELECT is_admin, user_id, username FROM User WHERE username = ? AND password = ?");
                $param_types = "ss";
                $password_hash = md5($password);
                $query->bind_param($param_types, $username, $password_hash);
                $result;

                if ($query->execute()) {
                    $result = $query->get_result();
                    if (mysqli_num_rows($result) == 0) {
                        echo "<br>Invalid username or password.";
                    } else {
                        echo "<br>Congrats!";
                        session_start();

                        $row = $result->fetch_assoc();
                        $_SESSION["is_admin"] = $row["is_admin"];
                        $_SESSION["user_id"] = $row["user_id"];
                        $_SESSION["username"] = $row["username"];

                        if ($_SESSION["is_admin"] == true) {
                            header("Location: adminpage.php");
                        } else {
                            header("Location: userpage.php");
                        }

                        //if is_admin == 0, go to user, if 1, go to admin
                    }
                } else {
                    echo "Something went wrong: " . $con->error;
                }
                $result->free_result();
                $con->close();
            }

            ?>
        </form>
    </div>

    <footer>
        <ul>
            <li>
                <a href="#"><i class="first fab fa-linkedin fa-2x"></i></a>

            </li>

            <li>
                <a href="#"><i class="second fab fa-google fa-2x" href=""></i></a>

            </li>

            <li>
                <a href="#"><i class="third fab fa-github-square fa-2x"></i></a>
            </li>

        </ul>

    </footer>
</body>

</html>