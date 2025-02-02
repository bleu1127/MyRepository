<?php
session_start();
include('admin/config/dbcon.php');
header('Content-Type: application/json');

try {
    // Get latest logs
    $latest_query = "SELECT a.*, sa.first_name, sa.last_name, sa.image 
                    FROM attendance a 
                    JOIN student_assistant sa ON a.sa_id = sa.id 
                    WHERE sa.status != '2' 
                    ORDER BY a.date DESC, 
                    CASE 
                        WHEN a.time_out IS NOT NULL THEN a.time_out 
                        ELSE a.time_in 
                    END DESC 
                    LIMIT 10";
    $latest_result = mysqli_query($con, $latest_query);
    $latest_logs = [];
    
    while ($row = mysqli_fetch_assoc($latest_result)) {
        $latest_logs[] = [
            'id' => $row['id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'image' => $row['image'],
            'date' => date('Y-m-d', strtotime($row['date'])),
            'time_in' => date('H:i:s', strtotime($row['time_in'])),
            'time_out' => $row['time_out'] ? date('H:i:s', strtotime($row['time_out'])) : null
        ];
    }

    // Get attendance sheet
    $attendance_query = "SELECT sa.*, a.date, a.day, a.time_in, a.time_out, a.status
                        FROM student_assistant sa 
                        LEFT JOIN attendance a ON sa.id = a.sa_id AND a.date = CURDATE() 
                        WHERE sa.status != '2'";
    $attendance_result = mysqli_query($con, $attendance_query);
    $attendance_sheet = [];

    while ($row = mysqli_fetch_assoc($attendance_result)) {
        $attendance_sheet[] = [
            'id' => $row['id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'image' => $row['image'],
            'work' => $row['work'],
            'year' => $row['year'],
            'date' => $row['date'],
            'day' => $row['day'],
            'time_in' => $row['time_in'],
            'time_out' => $row['time_out'],
            'status' => $row['status']
        ];
    }

    echo json_encode([
        'success' => true,
        'latestLogs' => $latest_logs,
        'attendanceSheet' => $attendance_sheet
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching attendance data: ' . $e->getMessage()
    ]);
}
?>
