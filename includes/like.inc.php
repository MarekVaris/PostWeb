<?php    
    session_start(); // Start the session
    
    // Check if the button is clicked, post_id is set, and user_id is set
    if (isset($_POST['button_clicked']) && isset($_POST['post_id']) && isset($_SESSION['user_id'])) {
        require_once 'mysql_users.inc.php'; // Include the file that contains the MySQL functions
        
        $post_id_js = $_POST['post_id']; // Get the post_id from the POST data
        $user_id_js = $_SESSION['user_id']; // Get the user_id from the session data    
        
        // Check if the dislike parameter is set to true
        if($_POST['dislike'] === 'true'){
            $response = dislike_post_by($conn, $user_id_js, $post_id_js); // Call the dislike_post_by function
        }
        else{
            $response = like_post_by($conn, $user_id_js, $post_id_js); // Call the like_post_by function
        }
    } 
    // If user_id is not set in the session
    else if(!isset($_SESSION['user_id'])) {
        $response = 'login'; // Set the response to 'login'
    }
    
    session_write_close(); // Close the session
    echo $response; // Output the response
?>