<?php
    include('connection.php');

    if(isset($_POST['accName'])){
        // Storing posted values into variables
        $accName = mysqli_real_escape_string($connection, $_POST['accName']); 
        $accountType = mysqli_real_escape_string($connection, $_POST['accType']);
        $password = mysqli_real_escape_string($connection, $_POST['psw']);

        $salt = uniqid(mt_rand(), true); // Generating a random salt value
        $salted = $salt . $password; // Applying the salt to the password
        $hashed = hash('sha512', $salted); // Hashing the cobmination above

        // check if account name exists in the database table 'users', if yes then the user is prompted and account is not added
        $accCheck = mysqli_query($connection, "SELECT * FROM users WHERE Username = '$accName'"); //checking if username already exists in db table 'users'
        if(mysqli_num_rows($accCheck) != 0) {
            $response = json_encode(array('type' => 'error', 'text' => 'Username already exists: Try using a different username...')); //message to send back to client side
            die($response);
        }
        else {
            $sql = mysqli_query($connection, "INSERT INTO users(Username, PasswordSalt, PasswordHash, account_type) VALUES ('$accName','$salt','$hashed','$accountType')"); // Inserting the appropriate account data into the DB table 'users'
            if(!$sql) {
                $output = "Error" . mysqli_error();
                $response = json_encode(array('type' => 'error', 'text' => $output));
                die($response);
            }
            else {
                $response = json_encode(array('type' => 'success', 'text' => 'Success: Account has been created!'));
                die($response);
            }
        }
    }
    mysqli_close($connection);
?>