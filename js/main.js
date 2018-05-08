/*
*
* main.js - js file used in main.php
* Majority of frontend functionality and passing of data to serverside functionality is found in this file.
* 
*/

$(function () {

    var seconds = 5; // refresh rate on the queue table
    var notify = 15; // variable used to set how many seconds the system should wait before seeing whether to notify a demonstrator or not

    setInterval(function() {$("#studentTable").load('main.php #studentTable'); }, seconds*1000); // Refreshing the queue table. Done to show if any changes have been made

    // Function below is used to push a notification to the helper if they are not helping anyone and there is someone active in the queue
    setInterval(function() {

        $.ajax({
            url: 'queueCheck.php',
            dataType: 'json',
            success : function (data) {
                if(data.type == 'success'){
                    notifyMe();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // alert("error");
                console.log(textStatus, errorThrown);
            }
        });
    
    }, notify*1000); // Identify that this function is to be called every 15 seconds (as per the notify var)

    // Function below is used to alert the student, with a modal notfication, that a helper is on their way.
    setInterval(function() {
        $.ajax({
            url: 'attendanceCheck.php',
            dataType: 'json',
            success : function (data) { 
                if(data.type == 'success'){
                    $('#modalText').text(data.text); // Adding text to the modal which displays helpful responses to the student
                    $('#responseModal').modal('show'); // Activating the response modal
                    $("#studentTable").load('main.php #studentTable'); // Reloading the queueing table
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    
    }, seconds*1000);

    // The function below is for when a student is making a help request and is filling out the form.
    // This specific function handles the dynamic changing of the content located in the subcategory box.
    // The content shown in the subcategory box is affected by the option chosen in the 'category' box.
    $('#weekSub').on('change', function(e){

        var selected_option_value=$("#weekSub option:selected").val(); // Sotring the value of the 'category' option chosen by the student
        
        e.preventDefault();

        $.ajax({
            type: 'POST',
            url: 'optionSelected.php',
            dataType: 'json',
            data: { option : selected_option_value },
            success : function (data) {
                if (data.type == 'success'){
                    var temp = data.text; // Temporarily storing the data returned by the server
                    // Next, the returened data is split into an array
                    var options = temp.split(',');
                    // Previous options are cleared before appending more items into the select box
                    $('#taskNo').empty();
                    // For each item in the array, display it is as an option in the select box. The function below acts as a for loop going through each item in the 'options' array (jQuery)
                    $.each(options, function (i, option) {
                        // Appending all items in the array as an option tag in the select box
                        $('#taskNo').append($('<option>').val(option).html(option));
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(textStatus, errorThrown);
            }
        });
    });

    // Function below is used to submit help request data provided by the students into the database (called when help request form 'submit' button is pressed).
    // The response of the outcome will either result in an appropriate success or failure message - displayed as a notfication on the screen.
    // If student is successful in making a help request the outcome will then be seen in the refreshed queue table.
    $('#helpForm').on('submit', function(e) {

        e.preventDefault();

        $.ajax({
            type: 'POST', 
            url: 'submitRequest.php',
            dataType: 'json',
            data: $('#helpForm').serialize(),
            success : function (data) {
                if(data.type == 'error'){
                    $('#taskNo').empty(); // Emptying the sub-category field in the form
                    $("#helpForm")[0].reset(); // Reseting the form
                    $('#close').trigger('click'); // Using jquery to close the help request form
                    $('#modalText').text(data.text); // Adding text to the notification modal which displays helpful responses to the student
                    $('#responseModal').modal('show'); // Activating the response modal
                    $("#studentTable").load('main.php #studentTable'); // Reloading the queueing table
                }
                else{
                    $('#taskNo').empty();
                    $("#helpForm")[0].reset();
                    $('#close').trigger('click');
                    $('#modalText').text(data.text);
                    $('#responseModal').modal('show');
                    $("#studentTable").load('main.php #studentTable');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(textStatus, errorThrown);
            }
        });
    });

    // Function below is called when a helper presses the button to submit helper provided feedback data
    $('#completeForm').on('submit', function(e) {

        e.preventDefault();

        $.ajax({
            type: 'POST', 
            url: 'completeRequest.php',
            dataType: 'json',
            data: $('#completeForm').serialize(),
            success : function (data) {
                if(data.type == 'error'){
                    $("#completeForm")[0].reset(); // Reseting the form
                    $('#close').trigger('click'); // Using jquery to close the form
                    $("#studentTable").load('main.php #studentTable'); // Reloading the queueing table
                }
                else{
                    $("#completeForm")[0].reset();
                    $('#close').trigger('click');
                    $("#studentTable").load('main.php #studentTable');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(textStatus, errorThrown);
            }
        });
    });
});

// Javascript function which, when called, acquires info on the value of the seat position of the student.
// This function also helps to serve the purpose of changing a specific session value (used to display the correct button (Submit button) in the help request form (instead of the 'edit' button))
function addSeat(objButton) {
    $("#submitButton").html("Submit Request");
    $("#submitButton").removeClass("btn btn-warning");
    $("#submitButton").addClass("btn btn-success");
    $.ajax({
        url: 'edit.php',
        dataType: 'json',
        success : function (data) { 
            var x = objButton.value; // Storing value of selected seat in a var
            $("#seatFill").val(x); // Setting the seat value field in the help request form
        }
    });
}

// The function below is used to disable the seat buttons if the account type of the user is not 'student'
function buttonDisable(){
    $.ajax({
        url: 'accInfo.php',
        dataType: 'json',
        success : function (data) { 
            var accType = data.text;
            var i;
            if (accType != 'student'){
                $('.seat').prop('disabled', true);
            }
        }
    });
}

// The function below is how a student is able to click the delete button next to their help request and then remove it from the queue (and the system)
function deleteItem(objButton) {
    var x = objButton.value;

    $.ajax({
        type: 'POST',
        url: 'delete.php',
        dataType: 'json',
        data: { itemNum : x },
        success : function (data) { 
            if(data.type == 'error'){
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
                $("#studentTable").load('main.php #studentTable');
            }
            else{ //if request is successful the form is reset and then closed
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
                $("#studentTable").load('main.php #studentTable');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });
}

// Function below is used to help bring up the help request form for editting an active request.
// The form is prepopulated with the data students provided in their initial help request submission.
// Essentially it allows them to edit their help request data without having to delete their current one and make a new request.
function editItem(objButton) {
    var x = objButton.value;

    $.ajax({
        type: 'POST', //get or post? this time we want to post data to the php file
        url: 'edit.php', //php file we send the data to
        dataType: 'json',
        data: { itemNum : x },
        success : function (data) { 
            if(data.type == 'success'){
                $("#weekSub").val(data.week);
                $('#taskNo').append($('<option>').val(data.task).html(data.task));
                // $("#taskNo").val(data.task); // This line of code does not work for prepopulating the sub-category box. (However, the line above does work)
                $("#severity").val(data.psev);
                $("#time").val(data.time);
                $("#description").val(data.desc);
                $("#seatFill").val(data.seat);
                $("#submitButton").html("Edit");
                $("#submitButton").removeClass("btn btn-success");
                $("#submitButton").addClass("btn btn-warning");
            }
            else{
                alert("nope");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });
}

// The function below called when a demonstrator clicks the button to then attend to a student.
// When that button is clicked the students help request ticket is removed from the queue and the table is then updated accordingly.
function helpStudent(objButton) {
    var x = objButton.value;

    $.ajax({
        type: 'POST',
        url: 'acceptRequest.php',
        dataType: 'json',
        data: { itemNum : x },
        success : function (data) { 
            if(data.type == 'success'){
                $("#studentTable").load('main.php #studentTable');
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
            }
            else{
                $("#studentTable").load('main.php #studentTable');
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });
}

// When a helper clicks the button to identify they are done helping a student, this function is called.
function completeRequest(objButton) {
    var x = objButton.value;

    $.ajax({
        type: 'POST',
        url: 'completeRequest.php',
        dataType: 'json',
        data: { itemNum : x },
        success : function (data) { 
            if(data.type == 'success'){
                $("#completeForm")[0].reset();
                $("#studentTable").load('main.php #studentTable');
                // $('#modalText').text(data.text);
                $("#ticketNumber").val(x);
                $('#completedQs').modal('show'); // Displaying the helper feedback modal form on the screen
            }
            else{
                $("#completeForm")[0].reset();
                $("#studentTable").load('main.php #studentTable');
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });
}

// Function called when a helper identifies that they need assistance (button call)
function assistance(objButton) {
    var x = objButton.value;

    $.ajax({
        type: 'POST',
        url: 'assistance.php',
        dataType: 'json',
        data: { itemNum : x },
        success : function (data) { 
            if(data.type == 'success'){
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
                $("#studentTable").load('main.php #studentTable');
            }
            else{
                $('#modalText').text(data.text);
                $('#responseModal').modal('show');
                $("#studentTable").load('main.php #studentTable');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });
}

// Code was acquired from https://stackoverflow.com/questions/2271156/chrome-desktop-notification-example?noredirect=1&lq=1 (Code has been altered slightly to suite this application)
// Firs request permission to allow push notifications on page load
document.addEventListener('DOMContentLoaded', function () {
    if (!Notification) {
        alert('Desktop notifications not available in your browser. Try Chromium.'); 
        return;
    }
  
    if (Notification.permission !== "granted")
        Notification.requestPermission();
});

// This function is called to active a notification to the helper.
function notifyMe() {

    if (Notification.permission !== "granted")
        Notification.requestPermission();
    else {
        var notification = new Notification('Queue Notification', {
        icon: 'bufavicon.ico', // Setting push notification icon
        body: "A student has just entered the queue", // Setting the push notification text
        });

        notification.onclick = function () {
        window.open("http://student30224.bucomputing.uk/main.php");      
        };

    }

}