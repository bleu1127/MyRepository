<?php
session_start();
include('admin/config/dbcon.php');
include('includes/header.php');
include('includes/navbar_tito.php');

date_default_timezone_set('Asia/Manila');


$id = isset($_GET['id']) ? $_GET['id'] : null;

// Handle fingerprint action requests
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    if ($_GET['action'] === 'get_fingerprints') {
        // Retrieve SA IDs and their fingerprint templates
        $query = "SELECT id, fingerprint_image FROM student_assistant WHERE fingerprint_image IS NOT NULL";
        $result = mysqli_query($con, $query);

        $fingerprints = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $fingerprints[] = [
                'id' => $row['id'],
                'template' => base64_encode($row['fingerprint_image'])
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($fingerprints);
        echo json_encode($fingerprints);
        exit();
    }
}

// Handle fingerprint POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sa_id'])) {
    $sa_id = mysqli_real_escape_string($con, $_POST['sa_id']);
    $result = processAttendance($con, $sa_id);
    
    // Get SA details for dialog message
    $query = "SELECT first_name, last_name FROM student_assistant WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $sa_id);
    mysqli_stmt_execute($stmt);
    $result_sa = mysqli_stmt_get_result($stmt);
    
    if ($sa_info = mysqli_fetch_assoc($result_sa)) {
        $log_message = "SA: {$sa_info['first_name']} {$sa_info['last_name']} - $result";
        
        // Show success dialog
        echo "<script>
            Swal.fire({
                title: 'Time Log Recorded!',
                text: '{$sa_info['first_name']} {$sa_info['last_name']} {$result}',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Unable to find SA record',
                icon: 'error',
                timer: 2000,
                showConfirmButton: false
            });
        </script>";
    }
    
    echo "<script>console.log('$log_message');</script>";
    
    // Redirect to prevent form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}


// Function to get the latest SA who timed in/out
function get_latest_sa($con) {
    $query = "SELECT sa.id, sa.first_name, sa.last_name, sa.image, a.status, a.created_at 
              FROM student_assistant sa 
              JOIN attendance a ON sa.id = a.sa_id 
              ORDER BY a.created_at DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    return mysqli_fetch_assoc($result);
}

