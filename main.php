<?php
    include('connection.php');

    session_start();

    // Checking if login sessions are set, if not the user is redirected to the login page
    if(!isset($_SESSION['demonstrator'])){
        if(!isset($_SESSION['studentNumber'])){
            header("location:login.php");
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Help Request</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" type="image/x-icon" href="bufavicon.ico" />

        <!-- Importing stylesheets and ajax etc. -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="css/main.css"> <!-- Importing external css file -->
        <script type="text/javascript" src="js/main.js"></script> <!-- Importing external js file -->

    </head>

    <body class="container-fluid" onload="buttonDisable()"> <!-- On page load buttonDisable() function is called to disable the seats for demonstrator users -->
        <!-- Navigation bar -->
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            <ul class="nav navbar-nav ml-auto">
                <!-- PHP code below used to specifically toggle showing the account button to only the demonstrators/helpers accounts -->
                <?php if (($_SESSION["accType"] == "admin") || ($_SESSION["accType"] == "standard")) { ?><li><a class="nav-link" href="account.php"><i class="fa fa-user-circle"></i> Account</a></li><?php } ?>
                <li><a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </nav>

        <div class="layout"> <!-- This div defines the box which the room layout is contained within -->
            <div id="tableA" class="desk"> <!-- These type of div tags identify a table -->
                <div class="seats">
                    A
                </div>
                <div class="seats">
                    <!-- Each seat is a button. Once pressed the value of the button is used to populate the help request form field called "Seat" -->
                    <!-- Clicking a seat button also triggers the help request form modal to pop-up on the screen -->
                    <button type="submit" id="tabVert1" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="A1" onclick="addSeat(this)">1</button>
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert2" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="A2" onclick="addSeat(this)">2</button>
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert3" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="A3" onclick="addSeat(this)">3</button>
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert4" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="A4" onclick="addSeat(this)">4</button>
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert5" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="A5" onclick="addSeat(this)">5</button>
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert6" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="A6" onclick="addSeat(this)">6</button>
                </div>
            </div>
            <div id="tableB" class="desk">
                <div class="seats">
                    B
                </div>
                <div class="seats">
                    <button type="submit" id="seat1" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="B1" onclick="addSeat(this)">1</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat2" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="B2" onclick="addSeat(this)">2</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat3" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="B3" onclick="addSeat(this)">3</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat4" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="B4" onclick="addSeat(this)">4</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat5" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="B5" onclick="addSeat(this)">5</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat6" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="B6" onclick="addSeat(this)">6</button>
                </div>
            </div>
            <div id="tableC" class="desk">
                <div class="seats">
                    C
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert1" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="C1" onclick="addSeat(this)">1</button>
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert2" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="C2" onclick="addSeat(this)">2</button>
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert3" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="C3" onclick="addSeat(this)">3</button>
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert4" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="C4" onclick="addSeat(this)">4</button>
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert5" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="C5" onclick="addSeat(this)">5</button>
                </div>
                <div class="seats">
                    <button type="submit" id="tabVert6" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="C6" onclick="addSeat(this)">6</button>
                </div>
            </div>
            <div id="tableD" class="desk">
                <div class="seats">
                    D
                </div>
                <div class="seats">
                    <button type="submit" id="seat1" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="D1" onclick="addSeat(this)">1</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat2" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="D2" onclick="addSeat(this)">2</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat3" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="D3" onclick="addSeat(this)">3</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat4" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="D4" onclick="addSeat(this)">4</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat5" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="D5" onclick="addSeat(this)">5</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat6" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="D6" onclick="addSeat(this)">6</button>
                </div>
            </div>
            <div id="tableE" class="desk">
                <div class="seats">
                    E
                </div>
                <div class="seats">
                    <button type="submit" id="seat1" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="E1" onclick="addSeat(this)">1</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat2" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="E2" onclick="addSeat(this)">2</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat3" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="E3" onclick="addSeat(this)">3</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat4" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="E4" onclick="addSeat(this)">4</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat5" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="E5" onclick="addSeat(this)">5</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat6" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="E6" onclick="addSeat(this)">6</button>
                </div>
            </div>
            <div id="tableF" class="desk">
                <div class="seats">
                    F
                </div>
                <div class="seats">
                    <button type="submit" id="seat1" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="F1" onclick="addSeat(this)">1</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat2" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="F2" onclick="addSeat(this)">2</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat3" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="F3" onclick="addSeat(this)">3</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat4" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="F4" onclick="addSeat(this)">4</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat5" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="F5" onclick="addSeat(this)">5</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat6" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="F6" onclick="addSeat(this)">6</button>
                </div>
            </div>
            <div id="tableG" class="desk">
                <div class="seats">
                    G
                </div>
                <div class="seats">
                    <button type="submit" id="seat1" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="G1" onclick="addSeat(this)">1</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat2" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="G2" onclick="addSeat(this)">2</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat3" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="G3" onclick="addSeat(this)">3</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat4" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="G4" onclick="addSeat(this)">4</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat5" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="G5" onclick="addSeat(this)">5</button>
                </div>
                <div class="seats">
                    <button type="submit" id="seat6" class="btn btn-outline-success seat" data-toggle="modal" data-target="#myModal" value="G6" onclick="addSeat(this)">6</button>
                </div>
            </div>
        </div>

        <div id="studentTab" class="container-fluid table-responsive">
            
            <?php 
            // The php code is used to help show the queue table.
            // There are two different tables which can be displayed. One is for the students and one if for the demonstrators
            // It is differentiate by using the accType session variable
            
                if ($_SESSION["accType"] == "student") {
                    // Displaying the student table
                    $result = mysqli_query($connection, "SELECT hr.TicketNo, hr.StudentID, s.studentname, hr.SubWeek, hr.TaskNo, hr.ProblemSeverity, hr.TimeAllocation, hr.bDesc, hr.SeatLocation FROM help_request hr LEFT JOIN students s ON s.StudentID = hr.StudentID WHERE active_check = \"TRUE\" ORDER BY TicketNo ASC") or die (mysqli_error());
                    $count = 1;
                    $studentID = $_SESSION["studentNumber"];

                    echo "<table id=\"studentTable\" class=\"table table-striped\" style=\"text-align:center;\">";
                    echo "<tr> <th scope=\"col\">Current Queue</th> <th scope=\"col\">Ticket Number</th> <th scope=\"col\"></th> </tr>";
                    

                    while($row = mysqli_fetch_array($result)){

                        if ($studentID == $row['StudentID']){ // If ticket in the queue belongs to a student then a clickable 'edit' and 'delete' button will appear alongside their help request
                            echo "<tr class=\"table-success\">";
                            echo '<th scope=\"row\">' . $count . '</th>';
                            echo '<td>' . $row['TicketNo'] . '</td>';
                            echo '<td><button id="tabButton" class="btn btn-warning" name="edit" data-toggle="modal" data-target="#myModal" value=' . $row['TicketNo'] . ' onclick="editItem(this)">Edit</button><button id="tabButton" class="btn btn-danger" name="delete" value=' . $row['TicketNo'] . ' onclick="deleteItem(this)">Delete</button></td>';
                            echo "</tr>";
                        } else{ // If a ticket in the queue doesn't belong to the student then the 'edit' and 'delete' buttons are disabled
                            echo "<tr>";
                            echo '<th scope=\"row\">' . $count . '</th>';
                            echo '<td>' . $row['TicketNo'] . '</td>';
                            echo '<td><button id="tabButton" class="btn btn-warning" name="edit" data-toggle="modal" data-target="#myModal" disabled>Edit</button><button id="tabButton" class="btn btn-danger" name="delete" disabled>Delete</button></td>';
                            echo "</tr>";
                        }
                        
                        $count++;

                    }

                    echo "</table>";

                }

                if (($_SESSION["accType"] == "admin") || ($_SESSION["accType"] == "standard")) {
                    // Displaying the demonstrators table
                    $result = mysqli_query($connection, "SELECT hr.TicketNo, hr.StudentID, s.studentname, hr.SubWeek, hr.TaskNo, hr.ProblemSeverity, hr.TimeAllocation, hr.bDesc, hr.SeatLocation FROM help_request hr LEFT JOIN students s ON s.StudentID = hr.StudentID WHERE active_check = \"TRUE\" ORDER BY TicketNo ASC") or die (mysqli_error());
                    $count = 1;

                    echo "<table id=\"studentTable\" class=\"table table-striped tabWide\" style=\"text-align:center;\">";
                    echo "<tr> <th scope=\"col\">Current Queue</th> <th scope=\"col\">Ticket Number</th> <th scope=\"col\">Student ID</th> <th scope=\"col\">Student Name</th> <th scope=\"col\">Submission Week</th> <th scope=\"col\">Task Number</th> <th scope=\"col\">Problem Severity</th> <th scope=\"col\">Est. Time Allocation</th> <th scope=\"col\">Problem Description</th> <th scope=\"col\">Seat Location</th> <th scope=\"col\"></th> </tr>";
                    

                    while($row = mysqli_fetch_array($result)){

                        echo "<tr>";
                        echo '<th scope=\"row\">' . $count . '</th>';
                        echo '<td>' . $row['TicketNo'] . '</td>';
                        echo '<td>' . $row['StudentID'] . '</td>';
                        if ($row['studentname'] == ""){ // If the student is no longer active in the system (i.e. has logged out) then the Demonstrator will be informed of this
                            echo '<td class="missing">Student no longer available</td>';
                        } else { // Otherwise the students name will be visible to the demonstrator
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
        <?php 
            if ($_SESSION["accType"] == "student") { // PHP code used to make sure only students can access this modal form
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
                                        <!-- This section is populated via main.js -->
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

        <!-- Below is a response modal. All responses from the server will be displayed in here to the user -->
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