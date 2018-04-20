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

        <link rel="shortcut icon" type="image/x-icon" href="bufavicon.ico" />

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
                <li><a class="nav-link" href="main.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a class="nav-link" href="logout.php"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </nav>

        <div id="accordion">

            <div class="card" data-value="c1">
                <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <div class="card-header">
                        Account Info
                        <i class="fa fa-angle-down c1" id="down" style="font-size: 200%; position: relative; float: right;"></i>
                        <i class="fa fa-angle-up c1" id="up" style="font-size: 200%; position: relative; float: right; display: none;"></i>
                    </div>
                </a>
                <div id="collapseOne" class="collapse card-body">
                    <p>account info goes here - to be done<p>
                </div>
            </div>

            <div class="gap"></div>

            <div class="card" data-value="c2">
                <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                    <div class="card-header">
                        Change Password
                        <i class="fa fa-angle-down c2" style="font-size: 200%; position: relative; float: right;"></i>
                        <i class="fa fa-angle-up c2" style="font-size: 200%; position: relative; float: right; display: none;"></i>
                    </div>
                </a>
                <div id="collapseTwo" class="collapse">
                    <form id="changePSW" class="card-body" name="changePSW">
                        <div class="container-fluid">
                            <p>If you wish to change your password, you can do so here. Simply fill out the required fields and press the change password button once you are done.</p>
                            <p style="color:red;">* Required fields</p>
                            <hr class="formHR">

                            <div class="form-group">
                                <input type="password" placeholder="Enter your current password *" name="oldpsw" id="oldpsw" class="form-control" required>
                                <p id="msg-responsepsw" style="font-size: 10pt;"></p>
                            </div>
                            
                            <div class="form-group">
                                <input type="password" placeholder="Enter New Password *" name="new" id="new" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <input type="password" placeholder="Confirm Password *" name="repeat" id="repeat" class="form-control" required>
                            </div>

                            <p id="msg-response3" style="font-size: 10pt;"></p>
                            <button type="submit" id="submitPsw" class="btn btn-success">Change Password</button>

                        </div>
                    </form>
                </div>
            </div>

            <div class="gap"></div>

            <?php if ($_SESSION["accType"] == "admin") { ?>

                <div class="card" data-value="c3">
                    <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        <div class="card-header">
                            Create Account
                            <i class="fa fa-angle-down c3" style="font-size: 200%; position: relative; float: right;"></i>
                            <i class="fa fa-angle-up c3" style="font-size: 200%; position: relative; float: right; display: none;"></i>
                        </div>
                    </a>
                    <div id="collapseThree" class="collapse">
                        <form id="crtAcc" class="card-body" name="crtAcc">
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

                <div class="card" data-value="c4">
                    <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseDelete">
                        <div class="card-header">
                            Delete Helper Account
                            <i class="fa fa-angle-down c4" style="font-size: 200%; position: relative; float: right;"></i>
                            <i class="fa fa-angle-up c4" style="font-size: 200%; position: relative; float: right; display: none;"></i>
                        </div>
                    </a>
                    <div id="collapseDelete" class="collapse card-body table-responsive">
                        <p id="msg-response-delete" style="font-size: 10pt;"></p>
                        <hr class="formHR">
                        
                        <?php
                            $result = mysqli_query($connection, "SELECT * FROM users WHERE 1") or die (mysqli_error());
                            echo "<table id=\"demonTable\" class=\"table table-striped\" style=\"text-align:center;\">";
                            echo "<tr> <th scope=\"col\">Username</th> <th scope=\"col\"></th> </tr>";

                            while($row = mysqli_fetch_array($result)){

                                echo "<tr>";
                                echo '<td>' . $row['Username'] . '</td>';
                                echo '<td><button id="tabButton" class="btn btn-danger" name="delete" value=' . $row['ID'] . ' onclick="deleteAccount(this)">Remove Helper</button></td>';
                                echo "</tr>";
        
                            }
        
                            echo "</table>";
                        ?>

                    </div>
                </div>

                <div class="gap"></div>

                <div class="card" data-value="c5">
                    <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseStudents">
                        <div class="card-header">
                            Students Active In System
                            <i class="fa fa-angle-down c5" style="font-size: 200%; position: relative; float: right;"></i>
                            <i class="fa fa-angle-up c5" style="font-size: 200%; position: relative; float: right; display: none;"></i>
                        </div>
                    </a>
                    <div id="collapseStudents" class="collapse card-body table-responsive">

                        <p id="msg-response-logout" style="font-size: 10pt;"></p>
                        <hr class="formHR">
                        
                        <?php
                            $result = mysqli_query($connection, "SELECT * FROM students WHERE 1") or die (mysqli_error());
                            echo "<table id=\"loginTable\" class=\"table table-striped\" style=\"text-align:center;\">";
                            echo "<tr> <th scope=\"col\">Student Number</th> <th scope=\"col\">Student Name</th> <th scope=\"col\"></th> </tr>";

                            while($row = mysqli_fetch_array($result)){

                                echo "<tr>";
                                echo '<td>' . $row['StudentID'] . '</td>';
                                echo '<td>' . $row['studentname'] . '</td>';
                                echo '<td><button id="tabButton" class="btn btn-danger" name="delete" value=' . $row['StudentID'] . ' onclick="manualLogout(this)">Logout Student</button></td>';
                                echo "</tr>";
        
                            }
        
                            echo "</table>";
                        ?>

                    </div>
                </div>

                <div class="gap"></div>

                <div class="card" data-value="c6">
                    <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseCompleted">
                        <div class="card-header">
                            Completed Requests
                            <i class="fa fa-angle-down c6" style="font-size: 200%; position: relative; float: right;"></i>
                            <i class="fa fa-angle-up c6" style="font-size: 200%; position: relative; float: right; display: none;"></i>
                        </div>
                    </a>
                    <div id="collapseCompleted" class="collapse">
                        <div class="card-body">
                            <div style="text-align:center;">
                                <button id="reset" class="btn btn-info">Reset System</button>
                                <a href="tableToCSV.php"><button id="tab2CSV"  class="btn btn-info">Download to CSV</button></a>
                                <hr class="formHR">
                                <div class="container table-responsive">
                                    <?php
                                        //Query below is used to acquire a list of all the help requests which have been completed (Displays who helped with the reuqest, student id, etc.)
                                        $result = mysqli_query($connection, "SELECT u.Username, hc.student_id, hc.ticket_no, hr.SubWeek, hr.TaskNo, hr.ProblemSeverity, hr.TimeAllocation, hr.bDesc, hr.SeatLocation, hr.TimeOfRequest, hr.TimeOfHelp, hr.DateOfRequest FROM help_completed hc LEFT JOIN help_request hr ON hr.TicketNo = hc.ticket_no AND hr.active_check = 'FALSE' LEFT JOIN users u ON u.ID = hc.users_id ORDER BY hc.ticket_no") or die (mysqli_error());
                                        echo "<table id=\"completedTable\" class=\"table table-striped tabWide\" style=\"text-align:center;\">";
                                        echo "<tr> <th scope=\"col\">Assisted By</th> <th scope=\"col\">Student Number</th> <th scope=\"col\">Ticket No.</th> <th scope=\"col\">Chosen Category</th> <th scope=\"col\">Sub Category</th> <th scope=\"col\">Problem Severity</th> <th scope=\"col\">Time Allocation</th> <th scope=\"col\">Description</th> <th scope=\"col\">Seat Location</th> <th scope=\"col\">Time Of Request</th> <th scope=\"col\">Time Help Arrived</th> <th scope=\"col\">Date of Request</th> </tr>";
                                    
                                        while($row = mysqli_fetch_array($result)){

                                            echo "<tr>";
                                            echo '<td>' . $row['Username'] . '</td>';
                                            echo '<td>' . $row['student_id'] . '</td>';
                                            echo '<td>' . $row['ticket_no'] . '</td>';
                                            echo '<td>' . $row['SubWeek'] . '</td>';
                                            echo '<td>' . $row['TaskNo'] . '</td>';
                                            echo '<td>' . $row['ProblemSeverity'] . '</td>';
                                            echo '<td>' . $row['TimeAllocation'] . '</td>';
                                            echo '<td>' . $row['bDesc'] . '</td>';
                                            echo '<td>' . $row['SeatLocation'] . '</td>';
                                            echo '<td>' . $row['TimeOfRequest'] . '</td>';
                                            echo '<td>' . $row['TimeOfHelp'] . '</td>';
                                            echo '<td>' . $row['DateOfRequest'] . '</td>';
                                            echo "</tr>";
                    
                                        }
                    
                                        echo "</table>";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="gap"></div>

                <div class="card" data-value="c7">
                    <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                        <div class="card-header">
                            Help Request Data
                            <i class="fa fa-angle-down c7" style="font-size: 200%; position: relative; float: right;"></i>
                            <i class="fa fa-angle-up c7" style="font-size: 200%; position: relative; float: right; display: none;"></i>
                        </div>
                    </a>
                    <div id="collapseFour" class="collapse">
                        <form id="addData" class="card-body" name="addData">
                            <div class="container-fluid">
                                <p>The form below is where you can supply the help request data that students use to fill out their forms.</p>
                                <hr class="formHR">

                                <div class="form-group">
                                    <label for="category"><b>Enter Category Name:</b></label>
                                    <input type="text" placeholder="Enter data here" name="category" id="category" class="form-control" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="subcat"><b>Enter All Sub Categories Sepreated With Commas: (Example: Task 1,Task 2,Task 3)</b></label>
                                    <input type="text" placeholder="Enter data here" name="subcat" id="subcat" class="form-control" required>
                                </div>

                                <p id="msg-response2" style="color: green; font-size: 10pt;"></p>
                                <button type="submit" id="submitButton" class="btn btn-success">Add data</button>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="gap"></div>

                <div class="card" data-value="c8">
                    <a class="collapsed card-link" data-toggle="collapse" data-parent="#accordion" href="#collapseRoD">
                        <div class="card-header">
                            Reset Or Delete: Help Request Data
                            <i class="fa fa-angle-down c8" style="font-size: 200%; position: relative; float: right;"></i>
                            <i class="fa fa-angle-up c8" style="font-size: 200%; position: relative; float: right; display: none;"></i>
                        </div>
                    </a>
                    <div id="collapseRoD" class="collapse">
                        <div class="card-body">
                            <p>Use the table below to completey reset or delete specific help request data which has been provided into the system.</p>
                            <p id="msg-response-dataTbl" style="color: green; font-size: 10pt;"></p>
                            <hr class="formHR">
                            <div class="container table-responsive">
                                <?php
                                    //Query below is used to acquire a list of all the help requests which have been completed (Displays who helped with the reuqest, student id, etc.)
                                    $result = mysqli_query($connection, "SELECT hd.ID, u.Username, hd.Category, hd.SubCat FROM help_data hd LEFT JOIN users u ON u.ID = hd.users_id ORDER BY hd.Category") or die (mysqli_error());
                                    echo "<table id=\"dataTable\" class=\"table table-striped tabWide\" style=\"text-align:center;\">";
                                    echo "<tr> <th scope=\"col\">Submited By</th> <th scope=\"col\">Category</th> <th scope=\"col\">Sub Category</th> <th scope=\"col\"><button id=\"resetData\" class=\"btn btn-info\" name=\"Reset Data\" value='reset' onclick=\"resetData(this)\">Reset Data</button></th> </tr>";
                                
                                    while($row = mysqli_fetch_array($result)){

                                        echo "<tr>";
                                        echo '<td>' . $row['Username'] . '</td>';
                                        echo '<td>' . $row['Category'] . '</td>';
                                        echo '<td>' . $row['SubCat'] . '</td>';
                                        echo '<td> <button id="tabButton" class="btn btn-danger" name="Remove Entry" value=' . $row['ID'] . ' onclick="removeData(this)">Remove This Entry</button> </td>';
                                        echo "</tr>";
                
                                    }
                
                                    echo "</table>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>

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