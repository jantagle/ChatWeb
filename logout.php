<?php
    session_start(); // Start the session

    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Remove the remember_me cookie if set
    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 3600); // Set the expiration time in the past
    }

    echo "<script>alert('Logout Successfully.'); window.location.href = 'login.php';</script>";

    exit;
?>
