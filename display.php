<?php
    /*
    * File used to display queue of students on the big screen only
    */

    include('connection.php');
    session_start();

    // Checking if demonstrator login session is set
    if(!isset($_SESSION['demonstrator'])){
        header("location:login.php");
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Queue Display</title>

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
        <script type="text/javascript" src="js/display.js"></script> <!-- Importing external js file -->
        
    </head>

    <body class="container-fluid" onload="buttonDisable()"> <!-- On page load buttonDisable() function is called to disable the seats for demonstrator account types -->
        <!-- Navigation bar -->
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            <h1 style="font-size: 25px;">Current Queue</h1>
            <ul class="nav navbar-nav ml-auto">
                <!-- PHP code below used to specifically toggle showing the account/admin button to only the demonstrators/helpers accounts -->
                <?php if (isset($_SESSION['demonstrator'])) { ?><li><a class="nav-link" href="main.php"><i class="fa fa-arrow-left"></i> Main</a></li><?php } ?>
                <?php if ($_SESSION["accType"] == "standard") { ?><li><a class="nav-link" href="account.php"><i class="fa fa-user-circle"></i> Account</a></li><?php } ?>
                <li><a class="nav-link" href="logout.php" style="color: red; font-weight: bold;"><i class="fa fa-sign-out"></i> Logout</a></li>
            </ul>
        </nav>
        <div id="displayTab" class="container-fluid table-responsive">
            
            <?php 
                if (($_SESSION["accType"] == "admin") || ($_SESSION["accType"] == "standard")) {
                    $result = mysqli_query($connection, "SELECT hr.TicketNo, hr.StudentID, s.studentname, hr.SubWeek, hr.TaskNo, hr.ProblemSeverity, hr.TimeAllocation, hr.bDesc, hr.SeatLocation, hr.active_check FROM help_request hr LEFT JOIN students s ON s.StudentID = hr.StudentID WHERE hr.active_check = 'TRUE' OR hr.active_check = 'ASSISTANCE' ORDER BY TicketNo ASC") or die (mysqli_error());
                    $count = 1;
    
                    echo "<table id=\"studentTable\" class=\"table table-striped\" style=\"text-align:center;\">";
                    echo "<tr> <th colspan=\"7\" scope=\"col\">Queue Table</th> </tr>";
                    echo "<tr> <th scope=\"col\">Current Queue</th> <th scope=\"col\">Ticket Number</th> <th scope=\"col\">Student ID</th> <th scope=\"col\">Chosen Task Category</th> <th scope=\"col\">Subcategory</th> <th scope=\"col\">Problem Description</th> <th scope=\"col\">Seat Location</th> </tr>";
                    
                    while($row = mysqli_fetch_array($result)){
                        if ($row['active_check'] == "ASSISTANCE"){ // Checking if any helper needs assistance
                            echo "<tr class=\"table-danger\">"; // Setting the background colour of this row in the table to red
                            echo '<th scope=\"row\">' . $count . '</th>';
                            echo '<td>' . $row['TicketNo'] . '</td>';
                            echo '<td>' . $row['StudentID'] . '</td>';
                            echo '<td>' . $row['SubWeek'] . '</td>';
                            echo '<td>' . $row['TaskNo'] . '</td>';
                            echo '<td>' . $row['bDesc'] . '</td>';
                            echo '<td>' . $row['SeatLocation'] . '</td>';
                            echo "</tr>";
                        } else {
                            echo "<tr>";
                            echo '<th scope=\"row\">' . $count . '</th>';
                            echo '<td>' . $row['TicketNo'] . '</td>';
                            echo '<td>' . $row['StudentID'] . '</td>';
                            echo '<td>' . $row['SubWeek'] . '</td>';
                            echo '<td>' . $row['TaskNo'] . '</td>';
                            echo '<td>' . $row['bDesc'] . '</td>';
                            echo '<td>' . $row['SeatLocation'] . '</td>';
                            echo "</tr>";
                        }
                        
                        $count++;

                    }
    
                    echo "</table>";

                }

            ?>
        </div>
    </body>
</html>