<?php
    include('connection.php');
    session_start();
    if(!isset($_SESSION['demonstrator'])){
        header("location:main.php");
    }

?>

<html>
    <head>
        <title>Account</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/account.css">
        <script src="js/account.js"></script>
    </head>

    <body class="container-fluid">

        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            <ul class="nav navbar-nav ml-auto">
                <li><a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </nav>

        <div id="accordion">

            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Account Info</a>
                </div>
                <div id="collapseOne" class="collapse">
                    <p>account info goes here - to be done<p>
                </div>
            </div>

            <div class="gap"></div>

            <div class="card">
                <div class="card-header">
                    <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Change Password</a>
                </div>
                <div id="collapseTwo" class="collapse">
                    <form id="changePSW" class="card-body" name="changePSW">
                        <div class="container-fluid">
                            <p>The form below is where you can supply the data you expect students to fill out before they make a help request.</p>
                            <hr class="formHR">

                            <div class="form-group">
                                <label for="weekSub"><b>Enter week submission # or enter specific help request data (i.e. Exam Question):</b></label>
                                <input type="text" placeholder="Enter data here" name="weekSub" id="weekSub" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="taskNum"><b>Enter the max task number or enter specific help request data (i.e. Exam Question):</b></label>
                                <input type="password" placeholder="Enter Password" name="taskNum" id="taskNum" class="form-control" required>
                            </div>

                            <p id="msg-response3" style="color: green; font-size: 10pt;"></p>
                            <button type="submit" id="submitButton" class="btn btn-success">Add data</button>

                        </div>
                    </form>
                </div>
            </div>

            <div class="gap"></div>

            <?php if ($_SESSION["accType"] == "admin") { ?>

                <div class="card">
                    <div class="card-header">
                        <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Create Account</a>
                    </div>
                    <div id="collapseThree" class="collapse">
                        <form id="crtAcc" class="class-body" name="crtAcc">
                            <div class="container-fluid">
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
                </div>

                <div class="gap"></div>

                <div class="card">
                    <div class="card-header">
                        <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Help Request Data</a>
                    </div>
                    <div id="collapseFour" class="collapse">
                        <form id="addData" class="card-body" name="addData">
                            <div class="container-fluid">
                                <p>The form below is where you can supply the data you expect students to fill out before they make a help request.</p>
                                <hr class="formHR">

                                <div class="form-group">
                                    <label for="weekSub"><b>Enter week submission #:</b></label>
                                    <input type="number" pattern="\d+" placeholder="Enter data here" name="weekSub" id="weekSub" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="taskNum"><b>Enter the max task number (i.e. if week 11 contains 5 tasks to complete, enter the number 5 below):</b></label>
                                    <input type="number" pattern="\d+" placeholder="Enter data here" name="taskNum" id="taskNum" class="form-control" required>
                                </div>

                                <p id="msg-response2" style="color: green; font-size: 10pt;"></p>
                                <button type="submit" id="submitButton" class="btn btn-success">Add data</button>

                            </div>
                        </form>
                    </div>
                </div>

                <!-- still to do:
                    - need to create a table of demonstrator accounts (need to be able to delete the account)
                    - need to create a table of students currently logged in the system. need to be able to terminate that session remotely (when deleting them from the database: answer 2 logic is the one to use on this link: https://stackoverflow.com/questions/5443355/remotely-destroy-a-session-in-php-user-logs-in-somewhere-else)
                    - work on change password function
                    - work on acc info section
                    - maybe also consider another help request data section in which you can type instead of writing week and task numbers (so specific content like: "PAST PAPER 2015" then "Question 1")
                 -->

            <?php } ?>
        </div>
    </body>
</html>