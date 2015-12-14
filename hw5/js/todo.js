$(function () {
    "use strict";
    
    // SETUP
    var $list, $newItemForm, $newItemButton, $clearListButton, $edit, item, ESC, ENTER;
    item = '';                                      // item is an empty string
    $list = $('ul');                                // Cache the unordered list
    $newItemForm = $('#newItemForm');               // Cache form to add new items
    $newItemButton = $('#newItemButton');           // Cache button to show form
    $clearListButton = $('#clear');                 // Cache button to clear form
    ESC = 27;                                       // Keycode for escape key
    ENTER = 13;                                     // Keycode for enter key
    
    // GET LIST FROM LOCAL STORAGE
    if (localStorage.getItem("savedList") !== null) {
        $list.html(localStorage.getItem("savedList"));
    }
    
    // DISPLAY LIST ITEMS
    $('li').hide().each(function (index) {          // Hide list items
        $(this).delay(450 * index).fadeIn(1600);    // Then fade them in
        $('li > input').hide();                     // Hide their edit boxes
    });

    // ITEM COUNTER
    function updateCount() {                        // Create function to update counter
        var items = $('li[class!=done]').length;    // Number of items in list
        if (items === 1) {
            items += " item";
        } else {
            items += " items";
        }
        $('#counter').text(items);                  // Added into counter paragraph
    }
    updateCount();                                  // Call the function
    
    // SAVE LIST TO LOCAL STORAGE
    function saveList() {
        localStorage.setItem("savedList", $list.html());
    }

    // ADDING A NEW LIST ITEM
    $newItemForm.on('submit', function (e) {
        e.preventDefault();                         // Prevent form being submitted
        var text = $('input:text').val();           // Get value of text input
        if (text !== "") {                          // Add item to beginnning of list if the string isn't empty
            $list.prepend('<li> <div class="incomplete"></div> <label>' + text + '</label> <div class="remove"></div> <input type=\"text\" class=\"edit\" value=\"' + text + '\"> </li>');
            $('input:text').val('');                // Empty the text input
            $('li > input').hide();                 // Hide the edit box box
            updateCount();                          // Update the count
            saveList();
        }
    });

    //DELETE WHEN CLICK ON X
    $list.on('click', '.remove', function () {
        var $this = $(this).parent();               // Cache the actual list element in a jQuery object
        $this.animate({                             // If so, animate opacity + padding
            opacity: 0.0,
            paddingLeft: '+=180'
        }, 500, 'swing', function () {              // Use callback when animation completes
            $this.remove();                         // Then completely remove this item
            updateCount();                          // Update the counter
            saveList();
        });
    });

    //TOGGLE CLASS WHEN CLICK ON CHECK
    $list.on('click', '.incomplete', function () {
        var $this, complete, text;
        $this = $(this).parent();                   // Cache the actual list element in a jQuery object
        complete = $this.hasClass('complete');      // Is item complete

        if (complete === false) {
            text = $this.find('label').text();                    // Get the text from the list item
            $this.remove();                         // Remove the list item
            $list                                   // Add back to end of list as complete
                .append('<li class=\"done\"> <div class=\"complete\"></div> <label class=\"strike\">' + text + '</label> <div class="remove"></div> <input type=\"text\" class=\"edit\" value=\"' + text + '\"></li>')
                .hide().fadeIn(300);                // Hide it so it can be faded in
            $('li > input').hide();                 // Hide the edit box
            updateCount();
            saveList();
        }
    });

    $list.on('click', '.complete', function () {
        var $this, incomplete, text;
        $this = $(this).parent();                   // Cache the actual list element in a jQuery object
        incomplete = $this.hasClass('incomplete');  // Is item incomplete
        
        if (incomplete === false) {
            text = $this.find('label').text();                    // Get the text from the list item
            $this.remove();                         // Remove the list item
            $list                                   // Add back to beginning of list as incomplete
                .prepend('<li> <div class=\"incomplete\"></div> <label>' + text + '</label> <div class="remove"></div> <input type=\"text\" class=\"edit\" value="' + text + '"></li>')
                .hide().fadeIn(300);
            $('li > input').hide();                 // Hide the edit box
            updateCount();
            saveList();
        }
    
    });

    //EDIT ON DOUBLE CLICK
    $list.on('dblclick', 'label', function () {
        var $this, complete, text, $input, $label;
        $this = $(this);                            // Cache the element in a jQuery object
        $input = $this.siblings('input').first();   // Cache the input element in jQuery object
        complete = $this.hasClass('strike');        // Is item complete
        
        if (complete === false) {                   // Only incomplete items can be edited
            text = $this.text();                    // Get the text from the list item
            $this.hide();                           // Hide the label
            $input.show();                          // Show the edit box
            $input.val(text);                       // Display the text in the box
            $input.focus();                         // Add focus to text box
            $input.select();                        // Select text for easy editing
        }
    });
    
    // FINISH EDITING ON ENTER
    $list.on('keypress', '.edit', function (e) {
        if (e.which === ENTER) {
            var $this, text, replacement;
            $this = $(this).parent();               // Cache the actual list element in a jQuery object
            text = $this.find('input:text').val();  // Get value of text input
            replacement = "<label>" + text + "</label>";
            $this.find('label').replaceWith(replacement);
            $('li > input').hide();                 // Hide the edit box
            $('li > label').show();                 // Show the label
            saveList();
        }
    });
    
    //RETURN TO NORMAL STATE ON BLUR
    $list.on('blur', 'input', function () {
        $('li > input').hide();                     // Hide the edit box
        $('li > label').show();                     // Show the label
    });
    
    //RETURN TO NORMAL STATE ON ESC
    $list.on('keyup', 'input', function (e) {
        if (e.keyCode === ESC) {
            $('li > input').hide();                 // Hide the edit box
            $('li > label').show();                 // Show the label
        }
    });

    // CLEAR LIST
    $clearListButton.on('click', function () {
        $('li').each(function (index) {
            $(this).delay(450 * index).fadeOut(900);// Fade them out
            $(this).remove();
        });
        saveList();
    });
});