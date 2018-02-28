<?php
    
?>
<html>
    <head>
        <title>Login</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <script src="js/login.js"></script>
    </head>

    <body class="container-fluid">
    <div class="login">
            <div class="student">
                <a href="" class="active" id="student-form">Student</a>
            </div>
            <div class="demonstrator">
                <a href="" id="demon-form">Demonstrator</a>
            </div>
            <br>
            <form action="" method="post" name="loginStu" id="student-login-form">
                <div class="container-fluid">

                    <hr>

                    <div class="form-group">
                        <input type="text" placeholder="Enter Your Name" name="name" id="name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" placeholder="Enter Student Number" name="stuNum" id="stuNum" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Login</button>
                    <button type="button" class="btn btn-info">Further Info</button>
                    
                    <hr>

                </div>
            </form>
            <form action="" method="post" name="loginDem" id="demon-login-form" style="display: none;">
                <div class="container-fluid">

                    <hr>

                    <div class="form-group">
                        <input type="text" placeholder="Enter Your Username" name="uname" id="uname" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <input type="password" placeholder="Enter Password" name="upsw" id="upsw" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Login</button>
                    <button type="button" class="btn btn-info">Further Info</button>

                    <hr>

                </div>
            </form>
        </div>
    </body>
</html>