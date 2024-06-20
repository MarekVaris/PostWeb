// Function to get the value of a URL parameter
function getUrlParameter(name) {
    var regex = new RegExp('[?]' + name + '=([^&?]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1]);
}

// Function to display an error message
function displayErrorMessage(custom_error) {
    var error = getUrlParameter('error');
    if (custom_error !== '') {
        error = custom_error;
    }
    if (error !== '') {
        // Create a container for the error message
        var errorMessageContainer = document.createElement('div');
        errorMessageContainer.classList.add('info_error');
        
        // Create a paragraph element to display the error message
        var errorMessage = document.createElement('p');
        if (error === 'noData') {
            errorMessage.textContent = 'Fill all the spaces';
        } 
        else if (error === 'dataerror') {
            errorMessage.textContent = 'Failed to connect with data';
        } 
        else if (error === 'wrongPass') {
            errorMessage.textContent = 'Wrong password';
        } 
        else if (error === 'wrongData') {
            errorMessage.textContent = 'Wrong username or password';
        } 
        else if (error === 'cantCreate') {
            errorMessage.textContent = 'Cant create';
        } 
        else {
            errorMessage.textContent = error;
        }
        
        // Create a close button to remove the error message container
        var closeButton = document.createElement('button');
        closeButton.textContent = 'X';
        closeButton.addEventListener('click', function() {
            errorMessageContainer.remove();
        });
        
        // Append the error message and close button to the container
        errorMessageContainer.appendChild(errorMessage);
        errorMessageContainer.appendChild(closeButton);
        
        // Append the container to the body of the document
        document.body.appendChild(errorMessageContainer);
    }
}

// Call the displayErrorMessage function when the window loads
window.onload = function() {
    displayErrorMessage('');
};
