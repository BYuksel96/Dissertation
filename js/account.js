$(function () { // When the page is loaded all the functions below in this bracket are active and accessible

    var seconds = 5; // Creating a variable to hold a time value which is used later
    
    setInterval(function() {$("#loginTable").load('account.php #loginTable'); }, seconds*1000); // The login table is refreshed every 5 seconds
    setInterval(function() {$("#completedTable").load('account.php #completedTable'); }, seconds*1000); //The completed table is refreshed every 5 seconds

    // Tables are refreshed, as specified above, in order to display any changes that may have been made to the tables in the DB
    // For instance a student has made a request for help. Or a demonstrator has attended to a students and thus the reuqest is no longer in the DB table

    // The function below is constantly looking out for when an accordion has been clicked on and is now in the process of collapsing.
    // If activated, it will then carry out the work contained within this function.
    $('.card').on('show.bs.collapse', function () {
        // The variables below have been created to specifically be able to identify which accordion has been clicked on
        // Without them only the first accordion would work
        var down = '.fa-angle-down.' + $(this).data("value"); // Taking the data value of the clicked accordion to help identify specifically which accordion item was clicked
        var up = '.fa-angle-up.' + $(this).data("value");
        // alert(cls);
        $(down).hide(750); // Animating and hiding the down arrow on the accordion
        $(up).show(750); // Animating and showing the up arrow on the accordion
    });

    // The function below is constantly looking out for when an accordion has been clicked on and is now in the process of receeding.
    // If activated, it will then carry out the work contained within this function.
    $('.card').on('hide.bs.collapse', function () {
        var down = '.fa-angle-down.' + $(this).data("value");
        var up = '.fa-angle-up.' + $(this).data("value");
        $(up).hide(750);
        $(down).show(750);
    });

    // The function below posts the account creation form data to createAcc.php
    $('#crtAcc').on('submit', function(e) { // The function is called when create account forms submit button is pressed

        e.preventDefault(); // prevents page from opening

        $.ajax({
            type: 'POST', // get or post? this time we want to post the data from the form
            url: 'createAcc.php', // identifying the php file that the work is to be carried out in
            dataType: 'json', // This specifies how data is to be exchanged between the frontend and the server
            data: $('#crtAcc').serialize(), // Takes the contents of the form and encodes them as a string ready for submission
            success : function (data) { // If no system errors are ecountered then the success section is accessed
                if(data.type == 'error'){ // If username exists or there is a sql error then an error message will be displayed
                    $("#crtAcc")[0].reset(); // Resetting the form data
                    $("#msg-response").css("color", "red"); // Settting the text colour for the error message that is going to be displayed
                    document.getElementById("msg-response").innerHTML=data.text; // Acquiring the data received from createAcc.php (in this case data.text) and displaying it to the user
                    // The line above is essentially a way of setting the text on the page through the use of jquery/javascript
                }
                else{ // If the account is created successfully then a message will appear saying just that
                    $("#crtAcc")[0].reset();
                    $("#msg-response").css("color", "green");
                    document.getElementById("msg-response").innerHTML=data.text;
                    $("#demonTable").load('account.php #demonTable');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) { // If a system error is encountered then it is logged in the console and alerted to the user
                alert(errorThrown);
                console.log(textStatus, errorThrown);
            }
        });
    });

    // Function that submits help request data - The category and sub category data that is provided by the admin of the system
    $('#addData').on('submit', function(e) { // Function is called when the add data button in this form is pressed (The button is of type:submit)

        e.preventDefault(); //prevents page from opening

        $.ajax({
            type: 'POST',
            url: 'addData.php', 
            dataType: 'json',
            data: $('#addData').serialize(),
            success : function (data) { 
                if(data.type == 'error'){
                    $("#addData")[0].reset();
                    $("#msg-response2").css("color", "red");
                    document.getElementById("msg-response2").innerHTML=data.text;
                    $("#dataTable").load('account.php #dataTable'); // Reloading the table to display the changes which have just occured in the DB table (specific to the one displayed in this section)
                }
                else{ //if account is created successfully then a message will appear saying just that
                    $("#addData")[0].reset();
                    $("#msg-response2").css("color", "green");
                    document.getElementById("msg-response2").innerHTML=data.text;
                    $("#dataTable").load('account.php #dataTable');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(textStatus, errorThrown);
            }
        });
    });

    // The function for changing the users password
    $('#changePSW').on('submit', function(e) {

        e.preventDefault(); //prevents page from opening

        $.ajax({
            type: 'POST', 
            url: 'changePassword.php',
            dataType: 'json',
            data: $('#changePSW').serialize(),
            success : function (data) { 
                if(data.type == 'error'){
                    $("#changePSW")[0].reset();
                    $("#msg-responsepsw").text(""); // Another way of setting text on the page through jquery
                    $("#msg-response3").css("color", "red");
                    document.getElementById("msg-response3").innerHTML=data.text;
                }
                else if(data.type =='old'){
                    $("#changePSW")[0].reset();
                    $("#msg-responsepsw").css("color", "red");
                    document.getElementById("msg-responsepsw").innerHTML=data.text;
                }
                else{
                    $("#changePSW")[0].reset();
                    $("#msg-responsepsw").text("");
                    $("#msg-response3").css("color", "green");
                    document.getElementById("msg-response3").innerHTML=data.text;
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(textStatus, errorThrown);
            }
        });
    });

    // The function below is for when the admin wants to reset the whole system. Clears out DB table specific for keeping record of all completed requests and other help requests
    $('#reset').on('click', function(e) {
        
        e.preventDefault();

        $.ajax({
            url: 'reset.php',
            dataType: 'json',
            success : function (data) {
                if(data.type == 'success'){
                    $("#completedTable").load('account.php #completedTable');
                    $('#modalText').text(data.text);
                    $('#responseModal').modal('show'); // Using a modal to display the messaged returned back to the user. Here jquery is used to actually show/activate the modal box
                } else {
                    $("#completedTable").load('account.php #completedTable');
                    $('#modalText').text(data.text);
                    $('#responseModal').modal('show');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(textStatus, errorThrown);
            }
        });

    });
    
});

// Below is a javascript function. When called it will delete a demonstrator account (Deletes the account which was chosen by the admin)
function deleteAccount(objButton) {

    var userID = objButton.value; // Storing the user ID of the account chosen to be deleted

    $.ajax({
        type: 'POST',
        url: 'deleteUser.php',
        dataType: 'json',
        data: { user : userID }, // Due to the fact form data is not being sent the .serialize() function is not used. Instead we provide specific data and store it as a POST variable
        success : function (data) { 
            if(data.type == 'success'){
                $("#demonTable").load('account.php #demonTable');
                $("#msg-response-delete").css("color", "green");
                document.getElementById("msg-response-delete").innerHTML=data.text;
            }
            else{
                $("#demonTable").load('account.php #demonTable');
                $("#msg-response-delete").css("color", "red");
                document.getElementById("msg-response-delete").innerHTML=data.text;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });
}

// The function below is used to manually log a student out of the system, if needed.
function manualLogout(objButton) {

    var studentID = objButton.value; // Sotring the value of the object which was acquired when the specific button was clicked of the "Students Active In System" accordion

    $.ajax({
        type: 'POST',
        url: 'manualLogout.php',
        dataType: 'json',
        data: { id : studentID },
        success : function (data) { 
            if(data.type == 'success'){
                $("#loginTable").load('account.php #loginTable');
                $("#msg-response-logout").css("color", "green");
                document.getElementById("msg-response-logout").innerHTML=data.text;
            }
            else{
                $("#loginTable").load('account.php #loginTable');
                $("#msg-response-logout").css("color", "red");
                document.getElementById("msg-response-logout").innerHTML=data.text;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });
}

// Function below is used to completely reset all the category/sub-category data which was provided by the system admin - Only system admins can call this function (on button click)
function resetData(objButton){

    var resetTable = objButton.value;

    $.ajax({
        type: 'POST',
        url: 'rrData.php', // rrData.php -> (reset/remove)Data.php
        dataType: 'json',
        data: { reset : resetTable },
        success : function (data) { 
            if(data.type == 'success'){
                $("#dataTable").load('account.php #dataTable');
                $("#msg-response-dataTbl").css("color", "green");
                document.getElementById("msg-response-dataTbl").innerHTML=data.text;
            }
            else{
                $("#dataTable").load('account.php #dataTable');
                $("#msg-response-dataTbl").css("color", "green");
                document.getElementById("msg-response-dataTbl").innerHTML=data.text;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });

}

// Function below is used to remove specific category/sub-category data which was provided by the system admin - Only system admins can call this function (on button click)
function removeData(objButton){

    var remove = objButton.value;

    $.ajax({
        type: 'POST',
        url: 'rrData.php', // reset/remove data php file - data from button is sent their
        dataType: 'json',
        data: { id : remove },
        success : function (data) { 
            if(data.type == 'success'){
                $("#dataTable").load('account.php #dataTable');
                $("#msg-response-dataTbl").css("color", "green");
                document.getElementById("msg-response-dataTbl").innerHTML=data.text;
            }
            else{
                $("#dataTable").load('account.php #dataTable');
                $("#msg-response-dataTbl").css("color", "green");
                document.getElementById("msg-response-dataTbl").innerHTML=data.text;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(textStatus, errorThrown);
        }
    });

}