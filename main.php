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

        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

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
            <div class="desk">
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

        <div id="studentTab" class="container table-responsive">
            
            <?php 
            
                if ($_SESSION["accType"] == "student") {
                    // Displaying the student table
                    $result = mysqli_query($connection, "SELECT hr.TicketNo, hr.StudentID, s.studentname, hr.SubWeek, hr.TaskNo, hr.ProblemSeverity, hr.TimeAllocation, hr.bDesc, hr.SeatLocation FROM help_request hr LEFT JOIN students s ON s.StudentID = hr.StudentID WHERE active_check = \"TRUE\" ORDER BY TicketNo ASC") or die (mysqli_error());
                    $count = 1;
                    $studentID = $_SESSION["studentNumber"];

                    echo "<table id=\"studentTable\" class=\"table table-striped\" style=\"text-align:center;\">";
                    echo "<tr> <th scope=\"col\">Current Queue</th> <th scope=\"col\">Ticket Number</th> <th scope=\"col\"></th> </tr>";
                    

                    while($row = mysqli_fetch_array($result)){

                        if ($studentID == $row['StudentID']){
                            echo "<tr class=\"table-success\">";
                            echo '<th scope=\"row\">' . $count . '</th>';
                            echo '<td>' . $row['TicketNo'] . '</td>';
                            echo '<td><button id="tabButton" class="btn btn-warning" name="edit" data-toggle="modal" data-target="#myModal" value=' . $row['TicketNo'] . ' onclick="editItem(this)">Edit</button><button id="tabButton" class="btn btn-danger" name="delete" value=' . $row['TicketNo'] . ' onclick="deleteItem(this)">Delete</button></td>';
                            echo "</tr>";
                        } else{
                            echo "<tr>";
                            echo '<th scope=\"row\">' . $count . '</th>';
                            echo '<td>' . $row['TicketNo'] . '</td>';
                            echo '<td><button id="tabButton" class="btn btn-warning" name="edit" data-toggle="modal" data-target="#myModal" disabled>Edit</button><button id="tabButton" class="btn btn-danger" name="delete" disabled>Delete</button></td>';
                            echo "</tr>";
                        }
                        
                        $count++;

                    }

                    echo "</table>";
                    // need to create javascript function which now populates the modal when the edit button is clicked
                }

                if (($_SESSION["accType"] == "admin") || ($_SESSION["accType"] == "standard")) {
                    // Displaying the demonstrators table
                    $result = mysqli_query($connection, "SELECT hr.TicketNo, hr.StudentID, s.studentname, hr.SubWeek, hr.TaskNo, hr.ProblemSeverity, hr.TimeAllocation, hr.bDesc, hr.SeatLocation FROM help_request hr LEFT JOIN students s ON s.StudentID = hr.StudentID WHERE active_check = \"TRUE\" ORDER BY TicketNo ASC") or die (mysqli_error());
                    $count = 1;

                    echo "<table id=\"studentTable\" class=\"table table-striped\" style=\"text-align:center;\">";
                    echo "<tr> <th scope=\"col\">Current Queue</th> <th scope=\"col\">Ticket Number</th> <th scope=\"col\">Student ID</th> <th scope=\"col\">Student Name</th> <th scope=\"col\">Submission Week</th> <th scope=\"col\">Task Number</th> <th scope=\"col\">Problem Severity</th> <th scope=\"col\">Est. Time Allocation</th> <th scope=\"col\">Problem Description</th> <th scope=\"col\">Seat Location</th> <th scope=\"col\"></th> </tr>";
                    

                    while($row = mysqli_fetch_array($result)){

                        echo "<tr>";
                        echo '<th scope=\"row\">' . $count . '</th>';
                        echo '<td>' . $row['TicketNo'] . '</td>';
                        echo '<td>' . $row['StudentID'] . '</td>';
                        if ($row['studentname'] == ""){
                            echo '<td class="missing">Student no longer available</td>';
                        } else {
                            echo '<td>' . $row['studentname'] . '</td>';
                        }
                        echo '<td>' . $row['SubWeek'] . '</td>';
                        echo '<td>' . $row['TaskNo'] . '</td>';
                        echo '<td>' . $row['ProblemSeverity'] . '</td>';
                        echo '<td>' . $row['TimeAllocation'] . '</td>';
                        echo '<td>' . $row['bDesc'] . '</td>';
                        echo '<td>' . $row['SeatLocation'] . '</td>';
                        echo '<td><button id="tabButton" class="btn btn-success" name="attend" value=' . $row['TicketNo'] . ' onclick="helpStudent(this)">Help Student</button></td>';
                        echo "</tr>";
                        
                        $count++;

                    }

                    echo "</table>";

                }

            ?>
        </div>

        <!-- Bootstrap Modal - used for students to fill out form containing help request data -->
        <!-- add php code to stop demonstrator from opening the modal -->
        <?php 
            
            if ($_SESSION["accType"] == "student") {
        ?>
            <div class="modal fade" id="myModal">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                    
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Help Request Form</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <form id="helpForm" class="class-body" name="help">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="weekSub"><b>Choose the category you need help with:<b style="color: red">*</b></b></label>
                                    <select name="weekSub" id="weekSub" class="form-control" required>
                                        <?php
                                            echo '<option value="">Pick a category...</option>';
                                            $sql = mysqli_query($connection, "SELECT * FROM help_data");
                                            while ($row = mysqli_fetch_assoc($sql)){
                                                echo '<option value="' . $row['Category'] . '">'. $row['Category'] .'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="taskNo"><b>Choose the sub category:<b style="color: red">*</b></b></label>
                                    <select name="taskNo" id="taskNo" class="form-control" required>
                                        <?php
                                            // echo '<option value="">Pick a sub-category...</option>';
                                            // if (isset($_SESSION['option_selected'])){
                                            //     $option = $_SESSION['option_selected'];
                                            //     $sql = mysqli_query($connection, "SELECT * FROM help_data WHERE Category = '$option'");
                                            //     while ($row = mysqli_fetch_assoc($sql)){
                                            //         echo '<option value="' . $row['SubCat'] . '">'. $row['SubCat'] .'</option>';
                                            //     }
                                            //     // When form is submitted or edited, $_SESSION['option_selected'] needs to be destroyed
                                            // } else {
                                            //     echo '<option value="">Please pick a primary category first...</option>';
                                            // }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="severity"><b>Select Problem Severity:<b style="color: red">*</b></b></label>
                                    <select name="severity" id="severity" class="form-control" required>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="time"><b>Time Allocation Needed for Task:<b style="color: red">*</b></b></label>
                                    <select name="time" id="time" class="form-control" required>
                                        <option value="5">5 Minutes</option>
                                        <option value="10">10 Minutes</option>
                                        <option value="15">15 Minutes</option>
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
                                <button type="submit" id="submitButton" name="submit" class="btn btn-success">Submit Request</button>
                                <button type="button" id="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="modal fade" id="responseModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">System Info</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div id="modalText" class="modal-body"></div>

                </div>
            </div>
        </div>

    </body>
</html>