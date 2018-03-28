<?php
    include('connection.php');
    session_start();

    $stuNum = $_SESSION["studentNumber"];

    if(isset($_POST['weekSub'])){
        $field1 = mysqli_real_escape_string($connection, $_POST['weekSub']); 
        $field2 = mysqli_real_escape_string($connection, $_POST['taskNo']);
        $field3 = mysqli_real_escape_string($connection, $_POST['severity']); 
        $field4 = mysqli_real_escape_string($connection, $_POST['time']);
        $field5 = mysqli_real_escape_string($connection, $_POST['description']); 
        $field6 = mysqli_real_escape_string($connection, $_POST['seat']);

        //check if user already has made a request
        $weekCheck = mysqli_query($connection, "SELECT * FROM help_request WHERE StudentID IN (SELECT students.StudentID FROM students WHERE students.StudentID = '$stuNum')"); //checking if username already exists in db
        if(mysqli_num_rows($weekCheck) != 0) {
            $response = json_encode(array('type' => 'error', 'text' => 'You currently have an active request... Check table below...')); //message to send back to client side
            die($response);
        }
        else {
            $sql = mysqli_query($connection, "INSERT INTO help_request(StudentID, SubWeek, TaskNo, ProblemSeverity, TimeAllocaction, bDesc, SeatLocation) VALUES ('$stuNum','$field1','$field2','$field3','$field4','$field5','$field6')");
            if(!$sql) {
                $output = "Error" . mysqli_error();
                $response = json_encode(array('type' => 'error', 'text' => $output));
                die($response);
            }
            else {
                $response = json_encode(array('type' => 'success', 'text' => 'Success: You are now in the queue!'));
                die($response);
            }
        }
    }
    mysqli_close($connection);
?>