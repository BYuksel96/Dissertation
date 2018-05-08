<?php

    /*
    * PHP file used to check helper/demonstrator login details.
    * If the account exists then the password associated with that account is checked to see that it matches the user typed one.
    * If the passwords match then session variables are created and the helper is logged into the tool.
    * The outcome of this process is then sent back to the frontend.
    */

    include('connection.php');
    session_start();

    if (isset($_POST['uname'])){
        
        $uName = mysqli_real_escape_string($connection, $_POST['uname']);
        $psw = mysqli_real_escape_string($connection, $_POST['upsw']);
        $salt = "";
        $hashedPsw = "";
        $accType = "";
        
        // sql query for checking if the account exists
        $accCheck = mysqli_query($connection, "SELECT * FROM users WHERE Username = '$uName'");
        // If result of query is not equal to 0 then that means the account exists
        if(mysqli_num_rows($accCheck) != 0) {
            // getting the salt linked to that users account
            $saltQuery = mysqli_query($connection, "SELECT * FROM users WHERE Username = '$uName'");
            if (mysqli_num_rows($saltQuery) > 0) {
                while($row = mysqli_fetch_assoc($saltQuery)) {
                    $salt = $row["PasswordSalt"]; // storing the salt value in a var
                    $hashedPsw = $row["PasswordHash"]; // acquiring the salted and hashed password
                    $adminCheck = $row["account_type"]; // storing the value of whether the account type is admin or not
                }
                $salted = $salt . $psw; // applying the salt in the db to the password entered by the client
                $hashed = hash('sha512', $salted); // hashing the above combination
                // checking whether the salted and hashed password entered by the demonstrator is the same as it is in the db table 'users'
                if ($hashed == $hashedPsw){
                    $response = json_encode(array('type' => 'success', 'text' => 'Success: Logging you in...'));
                    // Storing variable values in session variables
                    $_SESSION["accType"] = $adminCheck;
                    $_SESSION["demonstrator"] = $uName;
                    die($response);
                }
                else { // if password is incorrect error message is sent back and displayed to the client
                    $output = "Incorrect User Details";
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

    mysqli_close($connection);

?>