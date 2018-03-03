<?php
    include('connection.php');
    session_start();

    if ($_SESSION["accType"] == "admin"){
        session_destroy();
        header("location:login.php");
    }
    else if($_SESSION["accType"] == "standard") {
        session_destroy();
        header("location:login.php");
    }
    else {
        session_destroy();
        $studentNum = $_SESSION["studentNumber"];
        $result = mysqli_query($connection, "DELETE FROM students WHERE studentid = '$studentNum'");
        header("location:login.php");
    }
?>