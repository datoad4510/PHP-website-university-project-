    <?php
    //davicvat vigaca url-it ar shemovides
    session_start();
    if ($_SESSION['is_admin'] != true) {
        exit("Entry forbidden.");
    }


    //insert into the database
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

        $is_admin = 0;
        if (isset($_POST['is_admin'])) {
            $is_admin = 1;
        }

        $username = stripcslashes($_POST["username"]);
        $username = mysqli_real_escape_string($con, $username);

        $password = stripcslashes($_POST["password"]);
        $password = mysqli_real_escape_string($con, $password);

        $firstname = stripcslashes($_POST["firstname"]);
        $firstname = mysqli_real_escape_string($con, $firstname);

        $lastname = stripcslashes($_POST["lastname"]);
        $lastname = mysqli_real_escape_string($con, $lastname);

        $email = stripcslashes($_POST["email"]);
        $email = mysqli_real_escape_string($con, $email);

        $gender = stripcslashes($_POST["gender"]);
        $gender = mysqli_real_escape_string($con, $gender);

        $query = $con->prepare("INSERT INTO User (username, password, firstname, lastname,email,gender,is_admin) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $param_string = "ssssssi";
        $password_hash = md5($password);
        $query->bind_param($param_string, $username, $password_hash, $firstname, $lastname, $email, $gender, $is_admin);

        if ($query->execute()) {
            header("Location: adminpage.php");
        } else {
            echo "<br>Username already in use.";
        }
        $con->close();
    }

    ?>