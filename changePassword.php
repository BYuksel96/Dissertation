<?php
    include('connection.php');
    session_start();

    if (isset($_POST['oldpsw'])){
        // Storing values from sessions and posted data in variables
        $uName = $_SESSION["demonstrator"];
        $oldpsw = mysqli_real_escape_string($connection, $_POST['oldpsw']);
        $newpsw = mysqli_real_escape_string($connection, $_POST['new']);
        $repeatpsw = mysqli_real_escape_string($connection, $_POST['repeat']);
        // Acquiring the salt associated with the account
        $saltQuery = mysqli_query($connection, "SELECT * FROM users WHERE Username = '$uName'");
        if (mysqli_num_rows($saltQuery) > 0) {
            while($row = mysqli_fetch_assoc($saltQuery)) {
                $salt = $row["PasswordSalt"]; // storing the salt value in a var
                $hashedPsw = $row["PasswordHash"]; // Storing the salted and hashed password in a var
            }
            $salted = $salt . $oldpsw; // applying the salt the password entered by the client (The old password)
            $hashed = hash('sha512', $salted); // hashing the above combination
            if ($hashed == $hashedPsw){ // checking whether the salted and hashed password entered by the demonstrator is the same as it is in the db
                if ($newpsw == $repeatpsw){ // Checking that the new password matches the repeated new password
                    $salt = uniqid(mt_rand(), true); // Generating a random salt value
                    $salted = $salt . $newpsw; // Applying the salt to the new password
                    $hashed = hash('sha512', $salted); // Hashing the above combination
                    $clearOldSaltNHash = mysqli_query($connection, "UPDATE users SET PasswordSalt='$salt', PasswordHash='$hashed' WHERE Username = '$uName'"); // Updating the DB table (users table) accordingly
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
            else { //if passwords do not match, an error message is sent back and displayed to the client
                $output = "The password entered is inccorect. Please try again...";
                $response = json_encode(array('type' => 'old', 'text' => $output));
                die($response);
            }
        }


    } else {
        $response = json_encode(array('type' => 'error', 'text' => 'You have not entered your old password!'));
        die($response);
    }

?>