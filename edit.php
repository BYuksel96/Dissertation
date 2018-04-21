<?php
    include('connection.php');
    session_start();

    $student = $_SESSION["studentNumber"];
    $_SESSION["editItem"] = "";
    $_SESSION["ticketNo"] = "";

    if(isset($_POST['itemNum'])){

        $itemID = $_POST['itemNum']; // storing ticket number in a var
        $sqlQuery = mysqli_query($connection, "SELECT StudentID FROM help_request WHERE TicketNo = '$itemID'"); // finding the student number associated with the ticket number
        $result = mysqli_fetch_assoc($sqlQuery); // fetching the result

        // sql query which will stop any user from editing content that isn't there's - checking if students id, that is stored in the session var, matches the ticket number
        if($student == $result["StudentID"]) {

            $sql = mysqli_query($connection, "SELECT SubWeek, TaskNo, ProblemSeverity, TimeAllocation, bDesc, SeatLocation FROM help_request WHERE TicketNo = '$itemID'");

            while($row = mysqli_fetch_assoc($sql)){
                $_SESSION["editItem"] = "true"; // creating a session check. This sessions is used to see the user is editting a request
                $_SESSION["ticketNo"] = $itemID;
                $response = json_encode(array('type' => 'success', 'week' => $row['SubWeek'], 'task' => $row['TaskNo'], 'psev' => $row['ProblemSeverity'], 'time' => $row['TimeAllocation'], 'desc' => $row['bDesc'], 'seat' => $row['SeatLocation'])); // Sending back the values that will populate the help request form
                die($response);
            }

        } else {

            $response = json_encode(array('type' => 'error', 'text' => 'Cannot do this action')); // message to send back to client side
            die($response);

        }

    } else{
        $response = json_encode(array('type' => 'error', 'text' => 'Inavlid Action... You already have an active request. Please click edit button below!')); // message to send back to client side
        $_SESSION["editItem"] = "";
        die($response);
    }
    mysqli_close($connection);
?>