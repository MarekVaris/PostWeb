<?php
    // Define the CSS stylesheets to be included in the page
    $style_content = "
    <link rel='stylesheet' href='../static/base_style.css'>
    ";
    
    $content_name = "Home";
    
    $content = "
        <div>
            <a id='info_text_main'>Welcome to PostsWeb</a>
        </div>
        <div>
            <p>Click <a href='posts.php'>here</a> to see Posts</p>
        </div>
        ";
    include("base.php");
?>