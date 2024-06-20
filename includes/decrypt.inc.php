<?php
    if(isset($_POST['key']) && isset($_POST['content'])){ // Check if 'key' and 'content' are set in the POST request
        $encrypted_mes = strtoupper($_POST['content']); // Convert the 'content' to uppercase
        $key = strtoupper($_POST['key']); // Convert the 'key' to uppercase
    
        if(!empty($encrypted_mes) && !empty($key)){ // Check if 'content' and 'key' are not empty
            $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // Define the alphabet
            $response = ""; // Initialize the response variable
            $key_length = strlen($key); // Get the length of the key
            $key_index = 0; // Initialize the key index
    
            for($i = 0; $i < strlen($encrypted_mes); $i++){ // Loop through each character in the encrypted message
                $current_char = $encrypted_mes[$i]; // Get the current character
    
                if(ctype_alpha($current_char)) { // Check if the current character is an alphabet character
                    $shift = strpos($alphabet, $key[$key_index % strlen($key)]); // Get the shift value based on the current key character
                    $key_index++; // Increment the key index
    
                    $key_char_index = strpos($alphabet, $current_char); // Get the index of the encrypted character in the alphabet
                    $decrypted_char_index = ($key_char_index - $shift + strlen($alphabet)) % strlen($alphabet); // Calculate the index of the decrypted character
                    
                    $response .= $alphabet[$decrypted_char_index]; // Append the decrypted character to the response
                } 
                else {
                    $response .= $current_char; // Append the non-alphabet character to the response
                }
            }
        }
        else{
            $response = "noData"; // Set the response to "noData" if 'content' or 'key' is empty     
        }
    }
    else{
        $response = "noData"; // Set the response to "noData" if 'key' or 'content' is not set     
    }
    
    echo $response; // Output the response
?>
