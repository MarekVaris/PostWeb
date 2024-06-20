<?php
    require_once '../includes/mysql_users.inc.php';

    $style_content = "
    <link rel='stylesheet' href='../static/base_style.css'>
    <link rel='stylesheet' href='../static/message_style.css'>
    ";
    
    $content_name = "Special";

    session_start();
    if(isset($_SESSION['user_name'])){
        // If user is logged in, display the message creation form
        $content = "
        <div id='main_mess_box'>
            <div class='encrypt_box'>
                <form id='encryptForm'>
                    <div>
                        <label class='label_mess' for='message_text'>Text to Encrypt</label>
                        <textarea class='mess_input decrypt_text_input' id='message_text_input' name='message_text'></textarea>
                    </div>
                    <div>    
                        <label class='label_mess' for='main_key'>Key Phrase:</label>
                        <input type='text' class='mess_input decrypt_text_input' id='main_key_input' name='main_key' maxlength='255'>
                        <button type='button' class='mess_button' id='new_mess_button' onclick='encryptMessage()'>Encrypt</button>
                    </div>
                </form>
            </div>
        ";
    }
    else{
        // If user is not logged in, display a message to prompt login
        $content = "
        <div id='main_mess_box'>
            <div class='encrypt_box'>
                <p class='label_mess' for='box_info'><a href='../template/login.php'>Login in</a> to create new message</p>
            </div>
        ";
    }

    if($rows = get_messages($conn)){
        // If there are messages in the database, display them
        foreach ($rows as $row) {
            $content_text = htmlspecialchars($row['encrypted_text']);
            $encrypted_text = $row['encrypted_text'];
            $content .= "
                <div id='info_box' class='encrypt_box'>
                    <div class='mess_box_header'>
                        <p id='label_info_name' class='label_mess'>{$row['userName']}</p>
                    </div>
                    <div class='mess_box_footer'>
                        <p id='mess_content_{$row['id']}' class='mess_content'>$content_text</p>
                        <div>
                            <input type='text' class='mess_input encrypt_key_input' id='main_key_input_{$row['id']}' name='main_key' maxlength='255'>
                            <button type='button' class='mess_button' id='decrypt_mess_button' onclick='decryptMessage({$row['id']}, \"$encrypted_text\")'>Decrypt</button>
                            </div>
                    </div>
                </div>
            ";
        }
        $content .= "
            
        </div>";
    }
    else{
        // If no messages are found, display a message indicating that
        $content .= "
        </div>
        <p>No posts found</p>
        ";
    }
    

    $content .= "
        <script src='../javas/message.js'></script>
    </div>";
    session_write_close();
    include("base.php");
?>