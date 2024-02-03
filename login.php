<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles\login.css">
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
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Check if the user exists
        $check_user_sql = "SELECT * FROM usertable WHERE Email = '$email'";
        $check_user_result = $conn->query($check_user_sql);

        if ($check_user_result->num_rows > 0) {
            // User exists, check password
            $user_row = $check_user_result->fetch_assoc();
            if (password_verify($password, $user_row['PasswordHash'])) {
                // Login successful, store user data in session
                $_SESSION['user_id'] = $user_row['UserID'];
                $_SESSION['username'] = $user_row['Username'];

                // Set a remember_me cookie
                setcookie('remember_me', $user_row['UserID'], time() + (30 * 24 * 60 * 60)); // 30 days expiration
    
                echo "<script>alert('Login successful!'); window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Incorrect password.');</script>";
            }
        } else {
            echo "<script>alert('User not found.');</script>";
        }
    }

    // Close the database connection
    $conn->close();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
    </head>

    <body>
        <div class="container">
            <form method="post" action="login.php">
                <div>
                    <h1>Login</h1>
                </div>
                <div class="fill">
                    <label for="email">Email:</label>
                    <input type="text" name="email" id="email" required>
                </div>
                <div class="fill">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="button">
                    <button type="submit">Login</button>
                    <a href="register.php">Register</a>
                </div>
                <div>
                    <a href="forgot.php">Forgot Password</a>
                </div>
            </form>
        </div>
    </body>

    </html>


</body>

</html>