<?php
//davicvat vigaca url-it ar shemovides
session_start();
if ($_SESSION['is_admin'] != true) {
    exit("Entry forbidden.");
}

echo "<h1 id='welcome-text'>Edit user data</h1><br>";
echo "<a id='admin-link' href='adminpage.php'>Go back to admin page</a><br><br>";

$server = "localhost";
$user = "root";
$pw = "";
$dbname = "mydatabase";

$con = new mysqli($server, $user, $pw, $dbname);

$username;
$password;
$firstname;
$lastname;
$email;
$gender;
$is_admin;

//get info on this user and initially fill the form
$query = "SELECT * FROM User WHERE user_id = " . $_GET['user_id'];

if ($result = $con->query($query)) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
    $password = $row['password'];
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $email = $row['email'];
    $gender = $row['gender'];
    $is_admin = $row['is_admin'];
    $result->free_result();
} else {
    echo "Error selecting this user's data: " . $con->error;
}

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
    <form id="adminpage-form" action="" method="post">
        <input type="hidden" name="user_id" value=<?php echo "'" . $_GET['user_id'] . "'" ?>>
        <label for="username">Username: </label>
        <input type="text" name="username" required <?php echo "value='" . $username . "'"; ?>><br><br>
        <label for="password">Password: </label>
        <input type="password" name="password" required <?php echo "value='" . $password . "'"; ?>><br><br>
        <label for="firstname">First name: </label>
        <input type="text" name="firstname" required <?php echo "value='" . $firstname . "'"; ?>><br><br>
        <label for="lastname">Last name: </label>
        <input type="text" name="lastname" required <?php echo "value='" . $lastname . "'"; ?>><br><br>
        <label for="email">Email: </label>
        <input type="email" name="email" required <?php echo "value='" . $email . "'"; ?>><br><br>
        <label for="gender">Gender: </label><br><br>
        <input type="radio" id="male" name="gender" value="male" required <?php if ($gender == "male") {
                                                                                echo "checked";
                                                                            } ?>>
        <label for="male">Male</label><br>
        <input type="radio" id="female" name="gender" value="female" required <?php if ($gender == "female") {
                                                                                    echo "checked";
                                                                                } ?>>
        <label for="female">Female</label><br>
        <input type="radio" id="other" name="gender" value="other" required <?php if ($gender == "other") {
                                                                                echo "checked";
                                                                            } ?>>
        <label for="other">Other</label><br><br>
        <label for="is_admin">Is admin: </label>
        <!--         if isset(is_admin) use is_admin = 1-->
        <input type="checkbox" id="is_admin" name="is_admin" value="1" <?php if ($is_admin == 1) {
                                                                            echo "checked";
                                                                        } ?>><br><br>
        <input type="submit" name="update" id="update" value="Update">
    </form>

    <?php
    if (isset($_POST['update'])) {
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


        $query = $con->prepare("UPDATE User SET username = ?, password = ?, firstname = ?, lastname = ?,email = ?,gender = ?,is_admin = ? WHERE user_id = " . $_POST['user_id']);
        $param_string = "ssssssi";
        $password_hash = md5($password);
        $query->bind_param($param_string, $username, $password_hash, $firstname, $lastname, $email, $gender, $is_admin);

        if ($query->execute()) {
            header("Location: adminpage.php");
        } else {
            echo "<br>Error updating: " . $con->error;
        }
        $con->close();
    }
    ?>
</body>

</html>