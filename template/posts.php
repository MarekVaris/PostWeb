<?php
    // Include the file that contains the MySQL connection and user-related functions
    require_once '../includes/mysql_users.inc.php';
    
    // Define the CSS styles for the page
    $style_content = "
        <link rel='stylesheet' href='../static/base_style.css'>
        <link rel='stylesheet' href='../static/posts_style.css'>
    ";
    
    // Set the name of the content
    $content_name = "Posts";
    
    // Start the session
    session_start();
    
    // Check if the user is logged in
    if(isset($_SESSION['user_name'])){
        // If the user is logged in, display the create post form
        $content = "
            <div id='main_post_box'>
                <div class='post_box'>
                    <form id='create_post_form' action='../includes/create_post.inc.php' method='POST'>
                        <label class='post_box_title' for='box_info'>Create New Post</label>
                        <textarea  class='post_content' id='create_post_textinput' type='text' name='post_content'></textarea>
                        <div class='post_likes_info'>
                            <button id='create_post_button' class='post_button' name='submit' type='submit'>Send!</button>
                        </div>    
                    </form>
                </div>
        "; 
    }
    else{
        // If the user is not logged in, display a message to login
        $content = "
        <div id='main_post_box'>
            <div class='post_box'>
                <p class='post_box_title' for='box_info'><a href='../template/login.php'>Login in</a> to create new post</p>
            </div>
        "; 
    }
    
    // Get the posts from the database
    if($rows = get_posts($conn)){
        // Check if the user is logged in
        if(isset($_SESSION['user_id'])){
            // Get the list of liked posts for the logged in user
            $liked_posts = liked_post_list($conn, $_SESSION['user_id']);
        }

        // Loop through each post and display them
        foreach ($rows as $row) {
            // Set the default like button text
            $like_button_text = "<button id='like_button_{$row['id']}' class='post_button' onclick='like_post({$row['id']})' type='button'>Like</button>";
            // Set the default delete button
            $dell_button = '';
            
            // Check if the user has liked the post
            if(isset($_SESSION['user_id']) && in_array($row['id'], array_column($liked_posts, 'likedPost_id'))) {
                // If the user has liked the post, change the like button text to "Dislike"
                $like_button_text = "<button id='like_button_{$row['id']}' class='post_button' onclick='like_post({$row['id']}, true)' type='button'>Dislike</button>";
            }
            
            // Check if the user is the owner of the post
            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] === $row['user_id']){
                // If the user is the owner of the post, display the delete button
                $dell_button = "<button id='post_box_dell_button' class='post_button' onclick='delete_post({$row['id']}, this)'>Dell</button>";
            }
            
            // Escape special characters in the post content
            $content_text = htmlspecialchars($row['content']);
            
            // Append the post HTML to the content variable
            $content .= "
                <div class='post_box'>
                    <div class='post_box_header'>
                        <p class='post_box_title'>{$row['userName']}</p>
                        $dell_button
                    </div>
                    <p class='post_content'>$content_text</p>
                    <div class='post_likes_info'>
                        <p id='likes_{$row['id']}'>Likes: {$row['likes']}</p>
                        $like_button_text
                    </div>
                </div>
            ";
        }
        
        // Append the JavaScript file for handling post actions
        $content .= "
            <script src='../javas/post.js'></script>
        </div>";
    }
    else{
        // If no posts are found, display a message
        $content .= "
        </div>
        <p>No posts found</p>
        ";
    }
    
    // Close the session
    session_write_close();
    
    // Include the base template file
    include("base.php");
?>