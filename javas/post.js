/**
 * Sends a request to like or dislike a post.
 * @param {number} post_id - The ID of the post to like or dislike.
 * @param {boolean} [dislike=false] - Indicates whether to dislike the post. Default is false.
 */

function like_post(post_id, dislike = false) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../includes/like.inc.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                if (xhr.responseText === 'no') {
                    console.log('Error: ' + xhr.responseText);
                }
                else if(xhr.responseText === 'login'){
                    displayErrorMessage("Login in to like posts");
                    console.log('Error: ' + xhr.responseText);
                }
                else{
                    var button = document.getElementById('like_button_' + post_id);
                    var likes = document.getElementById('likes_' + post_id);
                    var likesCount = parseInt(likes.textContent.match(/\d+/));
                    if (dislike) {
                        button.innerHTML = 'Like';
                        button.setAttribute('onclick', 'like_post(' + post_id + ', false)');
                        likes.textContent = 'Likes: ' + (likesCount - 1); 
                    } else {
                        button.innerHTML = 'Dislike';
                        button.setAttribute('onclick', 'like_post(' + post_id + ', true)');
                        likes.textContent = 'Likes: ' + (likesCount + 1);
                    }
                } 
            } 
        }
    };
    xhr.send('button_clicked=true&post_id=' + post_id + '&dislike=' + dislike);
}

function delete_post(post_id, button){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../includes/delete_post.inc.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                if(xhr.responseText == 0){
                    var parent = button.parentNode.parentNode;
                    parent.parentNode.removeChild(parent);
                }
            }                 
            else {
                displayErrorMessage("Cant access data.");
            }
        }
    };
    xhr.send('button_clicked=true&post_id=' + post_id);
}
