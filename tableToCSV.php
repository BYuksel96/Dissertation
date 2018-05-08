<?php
    /*
    * PHP file used to download a csv copy of the help completed table to the admins machine (when the download to csv button is pressed)
    */

    include('connection.php');
    session_start();

    if(isset($_SESSION["accType"])){ // Checking if the account type is set
        if($_SESSION["accType"] == "admin"){ // Checking if the person requesting this function is an admin
            $sql_query = mysqli_query($connection, "SELECT u.Username, hr.studentID, hc.ticket_no, hr.SubWeek, hr.TaskNo, hr.bDesc, hr.SeatLocation, hr.TimeOfRequest, hr.TimeOfHelp, hr.TimeHelpFinished, hr.DateOfRequest FROM help_completed hc LEFT JOIN help_request hr ON hr.TicketNo = hc.ticket_no AND hr.active_check = 'FALSE' LEFT JOIN users u ON u.ID = hc.users_id ORDER BY hc.ticket_no") or die (mysqli_error());
            
            header('Content-type: application/ms-excel'); // Specifying the file type of the file that is to be downloaded
            header('Content-Disposition: attachment; filename=Completed_Requests.csv'); // Setting the export file name

            $file = fopen("php://output", "w"); // Opening the file for it to be written into and downloaded to the users system
            $file_headers = array("Assisted By", "Student Number", "Ticket No.", "Chosen Task Category", "Subcategory", "Problem Description", "Seat Location", "Time Of Request", "Time Help Arrived", "Time Help Was Completed", "Date of Request"); //File Headers
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

    mysqli_close($connection);

    // The code found here: https://stackoverflow.com/questions/30837075/export-mysql-query-array-using-fputcsv
    // Was used as guidance for when implementing this feature

?>