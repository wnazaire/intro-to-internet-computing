$(function () {
    "use strict";
    
    var upload = document.getElementById('image'); 
    
    function validateImage(e) {
        return (e.trim() === "") ? "No image selected." : "";
    }

    function validateTitle(e) {
        return (e.trim() === "") ? "Missing post title." : "";
    }

    function validateText(e) {
        return (e.trim() === "") ? "Missing post comment. I know you have something to say." : "";
    }
    
    upload.on('submit', function (form) {
        var fail = validateImage(form.image.value);
        fail += validateImage(form.title.value);
        fail += validateImage(form.text.value);

        if (fail === "") {
            return true;
        } else {
            document.alert(fail);
            return false;
        }
    }
});