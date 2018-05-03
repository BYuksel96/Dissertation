<?php
    /*
    * This file is used to check if there are any students currently queueing for help.
    * If there are then the file checks to see if the demonstrator/helper is currently assisting a student.
    * If they are not then an identifier will be sent back to the front end where the js will then push a notification
    * Onto the demonstrator/helpers screen to notify them that a student is waiting for help.
    */
    include('connection.php');
    session_start();

    if(($_SESSION["accType"] == "admin") || ($_SESSION["accType"] == "standard")){

        // Acquiring demonstrator username from the session variable. This var is stored when the deomstrator logs in
        // It is used to acquire demonstrators ID value from the DB
        $demName = $_SESSION["demonstrator"];

        $sqlQueryID = mysqli_query($connection, "SELECT ID FROM users WHERE Username = '$demName'");
        $resultDemID = mysqli_fetch_assoc($sqlQueryID); // Acquiring the result of the query

        $demonID = $resultDemID["ID"]; // This var is used in the next query to check if the helper is currently assisting a student

        // checking if helper is currently helping a student
        $inProgress = mysqli_query($connection, "SELECT hr.StudentID, hc.ticket_no, hr.SubWeek, hr.TaskNo, hr.ProblemSeverity, hr.TimeAllocation, hr.bDesc, hr.SeatLocation FROM help_completed hc LEFT JOIN help_request hr ON hr.TicketNo = hc.ticket_no LEFT JOIN users u ON u.ID = hc.users_id WHERE ((hr.active_check = 'ATTENDING') OR (hr.active_check = 'STUDENT NOTIFIED')) AND (hc.users_id = '$demonID')") or die (mysqli_error());
        if(mysqli_num_rows($inProgress) != 0) {
            $response = json_encode(array('type' => 'error', 'text' => 'Currently helping student'));
            die($response);
        } else { // If helper is not helping anyone then....
            // check to see if there is anyone in the queue waiting for help
            $queueCheck = mysqli_query($connection, "SELECT * FROM help_request WHERE ((active_check = 'TRUE') OR (active_check = 'ASSISTANCE'))") or die (mysqli_error());
            if(mysqli_num_rows($queueCheck) != 0) { // If there is then this will notify the js so a notification can be pushed to the user
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