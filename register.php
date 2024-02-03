<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
</head>

<body>

    <?php

    session_start(); // Start the session
    
    include("dbcon\connection.php");

    // Check if the user is already logged in via session or cookie
    if (isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    } elseif (isset($_COOKIE['remember_me'])) {
        // Validate the remember_me cookie
        $user_id_from_cookie = $_COOKIE['remember_me'];
        $check_cookie_sql = "SELECT * FROM usertable WHERE UserID = $user_id_from_cookie";
        $check_cookie_result = $conn->query($check_cookie_sql);

        if ($check_cookie_result->num_rows > 0) {
            $user_row = $check_cookie_result->fetch_assoc();
            $_SESSION['user_id'] = $user_row['UserID'];
            $_SESSION['username'] = $user_row['Username'];
            header("Location: index.php");
            exit;
        }
    }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        // Simple validation (you should enhance this for real-world use)
        if ($password != $confirm_password) {
            echo "<script>alert('Password and confirm password do not match.');</script>";
            exit;
        }

        // Check if the email already exists
        $check_email_sql = "SELECT * FROM usertable WHERE email = '$email'";
        $check_email_result = $conn->query($check_email_sql);

        if ($check_email_result->num_rows > 0) {
            echo "<script>alert('Email already exists. Please choose a different one.'); window.location='register.php';</script>";
        }

        // Hash the password (for better security, use a proper hashing method like bcrypt)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user information into the database
        $insert_sql = "INSERT INTO usertable (Username, Email, PasswordHash) VALUES ('$username', '$email', '$hashed_password')";

        if ($conn->query($insert_sql) === TRUE) {
            echo "<script>alert('Registration successful!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Error: " . $insert_sql . "\\n" . $conn->error . "');</script>";
        }
    }

    // Close the database connection
    $conn->close();
    ?>

    <div>
        <h2>Register</h2>
        <form action="register.php" method="post">
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" required><br>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" required><br>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" required><br>
            </div>
            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" required><br>
            </div>
            <div>
                <input type="submit" value="Register">
                <a href="login.php">Login</a>
            </div>
        </form>
    </div>

</body>

</html>