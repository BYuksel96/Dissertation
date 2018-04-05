$(function () { //waits for page to load before js function works

    var seconds = 5; 
    setInterval(function() {$("#loginTable").load('account.php #loginTable'); }, seconds*1000) //refresh login table every 5 seconds
    setInterval(function() {$("#completedTable").load('account.php #completedTable'); }, seconds*1000) //refresh help completed table every 5 seconds

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
                }
                else{ //if account is created successfully then a message will appear saying just that
                    $("#addData")[0].reset();
                    $("#msg-response2").css("color", "green");
                    document.getElementById("msg-response2").innerHTML=data.text;
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

    // fputcsv - use this function to add contents of completed table into a csv. Simple create a new file for this work (completedTable2CSV.php). Use query on account.php, acquire data, use for loop and output into the csv
    $('#tab2CSV').on('click', function(e) {
        
        e.preventDefault(); //prevents page from opening

        $.ajax({
            url: 'tableToCSV.php', //php we send the data to
            dataType: 'json',
            success : function (data) { 
                if(data.type == 'success'){
                    alert(data.text);
                }
                else{
                    alert(data.text);
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