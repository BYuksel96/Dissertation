<?php
    include('connection.php');
    session_start();

    // $stmt = "SELECT u.Username, hc.student_id, hc.ticket_no, hr.SubWeek, hr.TaskNo, hr.ProblemSeverity, hr.TimeAllocation, hr.bDesc, hr.SeatLocation, hr.TimeOfRequest, hr.TimeOfHelp FROM help_completed hc LEFT JOIN help_request hr ON hr.TicketNo = hc.ticket_no AND hr.active_check = 'FALSE' LEFT JOIN users u ON u.ID = hc.users_id ORDER BY hc.ticket_no";
    $sql_query = mysqli_query($connection, "SELECT u.Username, hc.student_id, hc.ticket_no, hr.SubWeek, hr.TaskNo, hr.ProblemSeverity, hr.TimeAllocation, hr.bDesc, hr.SeatLocation, hr.TimeOfRequest, hr.TimeOfHelp FROM help_completed hc LEFT JOIN help_request hr ON hr.TicketNo = hc.ticket_no AND hr.active_check = 'FALSE' LEFT JOIN users u ON u.ID = hc.users_id ORDER BY hc.ticket_no") or die (mysqli_error());
    
    

?>