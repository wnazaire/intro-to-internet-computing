var upload = document.getElementById('upload');
var image = document.getElementById('image');
var filterAccess = document.getElementById('tempFilter');

var originalImage = "./img/placeholder.png";

function uploadImage(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            image.setAttribute('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
};

$("#upload").change(function(){
    uploadImage(this);
});

function applyNostalgiaFilter() 
{   
    var filter = 'saturate(40%) grayscale(100%) contrast(45%) sepia(100%)';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
    filterAccess.value = filter + ";";
};

function applyGrayscaleFilter() 
{   
    var filter = 'grayscale(100%)';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
    filterAccess.value = filter + ";";
};

function applyInvertFilter() 
{   
    var filter = 'invert(1)';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
    filterAccess.value = filter + ";";
};

function applyBlurFilter() 
{   
    var filter = 'blur(2px)';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
    filterAccess.value = filter + ";";
};

function revertToOriginal() 
{   
    var filter = '';
    image.style.filter = filter;
    image.style.webkitFilter = filter;
    filterAccess.value = filter;
};
                                                //Confirm that the admin wants to delete a particular post
$("#content").on('click', '#remove_post', function () {
    if (confirm("Do you really want to delete this post")) {
        document.forms[this.value].submit();
    }
});
                                                //Confirm that the admin wants to delete a particular user
$("#content").on('click', '#remove_user', function () {
    if (confirm("Do you really want to remove this user?")) {
        document.forms[this.value].submit();
    }
});

function validateImage(e) {
    var input = e.trim();
    
    if (input === "" || input === originalImage) {
       return "No image selected.\n";
    }
    if (input.indexOf("data:image") !== 0)
    {
        return "Type of file selected is not an image.\n";
    }
    return "";
};

function validateTitle(e) {
    return (e.trim() === "") ? "Missing post title.\n" : "";
};

function validateText(e) {
    return (e.trim() === "") ? "Missing post comment.\n" : "";
};

function validatePost() {
    var title = document.getElementById('title');
    var text= document.getElementById('text');
    
    var fail = validateImage(image.getAttribute('src'));
    fail += validateTitle(title.value);
    fail += validateText(text.value);
    
    if (fail === "") {
        document.forms["post2wall"].submit();
        return true;
    } else {
        alert(fail);
        return false;
    }
};

$("#submitPost").on('click', function() {                                       //Hack. Prevents displaying of error message on page load
    validatePost();
});


$(document).on('keydown', '#post2wall', function(event){                        //Prevent form submission on enter if invalid
    if((event.which == 13) && (validatePost() === false)) {
        event.preventDefault();
        return false;
    }
});

function validateUsername(e) {
    var input = e.trim();
    
    if (input === "") {
       return "Missing username";
    }
    if (input.indexOf("\"") > -1 || input.indexOf("\'") > -1)
    {
        return "Quotes (of any kind) aren't allowed in usernames.\n";
    }
    if (input.indexOf(":") > -1 || input.indexOf(";") > -1 || input.indexOf("/") > -1)
    {
        return "The characters : ; / aren't allowed in usernames.\n";
    }
    
    return "";
};

function validatePass(pass, passver) {
    p = pass.trim();
    pv = passver.trim();
    
    if (p === ""){
        return "Blank password.\n";
    }
    if (pv === ""){
        return "Password not verified.\n";
    }
    if (p !== pv) {
        return "Passwords don't match.\n";
    }
    
    return "";
};

function validateSignup() {
    var un = document.getElementById('user');
    var pass = document.getElementById('pass');
    var passver = document.getElementById('passver');
    
    var fail = validateUsername(un.value);
    fail += validatePass(pass.value, passver.value);
    
    if (fail === "") {
        document.forms["signupUser"].submit();
        return true;
    } else {
        alert(fail);
        return false;
    }
};

$("#signup").on('click', function() {
    validateSignup();
});

$(document).on('keydown', '#signupUser', function(event){                        //Prevent form submission on enter if invalid
    if((event.which == 13) && (validateSignup() === false)) {
        event.preventDefault();
        return false;
    }
});

function validateComment()
{
    var comment = document.getElementById('commentText');
    var post_id = document.getElementById('post_name');
    
    var fail = validateCommentText(comment.value);
    
    if (fail === "") {
        $.post("./php/add_comment.php", { text: comment.value, id: post_id.value },
        function(data){
            if (data != ""){
                alert(data);
            } else {
                comment.value = "";
                location.reload();
            }
        });
        return true;
    } else {
        alert(fail);
        return false;
    }
};

function validateCommentText(e) {
    return (e.trim() === "") ? "Blank comment.\n" : "";
};

$("#submitComment").on('click', function() {
    validateComment();
});