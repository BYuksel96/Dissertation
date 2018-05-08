<?php
    /*
    * PHP file used to establish a connection with the database
    */

	$host="localhost"; // Host name 
	$username="root"; // Mysql username 
	$password=""; // Mysql password
    $db_name = "database";
    
	// Connect to Database
    $connection = mysqli_connect($host, $username, $password, $db_name);
    if (!$connection){
        echo "Error: Unable to connect to MySQL";
        echo "Debugging Error: " . mysqli_connect.error() . PHP_EOL;
    }
?>