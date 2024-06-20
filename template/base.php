<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo $style_content; ?>
    <script src='../javas/error_info.js'></script>
    <title><?php echo $content_name; ?></title>
</head>
<body>
    <header>
        <div>
            <a href="home.php">Home</a>
            <a href="posts.php">Posts</a>
            <a href="message.php">Message</a>
        </div>
        <div>
            <h1><?php echo $content_name; ?></h1>
        </div>
        <div>
            <?php
                if(isset($_SESSION['user_name'])){ // Check if user is logged in
                    echo "<a href='profile.php?login={$_SESSION['user_id']}'>" . $_SESSION['user_name'] . "</a>";
                    echo "<a href='../includes/logout.inc.php'>Logout</a>"; 
                }
                else{
                    echo "<a href='login.php'>Login</a>"; 
                    echo "<a href='signup.php'>Sign Up</a>";
                }
            ?>
            <img id="logo_img" src="../img/logo.png" alt="logo">
        </div>
    </header>
    <main>
        <?php echo $content; ?>
    </main>
    <footer>
        <div>
            <p>Created by: Me</p>
        </div>
        <div>
            <p>Some info</p>
        </div>
    </footer>
</body>
</html>