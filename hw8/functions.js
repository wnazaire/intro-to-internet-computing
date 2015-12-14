var upload = document.getElementById('upload');
var image = document.getElementById('image');
var filterAccess = document.getElementById('tempFilter');

function uploadImage(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        
        reader.onload = function (e) {
            image.setAttribute('src', e.target.result);
        }

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

function submit()
{
     // Read values from form
    var title = document.getElementById("title").value;
    var text = document.getElementById("text").value;
    
    // Save filtered image in a variable
    var filteredImage = image;

    // Manipulate DOM:
    // 1. Clean up (remove) old stuff
    var parent = form.parentElement;
    while (form.firstChild) {
        form.removeChild(form.firstChild);
    }
        
    // 2. Make room for new stuff: formatted title & text + filtered image
    parent.innerHTML = '<h2>' + title + '</h2><p>' + text + '</p>';
    parent.appendChild(filteredImage);   
};