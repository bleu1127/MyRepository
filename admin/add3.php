<?php
include('authentication.php');
include('includes/header.php');
?>

<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4"></ol>
    <div class="row">

        <div class="col-md-12">
            <!-- <?php include('message.php'); ?> -->
            <div class="card">
                <div class="card-header">
                    <h4>Register Student Assistants
                        <a href="add2.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form class="row g-3" action="add4.php" method="POST">
                        <h4>Reference</h4>

                        <center>
                            <h4>Outside WIT</h4>
                        </center>

                        <div class="col-md-4">
                            <label class="form-label">Name</label>
                            <input  name="owit_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Company/Address</label>
                            <input  name="owit_add" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact No.</label>
                            <input  type="owit_no" class="form-control" id="age">
                        </div>
                        <div class="col-md-4">
                            <input name="owit_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input name="owit_add" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="owit_no" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input name="owit_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input name="owit_add" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="owit_no" class="form-control">
                        </div>

                        <hr class="divider" />

                        <center>
                            <h4>From WIT</h4>
                        </center>

                        <div class="col-md-4">
                            <label class="form-label">Name</label>
                            <input  name="fwit_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Company/Address</label>
                            <input  name="fwit_add" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact No.</label>
                            <input  type="fwit_no" class="form-control" id="age">
                        </div>
                        <div class="col-md-4">
                            <input name="fwit_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input name="fwit_add" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="fwit_no" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input name="fwit_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input name="fwit_add" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <input type="fwit_no" class="form-control">
                        </div>

                        <hr class="divider" />

                        <center>
                            <h4>Family Information</h4>
                        </center>

                        <div class="col-md-4">
                            <label class="form-label">Father's Name</label>
                            <input  name="father_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Occupation</label>
                            <input  name="father_occ" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Approx. Income/Mon</label>
                            <input  type="father_income" class="form-control" id="age">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mother's Name</label>
                            <input  name="mother_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Occupation</label>
                            <input  name="mother_occ" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Approx. Income/Mon</label>
                            <input  type="mother_income" class="form-control" id="age">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Other Source of Income</label>
                            <input  name="source_in" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Approx. Income/Mon</label>
                            <input  name="other_in" class="form-control">
                        </div>

                        <h5>Brothers & Sister</h5>

                        <div class="col-md-3">
                            <label class="form-label">Name</label>
                            <input  name="bs_name" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Age</label>
                            <input  name="bs_age" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Course/Yr./Grad./Sch</label>
                            <input  type="bs_lvl" class="form-control" id="age">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Work/Studying/No Work</label>
                            <input  name="bs_status" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input  name="bs_name" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <input  name="bs_age" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input  type="bs_lvl" class="form-control" id="age">
                        </div>
                        <div class="col-md-4">
                            <input  name="bs_status" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input  name="bs_name" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <input  name="bs_age" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input  type="bs_lvl" class="form-control" id="age">
                        </div>
                        <div class="col-md-4">
                            <input  name="bs_status" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input  name="bs_name" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <input  name="bs_age" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input  type="bs_lvl" class="form-control" id="age">
                        </div>
                        <div class="col-md-4">
                            <input  name="bs_status" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input  name="bs_name" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <input  name="bs_age" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input  type="bs_lvl" class="form-control" id="age">
                        </div>
                        <div class="col-md-4">
                            <input  name="bs_status" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input  name="bs_name" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <input  name="bs_age" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <input  type="bs_lvl" class="form-control" id="age">
                        </div>
                        <div class="col-md-4">
                            <input  name="bs_status" class="form-control">
                        </div>

                        <?php
                        // Assuming the form data is submitted using POST
                        if (isset($_POST['last_name']) && isset($_POST['first_name']) && isset($_POST['id'])) {
                            $id = htmlspecialchars(trim($_POST['id'])); // Sanitize ID
                            $last_name = htmlspecialchars(trim($_POST['last_name']));
                            $first_name = htmlspecialchars(trim($_POST['first_name']));
                        } else {
                            // Default values if form data is not submitted
                            $id = null;
                            $last_name = 'Unknown';
                            $first_name = 'User';
                        }
                        ?>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<?php
include('includes/footer.php');
include('includes/scripts.php');
?>