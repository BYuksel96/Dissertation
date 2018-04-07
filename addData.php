<?php
    include('connection.php');

    session_start();

    if(isset($_POST['category'])){
        $field1 = mysqli_real_escape_string($connection, $_POST['category']); 
        $field2 = mysqli_real_escape_string($connection, $_POST['subcat']);

        $field2 = str_replace(', ', ',', $field2);
        $field2 = str_replace(' ,', ',', $field2);

        //check if account name exists in database, if yes then prompt user
        $weekCheck = mysqli_query($connection, "SELECT * FROM help_data WHERE Category = '$field1'"); //checking if username already exists in db
        if(mysqli_num_rows($weekCheck) != 0) {
            $response = json_encode(array('type' => 'error', 'text' => 'The data you provided is already in the system...')); //message to send back to client side
            die($response);
        }
        else {
            $demName = $_SESSION["demonstrator"];
            $sqlQueryID = mysqli_query($connection, "SELECT ID FROM users WHERE Username = '$demName'"); //fidning student number associated with the ticket number
            $resultDemID = mysqli_fetch_assoc($sqlQueryID);
            $demonID = $resultDemID["ID"];
            $sql = mysqli_query($connection, "INSERT INTO help_data(Users_ID,Category,SubCat) VALUES ('$demonID','$field1','$field2')");

            if(!$sql) {
                $output = "Error" . mysqli_error();
                $response = json_encode(array('type' => 'error', 'text' => $output));
                die($response);
            }
            else {
                $response = json_encode(array('type' => 'success', 'text' => 'Success: The content has been added into the system!'));
                die($response);
            }
        }
    }
    mysqli_close($connection);
?>