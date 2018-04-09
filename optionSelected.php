<?php

    include('connection.php');

    session_start();

    if (isset($_POST['option'])){
        $option = $_POST['option'];
        $result = '';
        $sql = mysqli_query($connection, "SELECT * FROM help_data WHERE Category = '$option'");
        while ($row = mysqli_fetch_assoc($sql)){
            $result = $row['SubCat'];
        }
        $response = json_encode(array('type' => 'success', 'text' => $result));
        die($response);
    }

?>