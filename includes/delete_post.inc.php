<?php

    session_start();

    // Check if the button is clicked, post_id is set, and user_id is set in the session
    if (isset($_POST['button_clicked']) && isset($_POST['post_id']) && isset($_SESSION['user_id'])) {        
        require_once '../includes/mysql_users.inc.php';
        $response = delete_post($conn, $_POST['post_id']);
    } 
    else {
        $response = "error";
    }

    session_write_close();
    
    // Output the response
    echo $response;
?>