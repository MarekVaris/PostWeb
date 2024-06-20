<?php

    session_start(); // Start the session
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("location: ../template/login.php"); // Redirect the user to the login page

    exit(); // Exit the script

?>