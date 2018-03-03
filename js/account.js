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
});