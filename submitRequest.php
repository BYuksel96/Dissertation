<?php
    /*
    * This file is used to submit a students help request ticket.
    * The form data (Student help request form) is taken, stored in vars and then posted to the help_request table in the DB.
    * This file is also used to edit a students help request ticket (If they click on the edit button located next to their ticket).
    * This file is also used to check that students are not submitting more than one ticket (checks to see if they currently have an active ticket in the system).
    * This file is also used to check that there is only 1 active ticket per seat location (excl. side tables).
    */

    include('connection.php');
    session_start();

    $stuNum = $_SESSION["studentNumber"];
    if (isset($_SESSION["editItem"])){ // Checking if the edit session variable has been set
        $editCheck = $_SESSION["editItem"]; // Storing edit session variable in a var
        $ticket = $_SESSION["ticketNo"]; // Storing students help request ticket number in a var
    } else {
        $editCheck = "";
    }

    if(isset($_POST['weekSub'])){
        // Storing values of the data in the help request form in variables
        $categoryField = mysqli_real_escape_string($connection, $_POST['weekSub']); 
        $subcategoryField = mysqli_real_escape_string($connection, $_POST['taskNo']);
        $field3 = mysqli_real_escape_string($connection, $_POST['severity']); // Currently not an option available in the form but may be put back in, in future iterations
        $field4 = mysqli_real_escape_string($connection, $_POST['time']); // Currently not an option available in the form but may be put back in, in future iterations
        $shortDesc = mysqli_real_escape_string($connection, $_POST['description']); 
        $seatPosition = mysqli_real_escape_string($connection, $_POST['seat']);

        // If the editcheck variable value is 'true' then the form data is used to update an active ticket, as the studenmts wants to edit their current help request
        if ($editCheck == "true"){
            if ($seatPosition == "Side 1" || $seatPosition == "Side 2" || $seatPosition == "Side 3"){
                $sqlQuery = "UPDATE help_request SET SubWeek='$categoryField', TaskNo='$subcategoryField', ProblemSeverity='$field3', TimeAllocation='$field4', bDesc ='$shortDesc' WHERE TicketNo = '$ticket' AND SeatLocation = '$seatPosition' AND StudentID = '$stuNum'";
        
                if (mysqli_query($connection, $sqlQuery)){
                    $_SESSION["ticketNo"] = "";
                    $response = json_encode(array('type' => 'success', 'text' => 'Update successful')); //message to send back to client side
                    $_SESSION["editItem"] = "";
                    die($response);
                } else {
                    $response = json_encode(array('type' => 'error', 'text' => 'Update unsuccessful')); //message to send back to client side
                    $_SESSION["editItem"] = "";
                    die($response);
                }
            } else {
                $seatCheck = mysqli_query($connection, "SELECT SeatLocation FROM help_request WHERE TicketNo = '$ticket' AND SeatLocation = '$seatPosition' AND StudentID = '$stuNum'"); // Checking that the correct student is editting the data for the provided ticket number
                if(mysqli_num_rows($seatCheck) != 0) {
                    
                    $sqlQuery = "UPDATE help_request SET SubWeek='$categoryField', TaskNo='$subcategoryField', ProblemSeverity='$field3', TimeAllocation='$field4', bDesc ='$shortDesc' WHERE TicketNo = '$ticket' AND SeatLocation = '$seatPosition' AND StudentID = '$stuNum'";
        
                    if (mysqli_query($connection, $sqlQuery)){
                        $_SESSION["ticketNo"] = "";
                        $response = json_encode(array('type' => 'success', 'text' => 'Update successful')); //message to send back to client side
                        $_SESSION["editItem"] = "";
                        die($response);
                    } else {
                        $response = json_encode(array('type' => 'error', 'text' => 'Update unsuccessful')); //message to send back to client side
                        $_SESSION["editItem"] = "";
                        die($response);
                    }
                }else{
                    $response = json_encode(array('type' => 'error', 'text' => 'Cannot carry out this action as you have selected someone elses seat')); //message to send back to client side
                    $_SESSION["editItem"] = "";
                    die($response);
                }
            }
        } else {
            // checking if the student already has an active help request ticket in the queue
            $weekCheck = mysqli_query($connection, "SELECT * FROM help_request WHERE StudentID IN (SELECT students.StudentID FROM students WHERE students.StudentID = '$stuNum') AND active_check = \"TRUE\" "); //checking if username already exists in db
            if(mysqli_num_rows($weekCheck) != 0) {
                $response = json_encode(array('type' => 'error', 'text' => 'You currently have an active request... Check table below...')); //message to send back to client side
                die($response);
            }
            else {
                // if statement used to allow multiple tickets to be active on the side tables
                if ($seatPosition == "Side 1" || $seatPosition == "Side 2" || $seatPosition == "Side 3"){
                    $field7 = "TRUE";
                    $time = "00:00:00";
                    $sql = mysqli_query($connection, "INSERT INTO help_request(StudentID, SubWeek, TaskNo, ProblemSeverity, TimeAllocation, bDesc, SeatLocation, active_check, TimeOfRequest, TimeOfHelp, TimeHelpFinished, DateOfRequest) VALUES ('$stuNum','$categoryField','$subcategoryField','$field3','$field4','$shortDesc','$seatPosition','$field7',NOW(),'$time','$time',NOW())");
                    if(!$sql) {
                        $output = "Error" . mysqli_error();
                        $response = json_encode(array('type' => 'error', 'text' => $output));
                        die($response);
                    }
                    else {
                        $response = json_encode(array('type' => 'success', 'text' => 'Success: You are now in the queue!'));
                        die($response);
                    }
                } else {
                    $seatCheck = mysqli_query($connection, "SELECT SeatLocation FROM help_request WHERE SeatLocation = '$seatPosition' AND active_check = \"TRUE\""); // Checking that someone isn't submitting a request in an already taken seat
                    if(mysqli_num_rows($seatCheck) == "0") {
                        $field7 = "TRUE";
                        $time = "00:00:00";
                        $sql = mysqli_query($connection, "INSERT INTO help_request(StudentID, SubWeek, TaskNo, ProblemSeverity, TimeAllocation, bDesc, SeatLocation, active_check, TimeOfRequest, TimeOfHelp, TimeHelpFinished, DateOfRequest) VALUES ('$stuNum','$categoryField','$subcategoryField','$field3','$field4','$shortDesc','$seatPosition','$field7',NOW(),'$time','$time',NOW())");
                        if(!$sql) {
                            $output = "Error" . mysqli_error();
                            $response = json_encode(array('type' => 'error', 'text' => $output));
                            die($response);
                        }
                        else {
                            $response = json_encode(array('type' => 'success', 'text' => 'Success: You are now in the queue!'));
                            die($response);
                        }
                    } else {
                        $response = json_encode(array('type' => 'error', 'text' => 'Cannot carry out this action as that seat is taken')); //message to send back to client side
                        die($response);
                    }
                }
            }
        }
    }
    mysqli_close($connection);
?>