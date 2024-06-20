<?php
    // Define the CSS stylesheets to be included in the page
    $style_content = "
    <link rel='stylesheet' href='../static/base_style.css'>
    <link rel='stylesheet' href='../static/login_style.css'>
    ";

    $content_name = "Login";

    $content = "
        <div class='login_box'>
            <form action='../includes/login.inc.php' method='POST'>
                <div>
                    <label for='username'>Username:</label><br>
                    <input type='text' class='login_input_holder' name='login_username' id='login_in'><br>
                </div>
                <div>
                    <label for='password'>Password:</label><br>
                    <input type='password' class='login_input_holder' name='login_password' id='passowrd_in'><br>
                </div>
                <input id='login_button' class='login_box_button' name='submit' type='submit' value='Login'>
            </form>
        </div>
    ";
    include("base.php");
?>