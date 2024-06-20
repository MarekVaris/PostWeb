<?php

    if(isset($_POST['submit'])){ // Check if the form is submitted
        $username = $_POST['login_username']; // Get the username from the form
        $password = $_POST['login_password']; // Get the password from the form

        if(!empty($username) && !empty($password)){ // Check if both username and password are not empty
            
            require_once 'mysql_users.inc.php'; // Include the file that contains the function to retrieve user data from the database
            if($row = get_user($conn,$username,$password)){ // Call the function to get user data and check if it returns a row
                session_start(); // Start a new session
                echo($row['id']); // Output the user ID (for testing purposes)
                $_SESSION['user_id'] = $row['id']; // Store the user ID in the session
                $_SESSION['user_name'] = $row['userName']; // Store the username in the session

                header("location: ../template/posts.php"); // Redirect the user to the posts page
                exit(); // Stop executing the rest of the code
            }
            else{
                header("location: ../template/login.php?error=wrongData"); // Redirect the user to the login page with an error message
                exit(); // Stop executing the rest of the code
            }
            
        }
        else{
            header("location: ../template/login.php?error=noData"); // Redirect the user to the login page with an error message
            exit(); // Stop executing the rest of the code
        }
    }
    else{
        header("location: ../template/login.php?error=noPost"); // Redirect the user to the login page with an error message
        exit(); // Stop executing the rest of the code
    }
    header("location: ../template/login.php?error=cantLogin"); // Redirect the user to the login page with an error message

?>
