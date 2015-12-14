function $(string) {                                    //Shortcut function to get the element by id
    "use strict";
    
    return document.getElementById(string);
}

function d_to_r(deg) {
    "use strict";
    var e, d;
    
    $("rad").value = " ";                               //Clear the other textbox while typing
    e = event.key || event.keyCode;                     //Apparently some browsers don't support event.keyCode
    if (e === 13) {                                     //Only preform calculations after the user has pressed "Enter"
        if (!isNaN(deg.value)) {                        //... and if the input is valid
            d = deg.value * (3.141592 / 180);
            $("rad").value = d.toFixed(4);
        } else {
            window.alert("Invalid input. Please enter a number.");
        }
    }
}

function r_to_d(rad) {
    "use strict";
    var e, r;
    
    $("deg").value = " ";                               //Clear the other textbox while typing
    e = event.key || event.keyCode;
    if (e === 13) {                                     //Only preform calculations after the user has pressed "Enter"
        if (!isNaN(rad.value)) {                        //... and if the input is valid
            r = rad.value * (180 / 3.141592);
            $("deg").value = r.toFixed(4);
        } else {
            window.alert("Invalid input. Please enter a number.");
        }
    }
}