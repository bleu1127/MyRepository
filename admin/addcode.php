<?php
session_start();
include('config/dbcon.php');








if (isset($_POST['add_btn'])) {
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $age = mysqli_real_escape_string($con, $_POST['age']);
    $sex = mysqli_real_escape_string($con, $_POST['sex']);
    $civil_status = mysqli_real_escape_string($con, $_POST['civil_status']);
    $date_of_birth = mysqli_real_escape_string($con, $_POST['date_of_birth']);
    $city_address = mysqli_real_escape_string($con, $_POST['city_address']);
    $contact_no1 = mysqli_real_escape_string($con, $_POST['contact_no1']);
    $contact_no2 = mysqli_real_escape_string($con, $_POST['contact_no2']);
    $contact_no3 = mysqli_real_escape_string($con, $_POST['contact_no3']);
    $province_address = mysqli_real_escape_string($con, $_POST['province_address']);
    $guardian = mysqli_real_escape_string($con, $_POST['guardian']);
    $honor_award = mysqli_real_escape_string($con, $_POST['honor_award']);
    $past_scholar = mysqli_real_escape_string($con, $_POST['past_scholar']);
    $program = mysqli_real_escape_string($con, $_POST['program']);
    $year = mysqli_real_escape_string($con, $_POST['year']);
    $present_scholar = mysqli_real_escape_string($con, $_POST['present_scholar']);
    $work_experience = mysqli_real_escape_string($con, $_POST['work_experience']);
    $special_talent = mysqli_real_escape_string($con, $_POST['special_talent']);

    // New fields for references and family information
    $out_name1 = mysqli_real_escape_string($con, $_POST['out_name1']);
    $comp_add1 = mysqli_real_escape_string($con, $_POST['comp_add1']);
    $cn1 = mysqli_real_escape_string($con, $_POST['cn1']);
    $out_name2 = mysqli_real_escape_string($con, $_POST['out_name2']);
    $comp_add2 = mysqli_real_escape_string($con, $_POST['comp_add2']);
    $cn2 = mysqli_real_escape_string($con, $_POST['cn2']);
    $out_name3 = mysqli_real_escape_string($con, $_POST['out_name3']);
    $comp_add3 = mysqli_real_escape_string($con, $_POST['comp_add3']);
    $cn3 = mysqli_real_escape_string($con, $_POST['cn3']);
    $from_wit1 = mysqli_real_escape_string($con, $_POST['from_wit1']);
    $comp_add4 = mysqli_real_escape_string($con, $_POST['comp_add4']);
    $cn4 = mysqli_real_escape_string($con, $_POST['cn4']);
    $from_wit2 = mysqli_real_escape_string($con, $_POST['from_wit2']);
    $comp_add5 = mysqli_real_escape_string($con, $_POST['comp_add5']);
    $cn5 = mysqli_real_escape_string($con, $_POST['cn5']);
    $from_wit3 = mysqli_real_escape_string($con, $_POST['from_wit3']);
    $comp_add6 = mysqli_real_escape_string($con, $_POST['comp_add6']);
    $cn6 = mysqli_real_escape_string($con, $_POST['cn6']);
    $fathers_name = mysqli_real_escape_string($con, $_POST['fathers_name']);
    $fathers_occ = mysqli_real_escape_string($con, $_POST['fathers_occ']);
    $fathers_income = mysqli_real_escape_string($con, $_POST['fathers_income']);
    $mothers_name = mysqli_real_escape_string($con, $_POST['mothers_name']);
    $mothers_occ = mysqli_real_escape_string($con, $_POST['mothers_occ']);
    $mothers_income = mysqli_real_escape_string($con, $_POST['mothers_income']);
    $siblings = mysqli_real_escape_string($con, $_POST['siblings']);

    // Continue with your database insertion logic...


    $image = $_FILES['image']['name'];
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_extension;

    // Ensure $_POST['work_in'] is an array
    $work_in = isset($_POST['work_in']) ? $_POST['work_in'] : [];
    $work_in_string = "";
    foreach ($work_in as $row) {
        $work_in_string .= $row . ", ";
    }
    $work_in_string = rtrim($work_in_string, ", "); // Remove trailing comma

    $user_query = "INSERT INTO student_assistant (
        last_name, first_name, age, sex, image, civil_status, date_of_birth, city_address, contact_no1,contact_no2,contact_no3, province_address,  guardian,  honor_award,past_scholar, program, year, present_scholar, work_experience, special_talent, out_name1, comp_add1, cn1, out_name2, comp_add2, cn2, out_name3, comp_add3, cn3, from_wit1, comp_add4, cn4, from_wit2, comp_add5, cn5, from_wit3, comp_add6, cn6, fathers_name, fathers_occ, fathers_income, mothers_name, mothers_occ, mothers_income, siblings
    ) VALUES (
        '$last_name', '$first_name', '$age', '$sex', '$filename', '$civil_status', '$date_of_birth', '$city_address', '$contact_no1','$contact_no2','$contact_no3', '$province_address', '$guardian',  '$honor_award', '$past_scholar', '$program', '$year', '$present_scholar', '$work_experience', '$special_talent','$out_name1', '$comp_add1', '$cn1', '$out_name2', '$comp_add2', '$cn2', '$out_name3', '$comp_add3', '$cn3', '$from_wit1', '$comp_add4', '$cn4', '$from_wit2', '$comp_add5', '$cn5', '$from_wit3', '$comp_add6', '$cn6', '$fathers_name', '$fathers_occ', '$fathers_income', '$mothers_name', '$mothers_occ', '$mothers_income', '$siblings')";
    

    $user_query_run = mysqli_query($con, $user_query);

    if ($user_query_run) {
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$filename);
        header("Location: view-register.php");
        exit(0);
    } else {
        header("Location: add.php");
        exit(0);
    }
} else {
    header("Location: view-register.php");
    exit(0);
}

?>