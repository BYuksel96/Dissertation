<?php
    include('connection.php');

    session_start();

    if(!isset($_SESSION['demonstrator'])){
        if(!isset($_SESSION['studentNumber'])){
            header("location:login.php");
        }
    }

?>

<html>
    <head>
        <title>Help Request</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        
    </head>

    <body class="container-fluid">
    <nav class="navbar navbar-expand-sm bg-light navbar-light">
        <ul class="nav navbar-nav ml-auto">
            <li><a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
    </nav>
    <h1>hello</h1>
    <a href="account.php">Account</a>
    <p><?php echo $_SESSION['accType'] ?></p>
    </body>
</html>