<?php
    include('connection.php');
    session_start();

    if (isset($_POST['oldpsw'])){
        //check db if it is the same
        $uName = $_SESSION["demonstrator"];
        $oldpsw = mysqli_real_escape_string($connection, $_POST['oldpsw']);
        $newpsw = mysqli_real_escape_string($connection, $_POST['new']);
        $repeatpsw = mysqli_real_escape_string($connection, $_POST['repeat']);
        //acquire salt and do password check on old password
        $saltQuery = mysqli_query($connection, "SELECT * FROM users WHERE Username = '$uName'");
        if (mysqli_num_rows($saltQuery) > 0) {
            while($row = mysqli_fetch_assoc($saltQuery)) {
                $salt = $row["PasswordSalt"]; //acquiring the salt
                $hashedPsw = $row["PasswordHash"]; //acquiring the salted and hashed password
            }
            $salted = $salt . $oldpsw; //applying the salt in the db to the password entered by the client
            $hashed = hash('sha512', $salted); //hashing the above combination
            if ($hashed == $hashedPsw){ //checking whether the salted and hashed password entered by the demonstrator is the same as it is in the db
                //carry on work
                if ($newpsw == $repeatpsw){
                    $salt = uniqid(mt_rand(), true);
                    $salted = $salt . $newpsw;
                    $hashed = hash('sha512', $salted);
                    $clearOldSaltNHash = mysqli_query($connection, "UPDATE users SET PasswordSalt='$salt', PasswordHash='$hashed' WHERE Username = '$uName'");
                    if (!$clearOldSaltNHash){
                        $output = "There was an error changing your password. Please try again...";
                        $response = json_encode(array('type' => 'error', 'text' => $output));
                        die($response);
                    } else {
                        $output = "Your password has been changed!";
                        $response = json_encode(array('type' => 'success', 'text' => $output));
                        die($response);
                    }
                } else {
                    $output = "The passwords do no match...";
                    $response = json_encode(array('type' => 'error', 'text' => $output));
                    die($response);
                }
            }
            else { //if password is incorrect error message is sent back and displayed to the client
                $output = "The password entered is inccorect";
                $response = json_encode(array('type' => 'old', 'text' => $output));
                die($response);
            }
        }


    } else {
        $response = json_encode(array('type' => 'error', 'text' => 'You have not entered your old password!'));
        die($response);
    }

?>