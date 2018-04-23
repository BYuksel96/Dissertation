$(function () {

    var seconds = 5; 
    setInterval(function() {$("#studentTable").load('main.php #studentTable'); }, seconds*1000); // Refreshing the queue table. Done to show if any changes have been made

    setInterval(function() {
        //ajax in here
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

    // The function below is for when a student is making a request and is filling out the form.
    // This specific function handles the dynamic changing of the content located in the sub-category box.
    // The content shown in the sub-category box is affected by the option chosen in the 'category' box.
    $('#weekSub').on('change', function(e){

        var selected_option_value=$("#weekSub option:selected").val(); // Sotring the value of the 'category' option chosen by the student
        
        e.preventDefault();

        // View account.js for clarification on the ajax function below and how it operates, if needed.

        $.ajax({
            type: 'POST',
            url: 'optionSelected.php',
            dataType: 'json',
            data: { option : selected_option_value },
            success : function (data) {
                if (data.type == 'success'){
                    var temp = data.text; // Temporarily storing the data returend by the server
                    var options = temp.split(','); // Splitting the string into an array to then be able to display all the options that have been provided by the admin for that specific category
                    $('#taskNo').empty(); // Need to clear previous options before appending more items as options in the select box
                    // For each item in the array display it is displayed as an option in the select box
                    $.each(options, function (i, option) { // This function acts as a for loop going through each item in the 'options' array (jQuery)
                        $('#taskNo').append($('<option>').val(option).html(option)); // Appending all items in the array as an option tag in the select menu
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(textStatus, errorThrown);
            }
        });
    });

    // Function below is used to submit help request data provided by the students into the database
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
                    $('#modalText').text(data.text); // Adding text to the modal which displays helpful responses to the student
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
// This function also helps to serve the purpose of editting a specific session value, which is used to display the correct button on the help request form
function addSeat(objButton) {
    $("#submitButton").html("Submit Request");
    $("#submitButton").removeClass("btn btn-warning");
    $("#submitButton").addClass("btn btn-success");
    $.ajax({
        url: 'edit.php',
        dataType: 'json',
        success : function (data) { 
            var x = objButton.value;
            $("#seatFill").val(x);
        }
    });
}

// The function below is used to disable the seat buttons is the account type of the user is not 'student'
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

// Function below is used to help bring up the help request form.
// However this time the form is prepopulated with the data they provide in their initial help request submission
// Essentially it allows them to edit their help request data without having to delete their current one and make a new request
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
                $('#completedQs').modal('show');
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