// Add this function after existing get_latest_sa function
function processAttendance($con, $sa_id) {
    $today = date('Y-m-d');
    $now = date('H:i:s');
    $day = date('l');
    
    // Check if SA already has attendance record for today
    $check_query = "SELECT * FROM attendance WHERE sa_id = ? AND date = ? ORDER BY time_in DESC LIMIT 1";
    $stmt = mysqli_prepare($con, $check_query);
    mysqli_stmt_bind_param($stmt, "is", $sa_id, $today);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        if ($row['time_out'] === null) {
            // Time out
            $update_query = "UPDATE attendance SET time_out = ?, status = 'Completed' WHERE id = ?";
            $stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt, "si", $now, $row['id']);
            if (mysqli_stmt_execute($stmt)) {
                return "Time out recorded successfully";
            }
        }
    } else {
        // Time in
        $insert_query = "INSERT INTO attendance (sa_id, date, day, time_in, status) 
                        VALUES (?, ?, ?, ?, 'Present')";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "isss", 
            $sa_id,
            $today,
            $day,
            $now
        );
        if (mysqli_stmt_execute($stmt)) {
            return "Time in recorded successfully";
        }
    }
    return "Failed to record attendance";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if ($data['action'] === 'verify_fingerprint') {
        $fingerprintToVerify = trim($data['fingerprint']);

        // Debug log: fingerprint data received
        error_log("Fingerprint to verify (length: " . strlen($fingerprintToVerify) . ")");

        // Get all SAs with fingerprints
        $query = "SELECT id, CONCAT(first_name, ' ', last_name) as name, fingerprint_image 
                 FROM student_assistant 
                 WHERE fingerprint_image IS NOT NULL";
        $result = mysqli_query($con, $query);

        if (!$result) {
            error_log("Error fetching fingerprints: " . mysqli_error($con));
        }

        $matchFound = false;
        while ($row = mysqli_fetch_assoc($result)) {
            $storedFingerprint = trim($row['fingerprint_image']);

            // Debug log: stored fingerprint data
            error_log("Comparing with SA ID: {$row['id']}, Name: {$row['name']}, Fingerprint length: " . strlen($storedFingerprint));

            // Compare fingerprints with some tolerance
            $similarity = similar_text($storedFingerprint, $fingerprintToVerify, $percent);

            error_log("Similarity with SA ID {$row['id']}: $percent%");

            if ($percent > 80) { // Adjust threshold as needed
                error_log("Match found with SA ID {$row['id']}! Similarity: $percent%");
                echo json_encode([
                    'matched' => true,
                    'sa_id' => $row['id'],
                    'sa_name' => $row['name']
                ]);
                $matchFound = true;
                break;
            }
        }

        if (!$matchFound) {
            error_log("No matching fingerprint found");
            echo json_encode(['matched' => false]);
        }
        return;
    }

    if ($data['action'] === 'record_attendance') {
        $saId = isset($data['sa_id']) ? intval($data['sa_id']) : 0;

        // Debugging: log the sa_id received
        error_log("record_attendance action called with sa_id: $saId");

        if ($saId > 0) {
            $date = date('Y-m-d');
            $time = date('H:i:s');
            $day = date('l');

            // Use prepared statements to prevent SQL injection
            $check_query = "SELECT * FROM attendance WHERE sa_id = ? AND date = ?";
            $stmt = mysqli_prepare($con, $check_query);
            mysqli_stmt_bind_param($stmt, "is", $saId, $date);
            mysqli_stmt_execute($stmt);
            $check_result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($check_result) > 0) {
                $attendance = mysqli_fetch_assoc($check_result);

                if (!$attendance['time_out']) {
                    $update_query = "UPDATE attendance SET time_out = ?, status = 'Completed' WHERE sa_id = ? AND date = ?";
                    $stmt = mysqli_prepare($con, $update_query);
                    mysqli_stmt_bind_param($stmt, "sis", $time, $saId, $date);

                    if (mysqli_stmt_execute($stmt)) {
                        echo json_encode(['success' => true, 'message' => 'Time out recorded']);
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error recording time out']);
                    }
                } else {
                    echo json_encode(['success' => false, 'message' => 'Attendance already completed for today']);
                }
            } else {
                $insert_query = "INSERT INTO attendance (sa_id, date, day, time_in, status) VALUES (?, ?, ?, ?, 'Ongoing')";
                $stmt = mysqli_prepare($con, $insert_query);
                mysqli_stmt_bind_param($stmt, "isss", $saId, $date, $day, $time);

                if (mysqli_stmt_execute($stmt)) {
                    echo json_encode(['success' => true, 'message' => 'Time in recorded']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error recording time in']);
                }
            }
        } else {
            error_log("Invalid sa_id received: $saId");
            echo json_encode(['success' => false, 'message' => 'Invalid SA ID']);
        }
        return;
    }
}

?>


