<?php
include('admin/config/dbcon.php');

$query = "SELECT sa.* 
          FROM attendance a 
          JOIN student_assistant sa ON a.sa_id = sa.id 
          WHERE sa.status != '2' 
          ORDER BY a.date DESC, 
          CASE 
              WHEN a.time_out IS NOT NULL THEN a.time_out 
              ELSE a.time_in 
          END DESC 
          LIMIT 1";

$result = mysqli_query($con, $query);
if ($row = mysqli_fetch_assoc($result)) {
    echo json_encode([
        'success' => true,
        'name' => $row['first_name'] . ' ' . $row['last_name'],
        'program' => $row['program'],
        'work' => $row['work'],
        'year' => $row['year'],
        'image' => !empty($row['image']) ? $row['image'] : 'images/defaultProfile.png'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'No student assistant found'
    ]);
}
?>
