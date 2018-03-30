<?php
    include('connection.php');
    session_start();

    $stuNum = $_SESSION["studentNumber"];
    if (isset($_SESSION["editItem"])){
        $editCheck = $_SESSION["editItem"];
        $ticket = $_SESSION["ticketNo"];
    } else {
        $editCheck = "";
    }

    if(isset($_POST['weekSub'])){
        $field1 = mysqli_real_escape_string($connection, $_POST['weekSub']); 
        $field2 = mysqli_real_escape_string($connection, $_POST['taskNo']);
        $field3 = mysqli_real_escape_string($connection, $_POST['severity']); 
        $field4 = mysqli_real_escape_string($connection, $_POST['time']);
        $field5 = mysqli_real_escape_string($connection, $_POST['description']); 
        $field6 = mysqli_real_escape_string($connection, $_POST['seat']);

        //check if ticket exists if it does then do an update query else insert
        if ($editCheck == "true"){
            $seatCheck = mysqli_query($connection, "SELECT SeatLocation FROM help_request WHERE TicketNo = '$ticket' AND SeatLocation = '$field6' AND StudentID = '$stuNum'");
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
        } else {

            //check if user already has made a request
            $weekCheck = mysqli_query($connection, "SELECT * FROM help_request WHERE StudentID IN (SELECT students.StudentID FROM students WHERE students.StudentID = '$stuNum') AND active_check = \"TRUE\" "); //checking if username already exists in db
            if(mysqli_num_rows($weekCheck) != 0) {
                $response = json_encode(array('type' => 'error', 'text' => 'You currently have an active request... Check table below...')); //message to send back to client side
                die($response);
            }
            else {
                $seatCheck = mysqli_query($connection, "SELECT SeatLocation FROM help_request WHERE SeatLocation = '$field6'");
                if(mysqli_num_rows($seatCheck) == "0") {
                    $field7 = "TRUE";
                    $sql = mysqli_query($connection, "INSERT INTO help_request(StudentID, SubWeek, TaskNo, ProblemSeverity, TimeAllocation, bDesc, SeatLocation, active_check) VALUES ('$stuNum','$field1','$field2','$field3','$field4','$field5','$field6','$field7')");
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
    mysqli_close($connection);
?>