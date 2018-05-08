<?php
    /*
    * PHP file that is used to change the the state of a help request ticket.
    * When called, this fill is used to first check if the ticket still exists in the system (i.e. has someone else gone to assist the student or has the student deleted the ticket)
    * If it is then, the state of the tickets active_check is changed. This is used to identify that the helper has accepted to assist the student. This then aids in removing the ticket from the main queue.
    */


    include('connection.php');
    session_start();

    if(isset($_POST['itemNum'])){ // Checking if the itemNum (i.e. the ticket ID) has been posted. If so then work is carried out. If not an appropriate message is sent back to the user

        $itemID = mysqli_real_escape_string($connection, $_POST['itemNum']); // Storing the posted value into a variable
        $demName = $_SESSION["demonstrator"]; // Acquiring demonstrator username from the session cariable stored when the deomstrator has logged in - used to acquire demonstrator ID from DB

        // select query to acquire demonstrator id from db table 'users'
        $sqlQueryID = mysqli_query($connection, "SELECT ID FROM users WHERE Username = '$demName'");
        $resultDemID = mysqli_fetch_assoc($sqlQueryID); // Acquiring the result of the query
        // select query to acquire student id
        $sqlQueryStuNum = mysqli_query($connection, "SELECT StudentID FROM help_request WHERE TicketNo = '$itemID' AND active_check = \"TRUE\" OR active_check = \"ASSISTANCE\""); //finding student number associated with the ticket number
        $resultStuID = mysqli_fetch_assoc($sqlQueryStuNum); // fetching the result
        if (!$sqlQueryStuNum) { // If the result of the StudentID query is empty then an appropriate response is sent back to the user
            // Below is how a response is sent from server side back to the user
            $response = json_encode(array('type' => 'error', 'text' => 'Student has deleted their help request and is no longer in the queue. Or another demonstrator is already attending to this student.'));
            die($response); // Exiting with our response
        }else{
            $demonID = $resultDemID["ID"]; // Storing the ID column from the first query result in a variable
            $stuID = $resultStuID["StudentID"]; // Storing second query result in a variable
            if ($stuID == ""){
                $response = json_encode(array('type' => 'error', 'text' => 'Student has deleted their help request and is no longer in the queue. Or another demonstrator is already attending to this student.'));
                die($response);
            } else {
                $sqlInsert = mysqli_query($connection, "INSERT INTO help_completed(users_id, ticket_no) VALUES ('$demonID','$itemID')");
                if(!$sqlInsert) { // If there is an error with the query then an error message is sent back to the user
                    $output = "Error" . mysqli_error();
                    $response = json_encode(array('type' => 'error', 'text' => $output));
                    die($response);
                }
                else {
                    // changing the active check to ATTENDING - This removes the help request ticket from being displayed in the queueing table
                    $changeState = mysqli_query($connection, "UPDATE help_request SET active_check = \"ATTENDING\", TimeOfHelp = NOW() WHERE TicketNo = '$itemID'");
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