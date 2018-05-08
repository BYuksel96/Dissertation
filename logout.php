<?php
    /*
    * PHP file which handles the logout event of both students and helpers
    */

    include('connection.php');
    session_start();

    // Destroying all session data when a user logs out

    if ($_SESSION["accType"] == "admin"){
        session_destroy();
        header("location:login.php");
    }
    else if($_SESSION["accType"] == "standard") {
        session_destroy();
        header("location:login.php");
    }
    else {
        $studentNum = $_SESSION["studentNumber"];
        $result = mysqli_query($connection, "DELETE FROM students WHERE StudentID = '$studentNum'"); // Removing the student from the DB table 'students'
        session_destroy();
        header("location:login.php");
    }
?>