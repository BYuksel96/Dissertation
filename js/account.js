$(function () { //waits for page to load before js function works
    //function below posts form data to createAcc.php
    $('#crtAcc').on('submit', function(e) { //function is called when create account button is pressed

        e.preventDefault(); //prevents page from opening

        $.ajax({
            type: 'POST', //get or post? this time we want to post data to the php file
            url: 'createAcc.php', //php we send the data to
            dataType: 'json',
            data: $('#crtAcc').serialize(), //takes contents of the form
            success : function (data) { 
                if(data.type == 'error'){ //if username exists or there is a sql error then this an error message will be displayed
                    $("#crtAcc")[0].reset();
                    $("#msg-response").css("color", "red");
                    document.getElementById("msg-response").innerHTML=data.text;
                }
                else{ //if account is created successfully then a message will appear saying just that
                    $("#crtAcc")[0].reset();
                    $("#msg-response").css("color", "green");
                    document.getElementById("msg-response").innerHTML=data.text;
                }
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
            }
        });
    });
});