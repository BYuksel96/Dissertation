<?php
    include('connection.php');
    session_start();
	if(isset($_SESSION['demonstrator']) || isset($_SESSION['studentNumber'])){ // If session values are already set then user is sent to main.php
		header("location:main.php"); // Relocating to main.php
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" type="image/x-icon" href="bufavicon.ico" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <script src="js/login.js"></script>
    </head>

    <body class="container-fluid">
        <div class="login">
            <h1 style="text-align: center; margin-bottom: 25px;">Programming Support Session</h1>
            <div class="student">
                <a href="" class="active" id="student-form">Student</a>
            </div>
            <div class="demonstrator">
                <a href="" id="demon-form">Demonstrator</a>
            </div>
            <br>
            <form name="loginStu" id="student-login-form"> <!-- Student login form -->
                <div class="container-fluid">

                    <hr>

                    <div class="form-group">
                        <!-- Below is the field where the students name can be entered -->
                        <input type="text" placeholder="Enter Your Name" name="name" id="name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <!-- Below is the field where the student number can be entered -->
                        <input type="text" placeholder="Enter Student Number" pattern="([A-Za-z]{1})([0-9]{6,})" title="Enter your i or s number" name="stuNum" id="stuNum" class="form-control" required>
                    </div>
                    <p id="msg-response-stu" style="color: red; font-size: 10pt;"></p>
                    <button type="submit" class="btn btn-success bttn">Login</button>
                    <button type="button" class="btn btn-info bttn" data-toggle="modal" data-target="#studentModal">How to use...</button> <!-- Button which will trigger the showing of the students modal -->
                    
                    <hr>

                </div>
            </form>
            <form name="loginDem" id="demon-login-form" style="display: none;"> <!-- Demonstrator/helper login form -->
                <div class="container-fluid">

                    <hr>

                    <div class="form-group">
                        <!-- Below is the field where the demonstrator enters their username -->
                        <input type="text" placeholder="Enter Your Username" name="uname" id="uname" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <!-- Below is the field where the demonstrator enters their password -->
                        <input type="password" placeholder="Enter Password" name="upsw" id="upsw" class="form-control" required>
                    </div>

                    <p id="msg-response" style="color: red; font-size: 10pt;"></p>
                    <button type="submit" class="btn btn-success bttn">Login</button>
                    <button type="button" class="btn btn-info bttn" data-toggle="modal" data-target="#demonModal">How to use...</button> <!-- Button which will trigger the showing of the demonstrator modal -->

                    <hr>

                </div>
            </form>
        </div>

        <div class="modal fade" id="studentModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">How to use...</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <!-- <iframe src="StudentVid.flv" style="border:none; width:100%; height:25%;"></iframe> -->
                        <video width="100%" height="25%" controls>
                        <source src="studentVid.mp4" type="video/mp4">
                        </video>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="demonModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">How to use...</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <video width="100%" height="25%" controls>
                        <source src="demonstratorVid.mp4" type="video/mp4">
                        </video>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

    </body>
</html>