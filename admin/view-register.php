<?php 
include('authentication.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <h4 class="mt-4">Student Assistants</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">View Student Assistants</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <!-- <?php include('message.php'); ?> -->
            <div class="card">
                <div class="card-header">  
                    <h4>Student Assistants
                    <a href="add1.php" class="btn btn-primary float-end">Add Student Assistant</a>
                    </h4>
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
                                <th>Info</th>
                                <th>Edit</th>
                                <th>Delete</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM student_assistant WHERE status!='2'";
                            $query_run = mysqli_query($con,$query); 

                            if(mysqli_num_rows($query_run) > 0 ) 
                            {
                                foreach($query_run as $row){
                                    ?>
                                    <tr>
                                        <td><?= $row['id'];?></td>
                                        <td><?= $row['last_name'];?></td>
                                        <td><?= $row['first_name'];?></td>
                                        <td><?= $row['program'];?></td>
                                        <td><?= $row['year'];?></td>
                                        <td><?= $row['work'];?></td>
                                        <td><a href="view-info.php?id=<?= $row['id'];?>" class="btn btn-info">View</a></td>
                                        <td><a href="edit-register.php?id=<?= $row['id'];?>" class="btn btn-success">Edit</a></td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $row['id']; ?>" data-name="<?= htmlspecialchars($row['last_name'] . ' ' . $row['first_name']); ?>">Delete</button>
                                        </td>
                                        <td>Active</td>
                                    </tr>
                                    <?php
                                }
                            }
                            else 
                            {
                            ?>
                                <tr>
                                    <td colspan="10">No Record Found</td>
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

<!-- Bootstrap Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="studentName"></span>?
            </div>
            <div class="modal-footer">
                <form action="code.php" method="POST" id="deleteForm">
                    <input type="hidden" name="delete_user" id="deleteUserId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function(event) {
        let button = event.relatedTarget;
        let userId = button.getAttribute('data-id');
        let userName = button.getAttribute('data-name');
        let modalTitle = deleteModal.querySelector('.modal-title');
        let modalBody = deleteModal.querySelector('.modal-body #studentName');
        let deleteForm = document.getElementById('deleteForm');
        let deleteUserId = document.getElementById('deleteUserId');
        
        modalTitle.textContent = 'Confirm Deletion';
        modalBody.textContent = 'Are you sure you want to delete ' + userName + '?';
        deleteUserId.value = userId;
    });
});
</script>

<?php 
include('includes/footer.php');
include('includes/scripts.php');
?>
