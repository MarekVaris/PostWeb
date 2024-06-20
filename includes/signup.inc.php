<?php

    if(isset($_POST["submit"])){
        
        // Get the username and password from the form
        $username = $_POST['new_username'];
        $password = $_POST['create_password'];
        $password_check = $_POST['create_password_check'];

        // Include the file that contains the database connection code
        require_once 'mysql_users.inc.php';

        if(!empty($username) && !empty($password) && !empty($password_check)){
            
            // Check if the password and password check match
            if($password === $password_check){
                // Create the user account in the database
                if(get_user_by($conn, $username)){
                    // Redirect to the signup page with an error message if the username is already taken
                    header("location: ../template/signup.php?error=userExists");
                    exit();
                }

                if(create_account($conn, $username, $password)){
                    // Redirect to the login page if the account is created successfully
                    header("location: ../template/login.php");
                    exit();    
                }
                // Redirect to the signup page with an error message if the account creation fails
                header("location: ../template/signup.php?error=cantCreate");
                exit();
            }
            else{
                // Redirect to the signup page with an error message if the passwords don't match
                header("location: ../template/signup.php?error=wrongPass");
                exit();
            }
        }
        else{
            // Redirect to the signup page with an error message if any of the fields are empty
            header("location: ../template/signup.php?error=noData");
            exit();
        }
    }
    else{
        // Redirect to the signup page with an error message if the form is not submitted
        header("location: ../template/signup.php?error=noPost");
        exit();
    }

?>