<div class="container-fluid py-4">
  <div class="row px-4">
    <div class="col-md-3">
      <div class="card text-center p-3">
        <?php 
        $imagePath = './images/defaultProfile.png';
        $name = "Student Assistant";
        $work = "Work in"; 
        $year = "Year";

        // Get student data if ID is provided
        if ($id) {
            $sa = "SELECT * FROM student_assistant WHERE id=?";
            if($stmt = mysqli_prepare($con, $sa)) {
                mysqli_stmt_bind_param($stmt, "s", $id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if($row = mysqli_fetch_array($result)) {
                    $imagePath = !empty($row['image']) ? $row['image'] : './images/defaultProfile.png';
                    $name = $row['first_name'] . ' ' . $row['last_name'];
                    $work = $row['work'];
                    $year = 'Year ' . $row['year'];
                }
                mysqli_stmt_close($stmt);
            }
        }
        ?>
        <img src="<?= $imagePath ?>" 
             class="mx-auto d-block" 
             alt="Profile Photo"    
             style="width: 200px; 
                    height: 200px;
                    object-fit: contain;
                    border: 3px solid #c0c0c0;
                    border-radius: 8px;
                    background-color: #f8f9fa;
                    margin-bottom: 15px;">
        
        <div class="card-body px-3 py-2">
          <h5 class="card-title"><?= $name ?></h5>
          <p class="card-text mb-1"><?= $work ?></p>
          <p class="card-text"><small class="text-muted"><?= $year ?></small></p>
        </div>  
      </div>

      <!-- Fingerprint Reader Box -->
      <div class="card mt-3 p-3">
        <h6 class="card-title">Fingerprint Time In/Out</h6>
        <div class="fingerprint-box">
          <h6>Place your finger on the reader</h6>
          <div id="status"></div>
          <div id="imagediv">
            <canvas id="fingerprint-canvas" width="300" height="300"></canvas>
          </div>
          <div id="contentButtons">
            <button type="button" class="btn btn-primary" id="startButton">Start Capture</button>
            <button type="button" class="btn btn-secondary" id="stopButton" disabled>Stop</button>
          </div>
          <form id="attendance-form" method="post">
            <input type="hidden" name="sa_id" id="sa_id">
            <input type="hidden" name="fingerprintData" id="fingerprintData">
          </form>
        </div>
      </div>

      <!-- Latest Time Log Card -->
      <div class="card mt-3">
        <div class="card-header text-white text-center" style="background-color: #F16E04;">
          <h6 class="mb-0">Latest Time Log</h6>
        </div>
        <div class="card-body p-2">
          <div class="table-responsive">
            <table class="table table-sm table-bordered mb-0" style="font-size: 12px;">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Date</th>
                  <th>Time In</th>
                  <th>Time Out</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $latest_log_query = "SELECT a.*, sa.first_name, sa.last_name 
                                    FROM attendance a 
                                    JOIN student_assistant sa ON a.sa_id = sa.id 
                                    WHERE sa_id=? 
                                    ORDER BY date DESC, time_in DESC LIMIT 1";
              if($stmt = mysqli_prepare($con, $latest_log_query)) {
                  mysqli_stmt_bind_param($stmt, "s", $id);
                  mysqli_stmt_execute($stmt);
                  $log_result = mysqli_stmt_get_result($stmt);
                  
                  if(mysqli_num_rows($log_result) > 0) {
                      $log = mysqli_fetch_array($log_result);
                      ?>
                      <tr>
                          <td><?= $log['user_id'] ?></td>
                          <td><?= $log['first_name'] . ' ' . $log['last_name'] ?></td>
                          <td><?= date('Y-m-d', strtotime($log['date'])) ?></td>
                          <td><?= date('H:i:s', strtotime($log['time_in'])) ?></td>
                          <td><?= $log['time_out'] ? date('H:i:s', strtotime($log['time_out'])) : '-' ?></td>
                      </tr>
                      <?php
                  } else {
                      ?>
                      <tr>
                          <td colspan="5" class="text-center">No logs available</td>
                      </tr>
                      <?php
                  }
                  mysqli_stmt_close($stmt);
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-9" style="padding-left: 100px;">
      <div class="card">
        <div class="card-header text-white text-center" style="background-color: #F16E04;">
          <h4 class="mb-0">Attendance Sheet</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive" style="height: 730px; overflow-y: auto;">
            <table class="table table-bordered table-striped table-hover" style="font-size: 14px;">
              <thead style="position: sticky; top: 0; background: white; z-index: 1;">
                            <tr>
                                <th>ID</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Work in</th>
                                <th>Year</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Time in</th>
                                <th>Time out</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT sa.*, a.date, a.day, a.time_in, a.time_out, a.status as attendance_status 
                                      FROM student_assistant sa 
                                      LEFT JOIN attendance a ON sa.id = a.sa_id 
                                      WHERE sa.status!='2'";
                            $query_run = mysqli_query($con, $query);
                            if (mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $row) {
                            ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['last_name']; ?></td>
                                        <td><?= $row['first_name']; ?></td>
                                        <td><?= $row['work']; ?></td>
                                        <td><?= $row['year']; ?></td>
                                        <td><?= $row['date'] ? date('Y-m-d', strtotime($row['date'])) : '-'; ?></td>
                                        <td><?= $row['day'] ?? '-'; ?></td>
                                        <td><?= $row['time_in'] ? date('H:i:s', strtotime($row['time_in'])) : '-'; ?></td>
                                        <td><?= $row['time_out'] ? date('H:i:s', strtotime($row['time_out'])) : '-'; ?></td>
                                        <td><?= $row['attendance_status'] ?? '-'; ?></td>
                                    </tr>
                                <?php
                                }
                            } else {
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
</div>

<script src="admin/scripts/es6-shim.js"></script>
<script src="admin/scripts/websdk.client.bundle.min.js"></script>
<script src="admin/scripts/fingerprint.sdk.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let sdk = new Fingerprint.WebApi();
    let isCapturing = false;

    // Set up SDK event handlers
    sdk.onDeviceConnected = function(e) {
        showMessage('Device connected: ' + e.deviceUid);
    };
    
    sdk.onDeviceDisconnected = function(e) {
        showMessage('Device disconnected: ' + e.deviceUid);
        isCapturing = false;
    };

    sdk.onCommunicationFailed = function(e) {
        showMessage('Communication failed - retrying...');
        // Attempt to recover connection
        setTimeout(function() {
            init();
        }, 1000);
    };

    sdk.onSamplesAcquired = function(s) {
        try {
            const samples = JSON.parse(s.samples);
            if (samples.length > 0) {
                const fingerprintData = Fingerprint.b64UrlTo64(samples[0]); 
                document.getElementById('fingerprintData').value = fingerprintData;
                
                // Update canvas with fingerprint image
                const img = new Image();
                img.onload = function() {
                    const canvas = document.getElementById('fingerprint-canvas');
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                };
                img.src = 'data:image/png;base64,' + fingerprintData;
                
                showMessage('Fingerprint captured successfully');
                
                // Submit the form
                document.getElementById('attendance-form').submit();
            }
        } catch (err) {
            console.error('Sample processing error:', err);
            showMessage('Error processing fingerprint');
        }
    };

    // Initialize SDK
    async function init() {
        try {
            const devices = await sdk.enumerateDevices();
            if (devices && devices.length > 0) {
                document.getElementById('startButton').disabled = false;
                document.getElementById('stopButton').disabled = true;
                showMessage('Reader ready - Click Start Capture');
                return true;
            }
            showMessage('No fingerprint readers found');
            return false;
        } catch (err) {
            console.error('SDK init error:', err);
            showMessage('Failed to initialize reader. Please check device connection.');
            return false;
        }
    }

    // Start capture handler
    document.getElementById('startButton').addEventListener('click', async function() {
        if (isCapturing) return;
        
        try {
            await sdk.startAcquisition(Fingerprint.SampleFormat.PngImage);
            isCapturing = true;
            document.getElementById('startButton').disabled = true;
            document.getElementById('stopButton').disabled = false;
            showMessage('Place finger on reader');
        } catch (err) {
            console.error('Start capture error:', err);
            showMessage('Failed to start capture - please try again');
            isCapturing = false;
        }
    });

    // Stop capture handler
    document.getElementById('stopButton').addEventListener('click', async function() {
        if (!isCapturing) return;
        
        try {
            await sdk.stopAcquisition();
            isCapturing = false;
            document.getElementById('startButton').disabled = false;
            document.getElementById('stopButton').disabled = true;
            showMessage('Capture stopped');
        } catch (err) {
            console.error('Stop capture error:', err);
            showMessage('Error stopping capture');
        }
    });

    // Initialize when page loads
    init();
});

function showMessage(message) {
    const status = document.getElementById('status');
    if (status) {
        status.innerHTML = '<div class="alert alert-' + 
            (message.toLowerCase().includes('error') ? 'danger' : 'info') + 
            '">' + message + '</div>';
        console.log('Status:', message);
    }
}
</script>

<scirpt src="admin/app.js"></script>

<?php
include('includes/footer.php');
?>