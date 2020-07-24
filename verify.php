<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/backend.css">
    <title>Portfolio</title>
</head>

<body id="verification-body">
    <?php
    session_start();


    if (isset($_POST['submit'])) {
        if ($_POST['inputted-verification-code'] == $_SESSION['verification_code']) {
            $_SESSION['verified'] = true;
            echo "<h1 id='verified'>Verified!! You will be redirected to the login page.</h1>";
            header("refresh:5;url=signup.php");
            exit();
        } else {
            echo "<h2 id='wrongcode-message'>Wrong code. Another code will be sent to you</h2>.<br><br>";
        }
    }

    $_SESSION['verification_code'] = rand();



    //Import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    require 'vendor/autoload.php';

    //Create a new PHPMailer instance
    $mail = new PHPMailer;

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    try {
        //Enable SMTP debugging
        /* $mail->SMTPDebug = SMTP::DEBUG_SERVER; */

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        // use
        // $mail->Host = gethostbyname('smtp.gmail.com');
        // if your network does not support SMTP over IPv6

        //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
        $mail->Port = 587;

        //Set the encryption mechanism to use - STARTTLS or SMTPS
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = 'university.project334@gmail.com';

        //Password to use for SMTP authentication
        $mail->Password = 'Irakli58';

        //Set who the message is to be sent from
        $mail->setFrom('davit.adamashvili848@ens.tsu.edu.ge', 'David Adamashvili');

        //Set an alternative reply-to address
        /* $mail->addReplyTo('replyto@example.com', 'First Last'); */

        //Set who the message is to be sent to
        $mail->addAddress($_SESSION['email'], $_SESSION['firstname'] . $_SESSION['lastname']);

        //Set the subject line
        $mail->Subject = 'Email verification';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body

        //write into verification_mail_contents.html file

        /*     $mail->msgHTML(file_get_contents('verification_mail_contents.html'), __DIR__);
 */

        $mail->Body = 'Use this code to verify your email: ' . $_SESSION['verification_code'];


        //Replace the plain text body with one created manually
        /*     $mail->AltBody = 'Use this code to verify your email: ' . $_SESSION['verification_code'];
 */
        //Attach an image file
        /* $mail->addAttachment('images/phpmailer_mini.png'); */

        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    ?>


    <?php echo '<!DOCTYPE html>

    <br><br><br>
    <div id="verification-info">We have sent a code to your email. Enter it here to verify your email. You will be able to log in afterwards</div>
    <form action="" method="post">
        <input type="text" name="inputted-verification-code" required><br><br><br>
        <input type="submit" value="Submit" name="submit">
    </form>
';
    ?>

</body>

</html>