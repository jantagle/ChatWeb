<?php
session_start();
include("dbcon/connection.php");

require 'vendor/autoload.php';  // Use Composer autoloader



if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT * FROM usertable WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generate a random OTP
        $otp = sprintf('%06d', mt_rand(100000, 999999));

        // Update the user record with the generated OTP
        $stmt = $conn->prepare("UPDATE usertable SET Otp = ? WHERE Email = ?");
        $stmt->bind_param("ss", $otp, $email);
        $stmt->execute();

        // Send the OTP to the user's email using PHPMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'live.smtp.mailtrap.io';
        $mail->SMTPAuth = 'LOGIN';
        $mail->Port = 587;
        $mail->Username = 'api';
        $mail->Password = 'df7763b7f5aa3fe98def7f2f7da1012a';

        $mail->setFrom('mailtrap@chatweb.com', 'jantagle7116@gmail.com'); // Replace with your email and name
        $mail->addAddress($email); // User's email

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset OTP';
        $mail->Body = "Your OTP for password reset is: $otp";

        if ($mail->send()) {
            // Store email in session for verification
            $_SESSION['email'] = $email;

            // Redirect the user to the OTP verification page
            header('Location: verify_otp.php');
            exit();
        } else {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        echo "Email not found in the database.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
</head>

<body>
    <h2>Forgot Password</h2>
    <form action="forgot.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>

</html>