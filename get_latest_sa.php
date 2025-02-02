<?php
session_start();
include('admin/config/dbcon.php');
header("Content-Type: application/json");

$query = "SELECT sa.id, sa.first_name, sa.last_name, sa.image, sa.program, sa.work, sa.year, a.date, a.time_in, a.time_out 
          FROM attendance a 
          JOIN student_assistant sa ON a.sa_id = sa.id 
          WHERE a.date = CURDATE()
          ORDER BY a.id DESC LIMIT 1";
$result = mysqli_query($con, $query);
if($row = mysqli_fetch_assoc($result)){
    echo json_encode(['success'=> true, 'data' => $row]);
} else {
    echo json_encode(['success'=> false, 'data' => null]);
}
?>
