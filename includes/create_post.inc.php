<?php
    session_start(); // Start the session
    
    // Check if the form is submitted and the user is logged in
    if(isset($_POST["submit"]) && isset($_SESSION['user_id'])){        
        $new_post_content = $_POST['post_content']; // Get the content of the new post
        
        if(!empty($new_post_content)){ // Check if the post content is not empty

            require_once 'mysql_users.inc.php'; // Include the file that contains the database connection
            
            // Call the create_post function and pass the database connection and post content
            if(create_post($conn, $new_post_content)){
                header("location: ../template/posts.php"); // Redirect to the posts page if the post is created successfully
            }
            else{
                header("location: ../template/posts.php?error=cantCreate"); // Redirect to the posts page with an error message if the post creation fails
            }
        }
        else{
            header("location: ../template/posts.php?error=noData"); // Redirect to the posts page with an error message if the post content is empty
        }
    }
    else{
        header("location: ../template/posts.php?error=noPost"); // Redirect to the posts page with an error message if the form is not submitted or the user is not logged in
    }
    
    session_write_close(); // Close the session
    exit(); // Exit the script
?>