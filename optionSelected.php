<?php
    // This file is used to send the sub-category data back to client-side.
    // The string that is acquired from here is then used to populate the sub-category field in the help request form.

    include('connection.php');

    session_start();

    if (isset($_POST['option'])){
        $option = $_POST['option']; // Storing the posted value in a var
        $result = '';
        $sql = mysqli_query($connection, "SELECT * FROM help_data WHERE Category = '$option'"); // Querying the database to get back the sub-category data
        while ($row = mysqli_fetch_assoc($sql)){
            $result = $row['SubCat']; // Storing sub-category data in a var
        }
        $response = json_encode(array('type' => 'success', 'text' => $result)); // Making data accessible on client-side
        die($response); // Exiting with response
    }

?>