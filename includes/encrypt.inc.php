<?php
    session_start(); // Start the session

    if(isset($_SESSION['user_id'])){ // Check if user is logged in
        if(isset($_POST['message_text']) && isset($_POST['main_key'])){ // Check if message text and main key are set in the POST request
            $new_mes_text = strtoupper($_POST['message_text']); // Convert message text to uppercase
            $new_key = strtoupper($_POST['main_key']); // Convert main key to uppercase

            if(!empty($new_mes_text) && !empty($new_key)){ // Check if message text and main key are not empty
                
                require_once 'mysql_users.inc.php'; // Include the file that contains the function create_encrypted_message()

                $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // Define the alphabet
                $encrypted_mes = ""; // Initialize the variable to store the encrypted message
                $key_index = 0; // Initialize the key index

                for($i = 0; $i < strlen($new_mes_text); $i++){ // Loop through each character in the message text
                    $current_char = $new_mes_text[$i]; // Get the current character

                    if(ctype_alpha($current_char)) { // Check if the current character is alphabetic
                        $shift = strpos($alphabet, $new_key[$key_index % strlen($new_key)]); // Get the shift value based on the key
                        $key_index++; // Increment the key index

                        $key_char_index = strpos($alphabet, $current_char); // Get the index of the current character in the alphabet
                        $encrypted_char_index = ($key_char_index + $shift) % strlen($alphabet); // Calculate the index of the encrypted character
                        
                        $encrypted_mes .= $alphabet[$encrypted_char_index]; // Append the encrypted character to the encrypted message
                    } 
                    else {
                        $encrypted_mes .= $current_char; // If the current character is not alphabetic, append it as is to the encrypted message
                    }
                }

                if(create_encrypted_message($conn, $_SESSION['user_id'], $encrypted_mes)){ // Call the function create_encrypted_message() to store the encrypted message in the database
                    $response = 0; // Set the response to 0 if the message was successfully stored
                }
                else{
                    $response = "Cant access data"; // Set the response to an error message if there was an issue accessing the data
                }
            }
            else{
                $response = "noData"; // Set the response to indicate that there is no data (empty message text or main key)     
            }
        }
        else{
            $response = "No POST"; // Set the response to indicate that there is no POST request
        }
    }
    else{
        $response = "noData"; // Set the response to indicate that there is no data (user not logged in)     
    }

    session_write_close(); // Close the session
    echo $response; // Output the response
?>