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
            <legend>Sign up:</legend>
            <label for="fname">Username:</label>
            <input type="text" id="username" name="username" required><br>
            <label for="fname">Password:</label>
            <input type="password" id="password" name="password" required><br>
            <label for="fname">First name:</label>
            <input type="text" id="fname" name="fname" required><br>
            <label for="lname">Last name:</label>
            <input type="text" id="lname" name="lname" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="male">Male</label>
            <input type="radio" name="gender" id="male" value="male" required><br>
            <label for="female">Female</label>
            <input type="radio" name="gender" id="female" value="female" required><br>
            <label for="other">Other</label>
            <input type="radio" name="gender" id="other" value="other" required><br>


            <input type="submit" value="Sign up">

            <?php
            session_start();


            if (isset($_SESSION['verified'])) {
                unset($_SESSION['verified']);
                echo "<br><br>Verification successful<br><br>";
                $server = "localhost";
                $user = "root";
                $pw = "";
                $dbname = "mydatabase";

                $con = new mysqli($server, $user, $pw, $dbname);
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                $is_admin = 0;

                $username = stripcslashes($_SESSION["username"]);
                $username = mysqli_real_escape_string($con, $username);

                $password = stripcslashes($_SESSION["password"]);
                $password = mysqli_real_escape_string($con, $password);

                $firstname = stripcslashes($_SESSION["firstname"]);
                $firstname = mysqli_real_escape_string($con, $firstname);

                $lastname = stripcslashes($_SESSION["lastname"]);
                $lastname = mysqli_real_escape_string($con, $lastname);

                $email = stripcslashes($_SESSION["email"]);
                $email = mysqli_real_escape_string($con, $email);

                $gender = stripcslashes($_SESSION["gender"]);
                $gender = mysqli_real_escape_string($con, $gender);

                $query = $con->prepare("INSERT INTO User (username, password, firstname, lastname,email,gender,is_admin) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $param_string = "ssssssi";
                $password_hash = md5($password);
                $query->bind_param($param_string, $username, $password_hash, $firstname, $lastname, $email, $gender, $is_admin);

                if ($query->execute()) {
                    header("Location: login.php");
                } else {
                    echo "<br>Username already in use.";
                }
                $con->close();
            }


            //radgan formashi yvelaferi required aris, erti mainc rom iyos isset, yvela iqneba isset amitom ar davwerot yvela if-shi
            if (isset($_POST["username"])) {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['password'] = $_POST['password'];
                $_SESSION['firstname'] = $_POST['fname'];
                $_SESSION['lastname'] = $_POST['lname'];
                $_SESSION['email'] = $_POST['email'];
                $_SESSION['gender'] = $_POST['gender'];
                header("Location: verify.php");
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