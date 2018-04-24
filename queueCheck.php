<?php

    include('connection.php');
    session_start();

    if(($_SESSION["accType"] == "admin") || ($_SESSION["accType"] == "standard")){

        $demName = $_SESSION["demonstrator"]; // Acquiring demonstrator username from the session cariable stored when the deomstrator has logged in - used to acquire demonstrator ID from DB

        // select query to acquire demon id
        $sqlQueryID = mysqli_query($connection, "SELECT ID FROM users WHERE Username = '$demName'"); // finding student number associated with the ticket number
        $resultDemID = mysqli_fetch_assoc($sqlQueryID); // Acquiring the result of the query

        $demonID = $resultDemID["ID"];

        // check helper is not currently helping someone
        $inProgress = mysqli_query($connection, "SELECT hc.student_id, hc.ticket_no, hr.SubWeek, hr.TaskNo, hr.ProblemSeverity, hr.TimeAllocation, hr.bDesc, hr.SeatLocation FROM help_completed hc LEFT JOIN help_request hr ON hr.TicketNo = hc.ticket_no LEFT JOIN users u ON u.ID = hc.users_id WHERE ((hr.active_check = 'ATTENDING') OR (hr.active_check = 'STUDENT NOTIFIED')) AND (hc.users_id = '$demonID')") or die (mysqli_error());
        if(mysqli_num_rows($inProgress) != 0) {
            $response = json_encode(array('type' => 'error', 'text' => 'Currently helping student'));
            die($response);
        } else {
            // check if there is anyone in the queue
            $queueCheck = mysqli_query($connection, "SELECT * FROM help_request WHERE ((active_check = 'TRUE') OR (active_check = 'ASSISTANCE'))") or die (mysqli_error());
            if(mysqli_num_rows($queueCheck) != 0) {
                $response = json_encode(array('type' => 'success', 'text' => 'student in queue'));
                die($response);
            } else {
                $response = json_encode(array('type' => 'error', 'text' => 'No students in queue'));
                die($response);
            }
        }

    } else {
        $response = json_encode(array('type' => 'error', 'text' => 'Not a helper account.'));
        die($response);
    }

    mysqli_close($connection);

?>