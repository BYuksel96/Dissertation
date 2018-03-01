<?php
    include('connection.php');

?>

<html>
    <head>
        <title>Account</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/account.css">

        <script>
            //function below posts form data to createAcc.php
            $(function () { //waits for page to load before js function works
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
        </script>
    </head>

    <body class="container-fluid">

        <div class="accountInfo">

        </div>

        <div class="changePsw">
                
        </div>

        <div class="createAcc">
            <form id="crtAcc" name="crtAcc" style="border:1px solid #ccc">
                <div class="container-fluid">
                    <h1>Create Account</h1>
                    <p>Fill in the form below to create an account for a demonstrator</p>
                    <hr class="formHR">

                    <div class="form-group">
                        <label for="accName"><b>Account Name:</b></label>
                        <input type="text" placeholder="Enter Account Name" name="accName" id="accName" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="psw"><b>Enter Account Password:</b></label>
                        <input type="password" placeholder="Enter Password" name="psw" id="psw" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="accType"><b>Choose Account Type:</b></label>
                        <select name="accType" id="accType" class="form-control" required>
                            <option value="admin">Admin Account</option>
                            <option value="standard">Standard Account</option>
                        </select>
                    </div>

                    <p id="msg-response" style="color: green; font-size: 10pt;"></p>
                    <button type="submit" id="submitAcc" class="btn btn-success">Create Account</button> <!-- will need to sort out the css form this button as can not use 'button' in the css file as the selector for editting the button settings as it would edit it for all button tags -->

                </div>
            </form>
        </div>
    </body>
</html>