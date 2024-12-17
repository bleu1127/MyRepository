<?php
session_start();
include('config/dbcon.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if regular form submission for adding a student assistant
    if (isset($_POST['add_btn'])) {
        // Log received data
        error_log("POST data received: " . print_r($_POST, true));
        // Debug log to see all received data
        error_log("Full POST data: " . print_r($_POST, true));
        
        // Initialize all variables with default empty values
        $fields = array(
            'last_name' => '', 'first_name' => '', 'age' => '', 'sex' => '',
            'civil_status' => '', 'date_of_birth' => '', 'city_address' => '', 'contact_no1' => '',
            'contact_no2' => '', 'contact_no3' => '', 'province_address' => '', 'guardian' => '',
            'honor_award' => '', 'past_scholar' => '', 'program' => '', 'year' => '',
            'present_scholar' => '', 'work_experience' => '', 'special_talent' => '',
            'out_name1' => '', 'comp_add1' => '', 'cn1' => '', 'out_name2' => '',
            'comp_add2' => '', 'cn2' => '', 'out_name3' => '', 'comp_add3' => '',
            'cn3' => '', 'from_wit1' => '', 'comp_add4' => '', 'cn4' => '',
            'from_wit2' => '', 'comp_add5' => '', 'cn5' => '', 'from_wit3' => '',
            'comp_add6' => '', 'cn6' => '', 'fathers_name' => '', 'fathers_occ' => '',
            'fathers_income' => '', 'mothers_name' => '', 'mothers_occ' => '', 'mothers_income' => '',
            'siblings' => ''
        );

        // Safely get POST values
        foreach($fields as $field => $default) {
            $$field = isset($_POST[$field]) ? mysqli_real_escape_string($con, $_POST[$field]) : $default;
        }

        // Initialize fields with values from POST
        foreach($fields as $field => &$value) {
            if(isset($_POST[$field])) {
                $value = mysqli_real_escape_string($con, $_POST[$field]);
                error_log("Field $field = $value"); // Debug log each field
            }
        }

        // Handle fingerprint data with better error checking
        $fingerprint_data = $_POST['fingerprintData'] ?? '';

        // Validate fingerprint data
        if (empty($fingerprint_data)) {
            $_SESSION['message'] = "Error: No fingerprint data provided";
            error_log("Missing fingerprint data");
            header("Location: add4.php");
            exit();
        }

        // Basic validation of base64 data
        if (!preg_match('/^[A-Za-z0-9+\/]+={0,2}$/', $fingerprint_data)) {
            error_log("Invalid fingerprint format");
            $_SESSION['message'] = "Error: Invalid fingerprint format";
            header("Location: add4.php");
            exit();
        }

        // Convert base64 to binary before storing
        $fingerprint_binary = base64_decode($fingerprint_data);
        if ($fingerprint_binary === false) {
            $_SESSION['message'] = "Error: Could not process fingerprint data";
            header("Location: add4.php");
            exit();
        }

        // Single image handling section - remove duplicate section
        $filename = '';
        if(isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
            $image = $_FILES['profile_image']['name'];
            if(!empty($image)) {
                // Set up upload directory
                $upload_dir = "../images/uploads/profileImages/";
                
                // Create directories if they don't exist
                if(!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                // Generate unique filename
                $extension = pathinfo($image, PATHINFO_EXTENSION);
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $upload_path = $upload_dir . $filename;
                
                // Move uploaded file
                if(move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_path)) {
                    error_log("File uploaded successfully to: " . $upload_path);
                    $filename = '../images/uploads/profileImages/' . $filename; // Store relative path
                } else {
                    error_log("Failed to upload file to: " . $upload_path);
                    $filename = ''; // Reset filename if upload fails
                }
            }
        } elseif(isset($_SESSION['temp_image'])) { // Handle image from session if exists
            $temp_image_path = $_SESSION['temp_image'];
            if(!empty($temp_image_path) && file_exists($temp_image_path)) {
                // Set up final upload directory
                $upload_dir = "../images/uploads/profileImages/";
                if(!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                
                // Generate unique filename
                $extension = pathinfo($temp_image_path, PATHINFO_EXTENSION);
                $filename = time() . '_' . uniqid() . '.' . $extension;
                $final_path = $upload_dir . $filename;
                
                // Move temp file to final destination
                if(rename($temp_image_path, $final_path)) {
                    error_log("File moved successfully to: " . $final_path);
                    $filename = '../images/uploads/profileImages/' . $filename; // Store relative path
                    unset($_SESSION['temp_image']);
                } else {
                    error_log("Failed to move file to: " . $final_path);
                    $filename = ''; // Reset filename if move fails
                }
            }
        }

        // Handle work array properly
        $work_in = isset($_POST['work_in']) ? $_POST['work_in'] : [];
        $work_string = !empty($work_in) ? implode(", ", $work_in) : '';

        // Debug logging
        error_log("Image filename: " . $filename);
        error_log("Work string: " . $work_string);

        // Handle siblings data with arrays
        $siblings_data = [];
        if (isset($_POST['sibling_name'])) {
            error_log("Received sibling data: " . print_r($_POST, true)); // Debug log
            
            $sibling_names = $_POST['sibling_name'] ?? [];
            $sibling_ages = $_POST['sibling_age'] ?? [];
            $sibling_levels = $_POST['sibling_level'] ?? [];
            $sibling_statuses = $_POST['sibling_status'] ?? [];
            
            for($i = 0; $i < count($sibling_names); $i++) {
                if(!empty($sibling_names[$i])) {
                    $siblings_data[] = [
                        'name' => $sibling_names[$i],
                        'age' => $sibling_ages[$i] ?? '',
                        'level' => $sibling_levels[$i] ?? '',
                        'status' => $sibling_statuses[$i] ?? ''
                    ];
                }
            }
        }

        // Convert siblings data to JSON string with error checking
        if (!empty($siblings_data)) {
            $siblings = json_encode($siblings_data);
            if ($siblings === false) {
                error_log("JSON encoding error: " . json_last_error_msg());
                $siblings = json_encode([]); // Fallback to empty array
            }
        } else {
            $siblings = json_encode([]); // Store empty array instead of null
        }

        error_log("Final siblings JSON: " . $siblings); // Debug log

        // Build and execute query
        try {
            $user_query = "INSERT INTO student_assistant (
                last_name, first_name, age, sex, image, fingerprint_image, 
                civil_status, date_of_birth, city_address, contact_no1,
                contact_no2, contact_no3, province_address, guardian, 
                honor_award, past_scholar, program, year, present_scholar,
                work_experience, special_talent, work, out_name1, comp_add1, 
                cn1, out_name2, comp_add2, cn2, out_name3, comp_add3, cn3,
                from_wit1, comp_add4, cn4, from_wit2, comp_add5, cn5,
                from_wit3, comp_add6, cn6, fathers_name, fathers_occ,
                fathers_income, mothers_name, mothers_occ, mothers_income, siblings
            ) VALUES (" . str_repeat('?,', 46) . "?)";

            $stmt = mysqli_prepare($con, $user_query);
            if($stmt) {
                mysqli_stmt_bind_param($stmt, str_repeat('s', 46) . 's',
                    $last_name, $first_name, $age, $sex, $filename, $fingerprint_binary,
                    $civil_status, $date_of_birth, $city_address, $contact_no1, 
                    $contact_no2, $contact_no3, $province_address, $guardian,
                    $honor_award, $past_scholar, $program, $year, $present_scholar,
                    $work_experience, $special_talent, $work_string, $out_name1, $comp_add1,
                    $cn1, $out_name2, $comp_add2, $cn2, $out_name3, $comp_add3, $cn3,
                    $from_wit1, $comp_add4, $cn4, $from_wit2, $comp_add5, $cn5,
                    $from_wit3, $comp_add6, $cn6, $fathers_name, $fathers_occ,
                    $fathers_income, $mothers_name, $mothers_occ, $mothers_income, $siblings
                );

                if(mysqli_stmt_execute($stmt)) {
                    $_SESSION['message'] = "Student Assistant added successfully";
                    header("Location: view-register.php");
                    exit();
                } else {
                    throw new Exception(mysqli_error($con));
                }
            } else {
                throw new Exception(mysqli_error($con));
            }
        } catch(Exception $e) {
            error_log("Database error: " . $e->getMessage());
            $_SESSION['message'] = "Error adding student: " . $e->getMessage();
            header("Location: add4.php");
            exit();
        }
    }

    // Handle fingerprint data update (if applicable)
    if (isset($_POST['sa_id']) && isset($_POST['fingerprintData'])) {
        $sa_id = $_POST['sa_id'];
        $fingerprint_data = $_POST['fingerprintData'];

        if ($sa_id && $fingerprint_data) {
            // Decode the Base64 fingerprint data
            $decoded_fingerprint = base64_decode($fingerprint_data);
            if ($decoded_fingerprint === false) {
                $_SESSION['message'] = "Error decoding fingerprint data.";
                header("Location: add4.php");
                exit();
            }

            // Prepare SQL statement to insert fingerprint as BLOB
            $stmt = $con->prepare("UPDATE student_assistant SET fingerprint_column = ? WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param("bi", $fingerprint_blob, $sa_id);
                $fingerprint_blob = $decoded_fingerprint;
                $stmt->send_long_data(0, $fingerprint_blob);

                if ($stmt->execute()) {
                    $_SESSION['message'] = "Fingerprint data saved successfully.";
                } else {
                    $_SESSION['message'] = "Failed to save fingerprint data.";
                    error_log("Failed to execute fingerprint update: " . $stmt->error);
                }

                $stmt->close();
            } else {
                $_SESSION['message'] = "Database error: " . $con->error;
                error_log("Failed to prepare fingerprint update statement: " . $con->error);
            }
        } else {
            $_SESSION['message'] = "Incomplete data submitted.";
        }

        header("Location: add4.php");
        exit;
    }
}
?>