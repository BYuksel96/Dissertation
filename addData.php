<?php
    /*
    * PHP file used to submit admin provided task data to the database table help_data
    */

    include('connection.php');

    session_start();

    if(isset($_POST['category'])){
        // Storing posted values into variables
        $category = mysqli_real_escape_string($connection, $_POST['category']);
        $subcat = mysqli_real_escape_string($connection, $_POST['subcat']);

        $subcat = str_replace(', ', ',', $subcat); // Removing any spaces between the comma seperated values
        $subcat = str_replace(' ,', ',', $subcat); 
        // Query to check if the category already exists in the DB table
        $weekCheck = mysqli_query($connection, "SELECT * FROM help_data WHERE Category = '$category'");
        // If it does then an appropriate message it sent back, to be displayed, to the user (i.e. the admin)
        if(mysqli_num_rows($weekCheck) != 0) {
            //message to send back to client side
            $response = json_encode(array('type' => 'error', 'text' => 'The data you provided is already in the system...'));
            die($response);
        }
        else {
            $demName = $_SESSION["demonstrator"];
            // Acquiring the ID of the user who submitted the data
            $sqlQueryID = mysqli_query($connection, "SELECT ID FROM users WHERE Username = '$demName'");
            $resultDemID = mysqli_fetch_assoc($sqlQueryID); // Storing the result of the query in a variable
            $demonID = $resultDemID["ID"]; // Specifying the exact data wanted from the outcome of the query
            // Sql query to insert category, sub-cat data into the correct DB table
            $sql = mysqli_query($connection, "INSERT INTO help_data(Users_ID,Category,SubCat) VALUES ('$demonID','$category','$subcat')");

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