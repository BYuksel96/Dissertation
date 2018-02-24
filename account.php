<?php
    include('connection.php');

?>

<html>
    <header>
        <title>Account</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/account.css">
    </header>

    <body class="container-fluid">

        <div class="accountInfo">

        </div>

        <div class="changePsw">
                
        </div>

        <div class="createAcc">
            <form action="createAcc.php" method="post" name="createAccount" style="border:1px solid #ccc">
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
                            <option value="stnd">Standard Account</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Create Account</button>

                </div>
            </form>
        </div>
    </body>
</html>