<?php
session_start();
include('authentication.php');
include('includes/header.php');

// Start the registration session
$_SESSION['registration_in_progress'] = true;

?>







<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4"></ol>
    <div class="row">

        <div class="col-md-12">
            <!-- <?php include('message.php'); ?> -->
            <div class="card">
                <div class="card-header">
                    <h4>Register Student Assistants
                        <a href="view-register.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form class="row g-3" action="add2.php" method="POST" enctype="multipart/form-data">


                        <div class="col-md-4">
                            <label class="form-label">Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/jpeg,image/png,image/jpg">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Last Name</label>
                            <input name="last_name" required class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">First Name</label>
                            <input name="first_name" required class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Age</label>
                            <input name="age" required class="form-control" id="age">
                        </div>
                        <div class="col-md-3">
                            <label for="sex" class="form-label">Sex</label>
                            <select name="sex" required class="form-select">
                                <option value="">Choose...</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="cs" class="form-label">Civil Status</label>
                            <select name="civil_status" class="form-select">

                                <option selected>Single</option>
                                <option selected>Divorce</option>
                                <option selected>Marriage</option>
                                <option selected>Widowed</option>
                                <option selected hidden>Choose...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Date of Birth</label>
                            <input placeholder="mm-dd-yyyy" name="date_of_birth" class="form-control" id="dob">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">City Address</label>
                            <textarea name="city_address" class="form-control" row="4"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact No.</label>
                            <input name="contact_no1" class="form-control" id="cn1">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Provincial Address</label>
                            <textarea name="province_address" class="form-control" row="4"></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact No.</label>
                            <input name="contact_no2" class="form-control" id="cn2">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Guardian/s</label>
                            <input name="guardian" class="form-control" id="gar">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Contact No.</label>
                            <input name="contact_no3" class="form-control" id="cn3">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Honors/Awards</label>
                            <textarea name="honor_award" class="form-control" row="4"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Past Scholarships</label>
                            <textarea name="past_scholar" class="form-control" row="4"></textarea>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">I intend to enroll/continue in the Program</label>
                            <input type="pro" name="program" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Year</label>
                            <input name="year" class="form-control">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Scholarships enjoyed at the present</label>
                            <textarea name="present_scholar" class="form-control" row="4"></textarea>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Work Experience (Describe briefly)</label>
                            <textarea name="work_experience" class="form-control" row="4"></textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Special Talents</label>
                            <textarea name="special_talent" class="form-control" row="4"></textarea>
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>




<?php
include('includes/footer.php');
include('includes/scripts.php');
?>