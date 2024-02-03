<?php
    session_start(); // Start the session

    function checkSession() {
        if (!isset($_SESSION['user_id'])) {
            // If the user is not logged in, redirect to the login page
            header("Location: login.php");
            exit;
        }
    }

    // Call the checkSession function at the beginning of pages where you want to restrict access
    checkSession();
?>
