<?php
    include('connection.php');
    session_start();

    //ticketnum
    //stunum
    //demonid
    if(isset($_POST['itemNum'])){

        $itemID = $_POST['itemNum'];
        $demName = $_SESSION["demonstrator"]; //demonstrator username - used to acquire ID

        // select query to acquire demon id
        $sqlQueryID = mysqli_query($connection, "SELECT ID FROM users WHERE Username = '$demName'"); //fidning student number associated with the ticket number
        $resultDemID = mysqli_fetch_assoc($sqlQueryID);
        // select query to acquire student id
        $sqlQueryStuNum = mysqli_query($connection, "SELECT StudentID FROM help_request WHERE TicketNo = '$itemID'"); //fidning student number associated with the ticket number
        $resultStuID = mysqli_fetch_assoc($sqlQueryStuNum); //fetching the result
        if (!$sqlQueryStuNum) {
            $response = json_encode(array('type' => 'error', 'text' => 'Student has deleted their help request and is no longer in the queue. Or another demonstrator is already attending to this student.'));
            die($response);
        }else{
            $demonID = $resultDemID["ID"];
            $stuID = $resultStuID["StudentID"];
            if ($stuID == ""){
                $response = json_encode(array('type' => 'error', 'text' => 'Student has deleted their help request and is no longer in the queue. Or another demonstrator is already attending to this student.'));
                die($response);
            } else {
                $sqlInsert = mysqli_query($connection, "INSERT INTO help_completed(users_id, student_id, ticket_no) VALUES ('$demonID','$stuID','$itemID')");
                if(!$sqlInsert) {
                    $output = "Error" . mysqli_error();
                    $response = json_encode(array('type' => 'error', 'text' => $output));
                    die($response);
                }
                else {
                    //change active check to false
                    $changeState = mysqli_query($connection, "UPDATE help_request SET active_check = \"FALSE\", TimeOfHelp = NOW() WHERE TicketNo = '$itemID'");
                    if(!$changeState) {
                        $output = "Error" . mysqli_error();
                        $response = json_encode(array('type' => 'error', 'text' => $output));
                        die($response);
                    } else {
                        $response = json_encode(array('type' => 'success', 'text' => 'Success: Please now attend to the student.'));
                        die($response);
                    }
                }
            }
        }
    }else{
        $response = json_encode(array('type' => 'error', 'text' => 'Student has deleted their help request and is no longer in the queue. Or another demonstrator is already attending to this student.'));
        die($response);
    }
    mysqli_close($connection);
?>