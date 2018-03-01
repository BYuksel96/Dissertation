<?php

include('connection.php');

$output = ""; //declaring the variable

if (isset($_POST['uname'])){
    $uName = mysqli_real_escape_string($connection, $_POST['uname']);
    $psw = mysqli_real_escape_string($connection, $_POST['upsw']);
    $salt = "";
    $hashedPsw = "";
    
    $accCheck = mysqli_query($connection, "SELECT * FROM users WHERE Username = '$uName'");
    if(mysqli_num_rows($accCheck) != 0) { //check if account exists
        $saltQuery = mysqli_query($connection, "SELECT * FROM users WHERE Username = '$uName'"); //get the salt linked to that users account
        if (mysqli_num_rows($saltQuery) > 0) {
            while($row = mysqli_fetch_assoc($saltQuery)) {
                $salt = $row["PasswordSalt"]; //acquiring the salt
                $hashedPsw = $row["PasswordHash"]; //acquiring the salted and hashed password
            }
            $salted = $salt . $psw; //applying the salt in the db to the password entered by the client
            $hashed = hash('sha512', $salted); //hashing the above combination
            if ($hashed == $hashedPsw){ //checking whether the salted and hashed password entered by the demonstrator is the same as it is in the db
                $response = json_encode(array('type' => 'success', 'text' => 'Success: Logging you in...'));
                die($response);
            }
            else { //if password is incrrect error message is sent back and displayed to the client
                $output = "Incorrect password for this account";
                $response = json_encode(array('type' => 'error', 'text' => $output));
                die($response);
            }
        }
    }
    else {
        $output = "No such account exists. Please inform an admin to create an account for you."; //send back error message saying user account does not exist
        $response = json_encode(array('type' => 'error', 'text' => $output));
        die($response);
    }
}
?>