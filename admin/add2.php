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
                        <a href="add1.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form class="row g-3" action="add3.php" method="POST">


                        <?php
                        $query = "SELECT * FROM work";
                        $query_run = mysqli_query($con, $query);

                        $offices = [];
                        $laboratories = [];
                        $manpower_services = [];

                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_assoc($query_run)) {
                                switch ($row['type']) {
                                    case 'Office':
                                        $offices[] = $row['work_name'];
                                        break;
                                    case 'Laboratory':
                                        $laboratories[] = $row['work_name'];
                                        break;
                                    case 'Manpower Services':
                                        $manpower_services[] = $row['work_name'];
                                        break;
                                }
                            }
                        }
                        ?>

                        <div class="row">
                            <div class="col-md-4">
                                <label for="offices" class="form-label"><strong>Offices</strong></label>
                                <?php foreach ($offices as $office): ?>
                                    <div>
                                        <input type="checkbox" name="work_in[]" value="<?php echo htmlspecialchars($office); ?>"> <?php echo htmlspecialchars($office); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="col-md-4">
                                <label for="laboratories" class="form-label"><strong>Laboratories</strong></label>
                                <?php foreach ($laboratories as $laboratory): ?>
                                    <div>
                                        <input type="checkbox" name="work_in[]" value="<?php echo htmlspecialchars($laboratory); ?>"> <?php echo htmlspecialchars($laboratory); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="col-md-4">
                                <label for="manpower_services" class="form-label"><strong>Manpower Services</strong></label>
                                <?php foreach ($manpower_services as $service): ?>
                                    <div>
                                        <input type="checkbox" name="work_in[]" value="<?php echo htmlspecialchars($service); ?>"> <?php echo htmlspecialchars($service); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
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