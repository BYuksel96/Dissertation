<?php
    include('connection.php');

    if(isset($_POST['weekSub'])){
        $field1 = mysqli_real_escape_string($connection, $_POST['weekSub']); 
        $field2 = mysqli_real_escape_string($connection, $_POST['taskNum']);

        //check if account name exists in database, if yes then prompt user
        $weekCheck = mysqli_query($connection, "SELECT * FROM help_data WHERE week = '$field1'"); //checking if username already exists in db
        if(mysqli_num_rows($weekCheck) != 0) {
            $response = json_encode(array('type' => 'error', 'text' => 'The week you entered already exists...')); //message to send back to client side
            die($response);
        }
        else {
            $sql = mysqli_query($connection, "INSERT INTO help_data(week, task) VALUES ('$field1','$field2')");
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