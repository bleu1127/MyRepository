<?php
include('authentication.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <h4 class="mt-4">Student Assistants</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Attendance</li>
    </ol>
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Attendance</h4>
                </div>
                <div class="card-body">
                    <table id="myTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Program</th>
                                <th>Year</th>
                                <th>Work In</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Time in</th>
                                <th>Time out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT sa.id, sa.last_name, sa.first_name, sa.program, sa.year, sa.work,
                                     COALESCE(a.date, 'Not logged') as date,
                                     COALESCE(a.day, 'Not logged') as day,
                                     a.time_in,
                                     a.time_out,
                                     CASE 
                                         WHEN a.time_in IS NULL AND a.time_out IS NULL THEN 'Not logged'
                                         WHEN a.time_out IS NULL THEN 'Logged in'
                                         ELSE 'Completed'
                                     END as status
                                     FROM student_assistant sa
                                     LEFT JOIN attendance a ON sa.id = a.user_id
                                     WHERE sa.status != '2'
                                     ORDER BY sa.last_name, a.date DESC";
                            
                            $query_run = mysqli_query($con, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['last_name']; ?></td>
                                        <td><?= $row['first_name']; ?></td>
                                        <td><?= $row['program']; ?></td>
                                        <td><?= $row['year']; ?></td>
                                        <td><?= $row['work']; ?></td>
                                        <td><?= $row['date']; ?></td>
                                        <td><?= $row['day']; ?></td>
                                        <td><?= $row['time_in'] ? date('h:i A', strtotime($row['time_in'])) : 'Not logged'; ?></td>
                                        <td><?= $row['time_out'] ? date('h:i A', strtotime($row['time_out'])) : 'Not logged'; ?></td>
                                        <td><?= $row['status']; ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="11">No Record Found</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include('includes/footer.php');
include('includes/scripts.php');
?>