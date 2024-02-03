<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>

<body>
    <?php
    session_start();
    include("dbcon/connection.php");

    if (isset($_POST['reset'])) {
        $newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        // Update the user's password in the database (assuming 'users' table)
        $stmt = $conn->prepare("UPDATE usertable SET PasswordHash = ? WHERE Email = ?");
        $stmt->bind_param("ss", $newPassword, $_SESSION['email']);
        $stmt->execute();

        // Redirect the user to the login page or any other appropriate page
        header('Location: login.php');
        exit();
    }
    ?>
    <h2>Reset Password</h2>
    <form action="reset_password.php" method="post">
        <p>Enter your new password below:</p>
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>
        <button type="submit" name="reset">Reset Password</button>
    </form>
</body>

</html>