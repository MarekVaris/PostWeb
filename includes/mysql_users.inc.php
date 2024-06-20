<?php
    /**
     * This file contains functions related to MySQL database operations for user management.
     */

    // Database connection parameters
    $mysql_servername = "localhost"; 
    $mysql_username = "root";
    $mysql_password = "";
    $mysql_database = "postweb";

    // Establish database connection
    $conn = mysqli_connect($mysql_servername, $mysql_username, $mysql_password, $mysql_database); 
    if(!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    /**
     * Executes a prepared statement and returns the result.
     * 
     * @param mysqli_stmt $stmt The prepared statement to execute.
     * @return mixed The result of the executed statement, or false if no result.
     */
    function execute($stmt){
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }

        return false;
    }

    /**
     * Creates a new user account in the database.
     * 
     * @param mysqli $conn The database connection.
     * @param string $new_userName The username of the new user.
     * @param string $new_password The password of the new user.
     * @return bool True if the account is created successfully, false otherwise.
     */
    function create_account($conn, $new_userName, $new_password){
        $sql = "INSERT INTO users (userName, paswd) VALUES ('$new_userName', '$new_password');";
        
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../template/signup.php?error=dataerror");
            exit();
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return true;
    }

    /**
     * Retrieves a user from the database based on the username and password.
     * 
     * @param mysqli $conn The database connection.
     * @param string $user_get The username of the user.
     * @param string $pass_get The password of the user.
     * @return mixed The user data if found, false otherwise.
     */
    function get_user($conn, $user_get, $pass_get){
        $sql = "SELECT * FROM users WHERE userName = '$user_get' AND paswd = '$pass_get';";
        
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../template/login.php?error=dataError");
            exit();
        }

        return execute($stmt);
    }

    /**
     * Retrieves a user from the database based on the user ID or username.
     * 
     * @param mysqli $conn The database connection.
     * @param mixed $userValues The user ID or username.
     * @return mixed The user data if found, false otherwise.
     */
    function get_user_by($conn, $userValues = null){
        $id = null;
        $username = null;

        if ($userValues !== null && $userValues !== "") {
            if (is_numeric($userValues)) {
                $id = $userValues;
            } 
            else {
                $username = $userValues;
            }
        }
        $sql = "SELECT * FROM users WHERE id = ? OR userName = ?";

        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../template/profile.php?error=dataError");
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "is", $id, $username);
        return execute($stmt);
    }

    /**
     * Deletes a user and their associated posts and messages from the database.
     * 
     * @param mysqli $conn The database connection.
     * @param int $userId The ID of the user to delete.
     * @return bool True if the user is deleted successfully, false otherwise.
     */
    function delete_user_by($conn, $userId){
        $sql_delete_posts = "DELETE FROM posts WHERE user_id = $userId";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql_delete_posts)){
            return false;
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        $sql_delete_messages = "DELETE FROM messages WHERE user_id = $userId";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql_delete_messages)){
            return false;
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        $sql_delete_user = "DELETE FROM users WHERE id = $userId";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql_delete_user)){
            return false;
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        return true;
    }

    /**
     * Retrieves all posts from the database.
     * 
     * @param mysqli $conn The database connection.
     * @return mixed An array of posts if found, false otherwise.
     */
    function get_posts($conn){
        $sql = "SELECT p.id, user_id, content, userName, likes FROM posts p INNER JOIN users u ON p.user_id = u.id ORDER BY upload_date DESC;";
        
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../template/posts.php?error=dataError");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        while ($row = mysqli_fetch_assoc($resultData)) {
            $rows[] = $row;
        }
        if(!empty($rows)){
            return $rows;
        }

        return false;
    }

    /**
     * Creates a new post in the database.
     * 
     * @param mysqli $conn The database connection.
     * @param string $new_post_content The content of the new post.
     * @return bool True if the post is created successfully, false otherwise.
     */
    function create_post($conn, $new_post_content){
        $sql = "INSERT INTO posts (user_id, content, likes) VALUES ({$_SESSION['user_id']}, '$new_post_content', 0);";

        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../template/posts.php?error=dataError");
            exit();
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    
        return true;
    }

    /**
     * Deletes a post from the database.
     * 
     * @param mysqli $conn The database connection.
     * @param int $post_id_dell The ID of the post to delete.
     * @return mixed 0 if the post is deleted successfully, or an error message if deletion fails.
     */
    function delete_post($conn, $post_id_dell){
        $sql_update = "DELETE FROM posts WHERE id = $post_id_dell";

        $stmt_update = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_update, $sql_update)) {
            return 'Cant access data';
        }
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
        
        $sql_insert = "DELETE FROM liked_posts WHERE likedPost_id = $post_id_dell";
        $stmt_insert = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
            return 'Cant access data';
        }
        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);
        
        return 0;
    }

    /**
     * Likes a post by incrementing the likes count and adding a record to the liked_posts table.
     * 
     * @param mysqli $conn The database connection.
     * @param int $user_id_like The ID of the user who likes the post.
     * @param int $post_id_like The ID of the post to like.
     * @return mixed 'Added like' if the post is liked successfully, or an error message if liking fails.
     */
    function like_post_by($conn, $user_id_like, $post_id_like) {
        $sql_update = "UPDATE posts SET likes = likes + 1 WHERE id = $post_id_like";
        
        $stmt_update = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_update, $sql_update)) {
            return 'Cant access data';
        }
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
        
        $sql_insert = "INSERT INTO liked_posts (user_id, likedPost_id) VALUES ($user_id_like, $post_id_like)";
        $stmt_insert = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
            return 'Cant access data';
        }
        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);
        
        return 'Added like';
    }

    /**
     * Dislikes a post by decrementing the likes count and removing the record from the liked_posts table.
     * 
     * @param mysqli $conn The database connection.
     * @param int $user_id_like The ID of the user who dislikes the post.
     * @param int $post_id_like The ID of the post to dislike.
     * @return mixed 'Disliked' if the post is disliked successfully, or an error message if disliking fails.
     */
    function dislike_post_by($conn, $user_id_like, $post_id_like) {
        $sql_update = "UPDATE posts SET likes = likes - 1 WHERE id = $post_id_like";
    
        $stmt_update = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_update, $sql_update)) {
            return 'Cant access data';
        }
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
        
        $sql_insert = "DELETE FROM liked_posts WHERE user_id = $user_id_like AND likedPost_id = $post_id_like;";
        $stmt_insert = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
            return 'Cant access data';
        }
        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);
        
        return 'Disliked';
    }

    /**
     * Retrieves the list of posts liked by a user.
     * 
     * @param mysqli $conn The database connection.
     * @param int $look_user_id The ID of the user to retrieve liked posts for.
     * @return array An array of liked post IDs.
     */
    function liked_post_list($conn, $look_user_id) {
        $sql = "SELECT likedPost_id FROM liked_posts WHERE user_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $look_user_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);            
            mysqli_stmt_close($stmt);
    
            if ($result) {
                return mysqli_fetch_all($result, MYSQLI_ASSOC);
            } 
        }
        return [];
    }

    /**
     * Creates a new encrypted message in the database.
     * 
     * @param mysqli $conn The database connection.
     * @param int $user_id The ID of the user who sent the message.
     * @param string $new_mes_text The original text of the message.
     * @param string $encrypted_mes The encrypted text of the message.
     * @param string $new_key The encryption key used for the message.
     * @return bool True if the message is created successfully, false otherwise.
     */
    function create_encrypted_message($conn, $user_id, $encrypted_mes){
        $sql = "INSERT INTO messages (user_id, encrypted_text) VALUES ('$user_id', '$encrypted_mes')";

        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            return false;
            exit();
        }
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return true;
    }

    /**
     * Retrieves all messages from the database.
     * 
     * @param mysqli $conn The database connection.
     * @return mixed An array of messages if found, false otherwise.
     */
    function get_messages($conn){
        $sql = "SELECT m.id, encrypted_text, userName FROM messages m INNER JOIN users u ON m.user_id = u.id ORDER BY created_at DESC;";
        
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../template/posts.php?error=dataError");
            exit();
        }
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);

        while ($row = mysqli_fetch_assoc($resultData)) {
            $rows[] = $row;
        }
        if(!empty($rows)){
            return $rows;
        }

        return false;
    }
    
?>
