// Function to encrypt a message
function encryptMessage() {
    // Get the form data
    var formData = new FormData(document.getElementById('encryptForm'));
    
    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    
    // Open a POST request to the encrypt.inc.php file
    xhr.open('POST', '../includes/encrypt.inc.php', true);

    // Define what to do when the request is complete
    xhr.onload = function() {
        // Check if the request was successful
        if (xhr.status === 200) {
            // Check the response from the server
            if(xhr.responseText != 0){
                // Display an error message if the response is not 0
                displayErrorMessage(xhr.responseText);
            }
            else{
                // Redirect to the message.php page if the response is 0
                window.location.href = '../template/message.php';
            }
        } else {
            // Display an error message if the request was not successful
            displayErrorMessage(xhr.responseText);
        }
    };

    // Send the form data in the request
    xhr.send(formData);
}

// Function to decrypt a message
function decryptMessage(message_id, orginal_content) {
    // Get the key input and message content elements
    var keyInput = document.getElementById('main_key_input_' + message_id).value;
    var content = document.getElementById('mess_content_' + message_id);

    // Check if the key input is empty or null
    if(keyInput === '' || keyInput == null){
        // Display an error message if the key input is empty or null
        displayErrorMessage('noData');
        return;
    }
    
    // Create a new FormData object and append the key and content
    var formData = new FormData();
    formData.append('key', keyInput);
    formData.append('content', orginal_content);

    // Create a new XMLHttpRequest object
    var xhr = new XMLHttpRequest();
    
    // Open a POST request to the decrypt.inc.php file
    xhr.open('POST', '../includes/decrypt.inc.php', true);

    // Define what to do when the request is complete
    xhr.onload = function() {
        // Check if the request was successful
        if (xhr.status === 200) {
            // Check the response from the server
            if(xhr.responseText !== 'noData'){
                // Update the message content with the decrypted content
                content.innerHTML = xhr.responseText;
            }
            else{
                // Display an error message if the response is 'noData'
                displayErrorMessage(xhr.responseText);
            }
        } else {
            // Display an error message if the request was not successful
            displayErrorMessage(xhr.responseText);
        }
    };

    // Send the form data in the request
    xhr.send(formData);
}

// Get the main key input element
const mainKeyInput = document.getElementById('main_key_input');

// Check if the main key input element exists
if (mainKeyInput) {
    // Add a keydown event listener to the main key input element
    mainKeyInput.addEventListener('keydown', function(event) {
        // Check if the Enter key was pressed
        if (event.key === 'Enter') {
            // Call the encryptMessage function
            encryptMessage();
        }
    });
}
