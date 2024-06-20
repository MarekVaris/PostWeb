<?php
    session_start();

    require_once 'mysql_users.inc.php';

    // Delete the user's profile using the delete_user_by function from mysql_users.inc.php
    if (delete_user_by($conn, $_SESSION['user_id'])) {
        session_write_close();
        header('Location: ../includes/logout.inc.php');
        exit;
    }

    exit;
?>