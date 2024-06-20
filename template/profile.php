<?php
    // Include the file that contains the necessary functions for interacting with the MySQL database
    require_once '../includes/mysql_users.inc.php';

    // Define the CSS stylesheets to be included in the page
    $style_content = "
    <link rel='stylesheet' href='../static/base_style.css'>
    <link rel='stylesheet' href='../static/profile_style.css'>
    ";

    // Set the name of the content to be displayed in the page
    $content_name = "Profile";
   

    $content = "
        <div>
            <form>
                <label>Search for a user</label><br>
                <input style='border-radius: 5px; border: none; font-family: Cursive;' type='text' name='login' placeholder='Enter username'>
                <button style='border-radius: 5px; border: none; font-family: Cursive; background-color: #007bff; color: #fff; cursor: pointer;' type='submit'>Search</button>
            </form>
        </div>
    ";

    // Check if the 'login' parameter is set in the URL
    if(isset($_GET['login'])){
        // Get the user details from the database based on the 'login' parameter
        if($row = get_user_by($conn, $_GET['login'])){
            // Update the content name with the user's name
            $content_name = $row['userName'];

            // Update the content to display the user's profile information
            $content .= "
            <div id='profile_content'>
                <div>
                    <p id='welcome_profile'>Welcome to <a>$content_name</a> profile</p>
                </div>
            ";

            // Start a session to check if the logged-in user is viewing their own profile
            session_start();
            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] === $row['id']){
                // If the logged-in user is viewing their own profile, display a delete profile button
                $content .="
                    <button id='delete_button_profile' onclick='deleteProfile()'>Delete Profile</button>
                ";
            }
            session_write_close();

            // Add a JavaScript function to handle the delete profile button click event
            $content .="
                <script>
                    function deleteProfile(){
                        if(confirm('Are you sure you want to delete your profile?')){
                            window.location.href = '../includes/delete_profile.inc.php';
                        }
                    }
                </script>
            </div>
            ";
        }
        else{
            // Set the default content to be displayed if the user is not found
            $content .= "
            <div>
                <p id='info_text_main'>User Not Found</p>
            </div>
            ";
        }
    }
    
    // Include the base.php file, which contains the common HTML structure for the page
    include("base.php");
?>