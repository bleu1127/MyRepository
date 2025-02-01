<?php
session_start();
include('admin/config/dbcon.php');
include('includes/header.php');
include('includes/navbar_tito.php');

date_default_timezone_set('Asia/Manila');

$id = isset($_GET['id']) ? $_GET['id'] : null;

$sa_id = $_SESSION['sa_id'] ?? null;
$profileImage = $_SESSION['sa_image'] ?? '';
if(empty($profileImage)) {
    $profileImage = 'images/defaultProfile.png';
}

$latestLog = null;
if ($sa_id) {
    $stmt = mysqli_prepare($con, "SELECT * FROM attendance WHERE sa_id = ? ORDER BY date DESC, time_in DESC LIMIT 1");
    mysqli_stmt_bind_param($stmt, "i", $sa_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $latestLog = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}

?>

<div class="container mt-3">
    <?php if(isset($_SESSION['message'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?= $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
</div>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Student Assistant Profile</h5>
                </div>
                <div class="card-body text-center">
                    <?php 
                    $imagePath = 'images/defaultProfile.png';
                    $name = "Student Assistant";
                    $work = "Work in"; 
                    $year = "Year";

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
                    <img src="<?= $profileImage ?>" 
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
            </div>

            <div class="card mt-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Fingerprint Time In/Out</h5>
                </div>
                <div class="card-body">
                    <div id="status" class="alert alert-info">
                        Initializing fingerprint scanner...
                    </div>
                    <div id="stepIndicator" class="alert alert-secondary" style="display:none">
                        Waiting for finger...
                    </div>
                    <div id="matchStatus" class="alert alert-info" style="display:none">
                    </div>

                    <div id="imagediv" class="text-center mb-3">
                        <img id="fingerprintPreview" src="" style="display:none; max-width: 200px;">
                        <i id="fingerprintIcon" class="fas fa-fingerprint" style="font-size: 100px; color: #007bff;"></i>
                    </div>
                    <div class="text-center">
                        <p id="connectionStatus">Connecting to fingerprint reader...</p>
                    </div>
                    <form id="attendance-form" method="post">
                        <input type="hidden" name="sa_id" id="sa_id">
                        <input type="hidden" name="fingerprintData" id="fingerprintData">
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header" style="background-color: #F16E04;">
                    <h5 class="card-title text-white mb-0">Latest Time Log</h5>
                </div>
                <div class="card-body p-0">
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
                        if ($latestLog) {
                            ?>
                            <tr>
                                <td><?= $latestLog['user_id'] ?></td>
                                <td><?= $name ?></td>
                                <td><?= date('Y-m-d', strtotime($latestLog['date'])) ?></td>
                                <td><?= date('H:i:s', strtotime($latestLog['time_in'])) ?></td>
                                <td><?= $latestLog['time_out'] ? date('H:i:s', strtotime($latestLog['time_out'])) : '-' ?></td>
                            </tr>
                            <?php
                        } else {
                            ?>
                            <tr>
                                <td colspan="5" class="text-center">No logs available</td>
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
        <div class="col-md-9">
            <div class="card">
                <div class="card-header" style="background-color: #F16E04;">
                    <h4 class="card-title text-white mb-0">Attendance Sheet</h4>
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

<?php
function matchFingerprint($template) {
    global $con;

    $query = "SELECT id, first_name, last_name, image, fingerprint_image 
              FROM student_assistant 
              WHERE fingerprint_image IS NOT NULL AND status != '2'";
    $result = mysqli_query($con, $query);
    
    while ($row = mysqli_fetch_assoc($result)) {
        if (compareTemplates($template, $row['fingerprint_image'])) {
            return $row;
        }
    }
    return null;
}
function compareTemplates($template1, $template2) {
    $t1 = base64_decode($template1);
    $t2 = $template2;
    
    $similarity = 0;
    $minLen = min(strlen($t1), strlen($t2));
    
    for ($i = 0; $i < $minLen; $i++) {
        if ($t1[$i] === $t2[$i]) {
            $similarity++;
        }
    }
    
    return ($similarity / $minLen) > 0.7; 
}

function processAttendance($sa_id, $con) {
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $status = 'Time In';

    $query = "SELECT * FROM attendance WHERE sa_id = ? AND date = ? AND time_out IS NULL";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "is", $sa_id, $date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $status = 'Time Out';
        $query = "UPDATE attendance SET time_out = ? WHERE sa_id = ? AND date = ? AND time_out IS NULL";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "sis", $time, $sa_id, $date);
    } else {
        $query = "INSERT INTO attendance (sa_id, date, time_in) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "iss", $sa_id, $date, $time);
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    return $status;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'match') {
    header('Content-Type: application/json');
    
    $fingerprintData = $_POST['template'] ?? null;
    if (!$fingerprintData) {
        echo json_encode(['success' => false, 'message' => 'No template provided']);
        exit;
    }

    $match = matchFingerprint($fingerprintData);
    if (!$match) {
        echo json_encode(['success' => false, 'message' => 'No match found']);
        exit;
    }

    $result = processAttendance($match['id'], $con);
    
    echo json_encode([
        'success' => true,
        'message' => $result,
        'sa' => [
            'id' => $match['id'],
            'name' => $match['first_name'] . ' ' . $match['last_name'],
            'image' => $match['image']
        ]
    ]);
    exit;
}

?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ESP32_URL = 'http://192.168.254.202';
    let retryTimeout;

    async function startFingerprintMatching() {
        try {
            const response = await fetch(`${ESP32_URL}/matchFingerprint`);
            const data = await response.json();
            console.log('Match response:', data);
            
            if (data.status === 'success') {
                updateStatus(`Match found! Processing attendance...`, 'success');
                await processAttendance(data.fingerprintId);
                await new Promise(resolve => setTimeout(resolve, 2000));
            } else if (data.status === 'waiting') {
                updateStatus('Place your finger on the sensor', 'info');
            } else if (data.status === 'not_found') {
                updateStatus('Fingerprint not recognized. Please try again.', 'warning');
                await new Promise(resolve => setTimeout(resolve, 2000));
            } else {
                console.error('Error response:', data);
                updateStatus(data.message || 'Device error, retrying...', 'warning');
                await new Promise(resolve => setTimeout(resolve, 2000));
            }
        } catch (error) {
            console.error('Matching error:', error);
            updateStatus('Connection error. Retrying...', 'danger');
            await new Promise(resolve => setTimeout(resolve, 5000));
        }

        if (retryTimeout) clearTimeout(retryTimeout);
        retryTimeout = setTimeout(startFingerprintMatching, 1000);
    }

    async function processAttendance(fingerprintId) {
        try {
            const response = await fetch('process_attendance.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ fingerprintId: fingerprintId })
            });
            const result = await response.json();
            
            if (result.success) {
                updateStatus(result.message, 'success');

                if (result.data) {
                    updateAttendanceDisplay(result.data);
                }
            } else {
                updateStatus(result.message || 'Failed to process attendance', 'warning');
            }
        } catch (error) {
            console.error('Attendance processing error:', error);
            updateStatus('Error processing attendance', 'danger');
        }
    }

    function updateStatus(message, type) {
        const statusDiv = document.getElementById('status');
        if (statusDiv) {
            statusDiv.className = `alert alert-${type}`;
            statusDiv.textContent = message;
        }
        console.log(`Status (${type}):`, message); 
    }

    function updateAttendanceDisplay(data) {
        const tbody = document.querySelector('.table-responsive tbody');
        if (tbody && data) {
            const row = `
                <tr>
                    <td>${data.sa_id}</td>
                    <td>${data.name}</td>
                    <td>${new Date().toISOString().split('T')[0]}</td>
                    <td>${data.action === 'Time In' ? data.time : '-'}</td>
                    <td>${data.action === 'Time Out' ? data.time : '-'}</td>
                </tr>`;
            tbody.innerHTML = row;
        }
    }

    startFingerprintMatching();

    window.addEventListener('beforeunload', () => {
        if (retryTimeout) clearTimeout(retryTimeout);
    });
});
</script>

