<?php

include('authentication.php');
include('includes/header.php');

// if(!isset($_SESSION['auth'])){
//     header("Location: login.php?error_msg=Invalid Access");
// }
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Time Log Report</h1>
    <ol class="breadcrumb mb-4">
    </ol>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">January
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Office';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>

                    
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="offices.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">February
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Laboratory';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="laboratories.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">March
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Manpower Services';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="services.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">April
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Manpower Services';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="services.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">May
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Manpower Services';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="services.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">June
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Manpower Services';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="services.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">July
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Manpower Services';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="services.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">August
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Manpower Services';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="services.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4">
                <div class="card-body">September
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Manpower Services';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="services.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">October
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Manpower Services';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="services.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">November
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Manpower Services';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="services.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">December
                <?php
                    $dash_work_query = "SELECT sa.*, w.work_name 
                           FROM student_assistant sa
                           JOIN work w 
                           ON sa.work LIKE CONCAT('%', w.work_name, '%')
                           WHERE w.type = 'Manpower Services';";
                    $dash_work_query_run = mysqli_query($con,$dash_work_query);

                    if($work_total = mysqli_num_rows($dash_work_query_run)){
                        echo '<h4 class="mb-0">'.$work_total.' </h4>';
                    }else{
                        echo '<h4 class="mb-0"> No Data </h4>';
                    }
                ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="services.php">View</a>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php
include('includes/footer.php');
include('includes/scripts.php');
?>