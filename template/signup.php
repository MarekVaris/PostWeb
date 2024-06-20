<?php
    // Define the CSS styles to be included
    $style_content = "
    <link rel='stylesheet' href='../static/base_style.css'>
    <link rel='stylesheet' href='../static/login_style.css'>
    ";

    // Set the name of the content
    $content_name = "Sign Up";
    
    // Define the HTML content for the sign up form
    $content = "
        <div class='login_box'>
            <form action='../includes/signup.inc.php' method='POST'>
                <div>
                    <label for='username'>Username:</label><br>
                    <input type='text' class='login_input_holder' name='new_username' id='login_in'><br>
                </div>
                <div>
                    <label for='password'>Password:</label><br>
                    <input type='password' class='login_input_holder' name='create_password'><br>
                </div>
                <div>
                    <label for='password_check'>Password Again:</label><br>
                    <input type='password' class='login_input_holder' name='create_password_check'><br>
                </div>
                <input id='create_login' class='login_box_button' name='submit' type='submit' value='Sign Up'>
            </form>
        </div>
    ";
    
    // Include the base template file
    include("base.php");
?>