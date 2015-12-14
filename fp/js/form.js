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
    
    upload.on('submit', function () {
        var fail = validateImage(this.image.value);
        fail += validateImage(this.title.value);
        fail += validateImage(this.text.value);

        if (fail === "") {
            document.forms["post"].submit();
            return true;
        } else {
            document.alert(fail);
            return false;
        }
    });
});