<?php
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
        $field1 = mysqli_real_escape_string($connection, $_POST['weekSub']); 
        $field2 = mysqli_real_escape_string($connection, $_POST['taskNo']);
        $field3 = mysqli_real_escape_string($connection, $_POST['severity']); 
        $field4 = mysqli_real_escape_string($connection, $_POST['time']);
        $field5 = mysqli_real_escape_string($connection, $_POST['description']); 
        $field6 = mysqli_real_escape_string($connection, $_POST['seat']);

        // If the editcheck variable value is 'true' then the form is to use an update query, as the studenmts wants to edit their current help request
        if ($editCheck == "true"){
            if ($field6 == "Side 1" || $field6 == "Side 2" || $field6 == "Side 3"){
                $sqlQuery = "UPDATE help_request SET SubWeek='$field1', TaskNo='$field2', ProblemSeverity='$field3', TimeAllocation='$field4', bDesc ='$field5' WHERE TicketNo = '$ticket' AND SeatLocation = '$field6' AND StudentID = '$stuNum'";
        
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
                $seatCheck = mysqli_query($connection, "SELECT SeatLocation FROM help_request WHERE TicketNo = '$ticket' AND SeatLocation = '$field6' AND StudentID = '$stuNum'"); // Checking that the correct student is editting the data for the provided ticket number
                if(mysqli_num_rows($seatCheck) != 0) {
                    
                    $sqlQuery = "UPDATE help_request SET SubWeek='$field1', TaskNo='$field2', ProblemSeverity='$field3', TimeAllocation='$field4', bDesc ='$field5' WHERE TicketNo = '$ticket' AND SeatLocation = '$field6' AND StudentID = '$stuNum'";
        
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
            // checking if the user already has made a help request
            $weekCheck = mysqli_query($connection, "SELECT * FROM help_request WHERE StudentID IN (SELECT students.StudentID FROM students WHERE students.StudentID = '$stuNum') AND active_check = \"TRUE\" "); //checking if username already exists in db
            if(mysqli_num_rows($weekCheck) != 0) {
                $response = json_encode(array('type' => 'error', 'text' => 'You currently have an active request... Check table below...')); //message to send back to client side
                die($response);
            }
            else {
                if ($field6 == "Side 1" || $field6 == "Side 2" || $field6 == "Side 3"){
                    $field7 = "TRUE";
                    $time = "00:00:00";
                    $sql = mysqli_query($connection, "INSERT INTO help_request(StudentID, SubWeek, TaskNo, ProblemSeverity, TimeAllocation, bDesc, SeatLocation, active_check, TimeOfRequest, TimeOfHelp, DateOfRequest) VALUES ('$stuNum','$field1','$field2','$field3','$field4','$field5','$field6','$field7',NOW(),'$time',NOW())");
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
                    $seatCheck = mysqli_query($connection, "SELECT SeatLocation FROM help_request WHERE SeatLocation = '$field6' AND active_check = \"TRUE\""); // Checking that someone isn't submitting a request in an already taken seat
                    if(mysqli_num_rows($seatCheck) == "0") {
                        $field7 = "TRUE";
                        $time = "00:00:00";
                        $sql = mysqli_query($connection, "INSERT INTO help_request(StudentID, SubWeek, TaskNo, ProblemSeverity, TimeAllocation, bDesc, SeatLocation, active_check, TimeOfRequest, TimeOfHelp, DateOfRequest) VALUES ('$stuNum','$field1','$field2','$field3','$field4','$field5','$field6','$field7',NOW(),'$time',NOW())");
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