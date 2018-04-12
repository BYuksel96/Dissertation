$(function () { //waits for page to load before js function works

    var seconds = 5; 
    setInterval(function() {$("#loginTable").load('account.php #loginTable'); }, seconds*1000); //refresh login table every 5 seconds
    setInterval(function() {$("#completedTable").load('account.php #completedTable'); }, seconds*1000); //refresh help completed table every 5 seconds

    $('.card').on('shown.bs.collapse', function () {
        var down = '.fa-angle-down.' + $(this).data("value");
        var up = '.fa-angle-up.' + $(this).data("value");
        // alert(cls);
        $(down).hide(1000);
        $(up).show(1000);
    });

    $('.card').on('hidden.bs.collapse', function () {
        var down = '.fa-angle-down.' + $(this).data("value");
        var up = '.fa-angle-up.' + $(this).data("value");
        $(up).hide(1000);
        $(down).show(1000);
    });

    //function below posts form data to createAcc.php
    $('#crtAcc').on('submit', function(e) { //function is called when create account button is pressed

        e.preventDefault(); //prevents page from opening

        $.ajax({
            type: 'POST', //get or post? this time we want to post data to the php file
            url: 'createAcc.php', //php we send the data to
            dataType: 'json',
            data: $('#crtAcc').serialize(), //takes contents of the form
            success : function (data) { 
                if(data.type == 'error'){ //if username exists or there is a sql error then the error message will be displayed
                    $("#crtAcc")[0].reset();
                    $("#msg-response").css("color", "red");
                    document.getElementById("msg-response").innerHTML=data.text;
                }
                else{ //if account is created successfully then a message will appear saying just that
                    $("#crtAcc")[0].reset();
                    $("#msg-response").css("color", "green");
                    document.getElementById("msg-response").innerHTML=data.text;
                    $("#demonTable").load('account.php #demonTable');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(textStatus, errorThrown);
            }
        });
    });
    //function submits help request data
    $('#addData').on('submit', function(e) { //function is called when create account button is pressed

        e.preventDefault(); //prevents page from opening

        $.ajax({
            type: 'POST', //get or post? this time we want to post data to the php file
            url: 'addData.php', //php we send the data to
            dataType: 'json',
            data: $('#addData').serialize(), //takes contents of the form
            success : function (data) { 
                if(data.type == 'error'){ //if username exists or there is a sql error then this an error message will be displayed
                    $("#addData")[0].reset();
                    $("#msg-response2").css("color", "red");
                    document.getElementById("msg-response2").innerHTML=data.text;
                    $("#dataTable").load('account.php #dataTable');
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
    //function for changing the users password password
    $('#changePSW').on('submit', function(e) { //function is called when create account button is pressed

        e.preventDefault(); //prevents page from opening

        $.ajax({
            type: 'POST', //get or post? this time we want to post data to the php file
            url: 'changePassword.php', //php we send the data to
            dataType: 'json',
            data: $('#changePSW').serialize(), //takes contents of the form
            success : function (data) { 
                if(data.type == 'error'){ //if username exists or there is a sql error then this an error message will be displayed
                    $("#changePSW")[0].reset();
                    $("#msg-responsepsw").text("");
                    $("#msg-response3").css("color", "red");
                    document.getElementById("msg-response3").innerHTML=data.text;
                }
                else if(data.type =='old'){
                    $("#changePSW")[0].reset();
                    $("#msg-responsepsw").css("color", "red");
                    document.getElementById("msg-responsepsw").innerHTML=data.text;
                }
                else{ //if account is created successfully then a message will appear saying just that
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

    $('#reset').on('click', function(e) {
        
        e.preventDefault();

        $.ajax({
            url: 'reset.php',
            dataType: 'json',
            success : function (data) {
                if(data.type == 'success'){
                    $("#completedTable").load('account.php #completedTable');
                    $('#modalText').text(data.text);
                    $('#responseModal').modal('show');
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

function deleteAccount(objButton) {

    var userID = objButton.value;

    $.ajax({
        type: 'POST', //get or post? this time we want to post data to the php file
        url: 'deleteUser.php', //php file we send the data to
        dataType: 'json',
        data: { user : userID },
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

function manualLogout(objButton) {

    var studentID = objButton.value;

    $.ajax({
        type: 'POST', //get or post? this time we want to post data to the php file
        url: 'manualLogout.php', //php file we send the data to
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

function resetData(objButton){

    var resetTable = objButton.value;

    $.ajax({
        type: 'POST',
        url: 'rrData.php', // reset/remove data php file - data from button is sent their
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