<?php
include('admin/config/dbcon.php');

$id = $_GET['id'] ?? null;

if ($id) {
    $query = "SELECT a.*, sa.first_name, sa.last_name 
              FROM attendance a 
              JOIN student_assistant sa ON a.sa_id = sa.id 
              WHERE sa_id = ? 
              ORDER BY date DESC, time_in DESC LIMIT 1";
              
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?= $row['sa_id'] ?></td>
            <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
            <td><?= date('Y-m-d', strtotime($row['date'])) ?></td>
            <td><?= date('H:i:s', strtotime($row['time_in'])) ?></td>
            <td><?= $row['time_out'] ? date('H:i:s', strtotime($row['time_out'])) : '-' ?></td>
        </tr>
        <?php
    } else {
        echo "<tr><td colspan='5' class='text-center'>No logs available</td></tr>";
    }
}
?>
