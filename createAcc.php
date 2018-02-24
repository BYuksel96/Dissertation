<?php
    include('connection.php');

    $salt = uniqid(mt_rand(), true);
    $salted = $salt . $_POST['psw'];
    $hashed = hash('sha512', $salted);

    $accName=$_POST['accName']; 
    $accountType=$_POST['accType'];

    $sql = mysqli_query($connection, "INSERT INTO users(Username, PasswordSalt, PasswordHash, account_type) VALUES ('$accName','$salt','$hashed','$accountType')");
    if(!$sql){
        echo "Error" . mysqli_error();
    }
    else{
        echo "account created";
    }
?>