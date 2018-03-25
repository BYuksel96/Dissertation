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
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <script type="text/javascript" src="js/main.js"></script>

    </head>

    <body class="container-fluid" onload="buttonDisable()">
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            <ul class="nav navbar-nav ml-auto">
                <?php if (($_SESSION["accType"] == "admin") || ($_SESSION["accType"] == "standard")) { ?><li><a class="nav-link" href="account.php"><i class="fa fa-user-circle"></i> Account</a></li><?php } ?>
                <li><a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </nav>

        <div class="center">
            <div class="table">
                <div class="seats">
                    A
                </div>
                <div class="seats">
                    <button type="submit" id="seat1" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal" value="A1" onclick="addSeat(this)">1</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat2" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal" value="A2" onclick="addSeat(this)">2</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat3" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal" value="A3" onclick="addSeat(this)">3</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat4" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal" value="A4" onclick="addSeat(this)">4</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat5" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal" value="A5" onclick="addSeat(this)">5</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat6" class="btn btn-outline-success" data-toggle="modal" data-target="#myModal" value="A6" onclick="addSeat(this)">6</button>
                </div>
            </div>
        </div>

        <!-- Now need to display the table for students -->
        <?php if ($_SESSION["accType"] == "student") { ?>
            
            

        <?php } ?>

        <!-- Bootstrap Modal - used for students to fill out form containing help request data -->

        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Help Request Form</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    
                    <form id="help" class="class-body" name="help">
                        <!-- Modal body -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="weekSub"><b>Choose the category you need help with:<b style="color: red">*</b></b></label>
                                <select name="weekSub" id="weekSub" class="form-control" required>
                                    <option value="admin">Admin Account</option>
                                    <option value="standard">Standard Account</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="taskNo"><b>Choose the sub category:<b style="color: red">*</b></b></label>
                                <select name="taskNo" id="taskNo" class="form-control" required>
                                    <option value="admin">Admin Account</option>
                                    <option value="standard">Standard Account</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="severity"><b>Select Problem Severity:<b style="color: red">*</b></b></label>
                                <select name="severity" id="severity" class="form-control" required>
                                    <option value="admin">Admin Account</option>
                                    <option value="standard">Standard Account</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="time"><b>Time Allocation for Task:<b style="color: red">*</b></b></label>
                                <select name="time" id="time" class="form-control" required>
                                    <option value="admin">Admin Account</option>
                                    <option value="standard">Standard Account</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description"><b>Brief Problem Description:</b></label>
                                <input type="text" placeholder="Description" name="description" id="description" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="seat"><b>Seat:</b></label>
                                <input type="text" id="seatFill" name="seat" id="seat" class="form-control" readonly>
                            </div>
                        </div>
                        
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <p id="msg-response2" style="color: green; font-size: 10pt;"></p>
                            <button type="submit" id="submitButton" class="btn btn-success">Submit Request</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </body>
</html>