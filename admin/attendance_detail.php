<?php
include('authentication.php');
include('includes/header.php');
include('includes/sidebar.php');

$work_filter = '';
if(isset($_GET['work'])) {
    $work_filter = mysqli_real_escape_string($con, $_GET['work']);
}

$query = "SELECT s.id, s.first_name, s.last_name, s.work, a.date, a.day, a.time_in, a.time_out, a.status 
          FROM student_assistant s 
          LEFT JOIN attendance a ON a.sa_id = s.id 
          WHERE s.work LIKE '%$work_filter%'";
$result = mysqli_query($con, $query);
?>
<div class="container-fluid px-4">
  <h4 class="mt-4">Student Assistants for: <?php echo htmlspecialchars($work_filter); ?></h4>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item"><a href="tito_offices.php">Back to Office Work</a></li>
      <li class="breadcrumb-item active">Attendance Details</li>
  </ol>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">  
          <h4>Student Attendance Records</h4>
        </div>
        <div class="card-body">
          <table id="myTable" class="table table-bordered">
            <thead>
              <tr>
                <th>ID</th>
                <th>Student Name</th>
                <th>Work</th>
                <th>Date</th>
                <th>Day</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                <td><?php echo htmlspecialchars($row['work']); ?></td>
                <td><?php echo htmlspecialchars($row['date'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['day'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['time_in'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['time_out'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($row['status'] ?? ''); ?></td>
              </tr>
              <?php endwhile; ?>
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
