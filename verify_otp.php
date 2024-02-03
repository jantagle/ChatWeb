<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
</head>

<body>
    <?php
    session_start();
    include("dbcon/connection.php");
    require 'vendor/autoload.php';

    if (isset($_POST['verify'])) {
        $enteredOTP = $_POST['Otp'];

        // Check if the entered OTP matches the one stored in the session (set in forgot_password.php)
        if ($_SESSION['Otp'] == $enteredOTP) {
            // OTP is correct, allow the user to reset their password
            // You can redirect the user to a password reset page
            header('Location: reset_password.php');
            exit();
        } else {
            echo "Invalid OTP. Please try again.";
        }
    }
    ?>

    <h2>Verify OTP</h2>
    <form action="verify_otp.php" method="post">
        <p>An OTP has been sent to your email. Please enter it below:</p>
        <label for="otp">Enter OTP:</label>
        <input type="text" name="otp" required>
        <button type="submit" name="verify">Verify</button>
    </form>
</body>

</html>