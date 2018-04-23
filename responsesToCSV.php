<?php
    include('connection.php');
    session_start();

    if(isset($_SESSION["accType"])){ // Checking if the account type is set
        if($_SESSION["accType"] == "admin"){ // Checking if the person requesting this function is an admin
            $sql_query = mysqli_query($connection, "SELECT u.Username, hr.StudentID, hr.SubWeek, hr.TaskNo, hf.option_selected, hf.comments FROM helper_feedback hf LEFT JOIN help_request hr ON hr.TicketNo = hf.ticket_id LEFT JOIN users u ON u.ID = hf.users_id ORDER BY hf.ID") or die (mysqli_error());
            
            header('Content-type: application/ms-excel'); // Specifying the file type of the file that is to be downloaded
            header('Content-Disposition: attachment; filename=Helper_Responses.csv'); // Setting the export file name

            $file = fopen("php://output", "w"); // Opening the file for it to be written into and downloaded to the users system
            $file_headers = array("Helper Account", "Student ID", "Chosen Task Category", "Task Sub-category", "Feedback Category", "Feedback comments"); // File Headers

            $header = false; // Header check variable

            while($row = mysqli_fetch_array($sql_query, MYSQLI_ASSOC)){ //Fetching outcome of query
                if(!$header){ // Checking if the header has been written to the file
                    fputcsv($file, array_values($file_headers)); // Writting the headers to the file
                    $header = true; // Identifying that headers have now been written to the first line in the file
                }

                fputcsv($file, array_values($row)); // Writting the contents of the query to the file
                
            }

            fclose($file); // Closing the file as we are now finished
        }
    }

?>