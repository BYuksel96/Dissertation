<?php
    include('connection.php');

    session_start();

    if(isset($_POST['category'])){
        // Storing posted values into variables
        $field1 = mysqli_real_escape_string($connection, $_POST['category']);
        $field2 = mysqli_real_escape_string($connection, $_POST['subcat']);

        $field2 = str_replace(', ', ',', $field2); // Removing spaces between the comma seperated values
        $field2 = str_replace(' ,', ',', $field2); // Removing spaces between the comma seperated values

        $weekCheck = mysqli_query($connection, "SELECT * FROM help_data WHERE Category = '$field1'"); // Checking if the category already exists in the DB
        if(mysqli_num_rows($weekCheck) != 0) { // If it does then an appropriate message it sent back, to be displayed, to the user (i.e. the admin)
            $response = json_encode(array('type' => 'error', 'text' => 'The data you provided is already in the system...')); //message to send back to client side
            die($response);
        }
        else {
            $demName = $_SESSION["demonstrator"];
            $sqlQueryID = mysqli_query($connection, "SELECT ID FROM users WHERE Username = '$demName'"); // Acquiring the ID of the user who submitted the data
            $resultDemID = mysqli_fetch_assoc($sqlQueryID); // Storing the result of the query in a variable
            $demonID = $resultDemID["ID"]; // Specifying the exact data wanted from the outcome of the query
            $sql = mysqli_query($connection, "INSERT INTO help_data(Users_ID,Category,SubCat) VALUES ('$demonID','$field1','$field2')"); // Insert category, sub-cat, etc. into the correct DB table

            if(!$sql) { // If the result of the insert query is not successful then the error message would be returned to the user
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