<?php
    include('connection.php');
    session_start();

    if (isset($_POST['user'])){

        $user = $_POST['user'];
        $query = "DELETE FROM users WHERE ID = '$user'"; // Query which will delete a helper/demonstrator account from the system
        if (mysqli_query($connection,$query)){
            $response = json_encode(array('type' => 'success', 'text' => 'User has now been removed')); //message to send back to client side
            die($response);
        } else {
            $response = json_encode(array('type' => 'error', 'text' => 'User is already deleted or this action cannot be carried out currently')); //message to send back to client side
            die($response);
        }
    }

    mysqli_close($connection);
?>