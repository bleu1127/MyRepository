<?php
session_start();
include('authentication.php');
include('includes/header.php');
?>

<head>
  <meta charset="utf-8" />
  <link rel="stylesheet" href="css/bootstrap-min.css">
  <link rel="stylesheet" href="app.css" type="text/css" />
</head>

<body>
  <form action="addcode.php" method="POST" enctype="multipart/form-data">
    <!-- Add hidden fields to carry forward data from previous forms -->
    <?php 
    // Carry forward data from previous forms
    $previous_data = array(
        'last_name', 'first_name', 'age', 'sex', 'civil_status', 'date_of_birth',
        'city_address', 'contact_no1', 'contact_no2', 'contact_no3', 
        'province_address', 'guardian', 'honor_award', 'past_scholar',
        'program', 'year', 'present_scholar', 'work_experience', 'special_talent',
        'out_name1', 'comp_add1', 'cn1', 'out_name2', 'comp_add2', 'cn2',
        'out_name3', 'comp_add3', 'cn3', 'from_wit1', 'comp_add4', 'cn4',
        'from_wit2', 'comp_add5', 'cn5', 'from_wit3', 'comp_add6', 'cn6',
        'fathers_name', 'fathers_occ', 'fathers_income', 'mothers_name', 
        'mothers_occ', 'mothers_income', 'siblings'
    );

    foreach($previous_data as $field) {
        if(isset($_POST[$field])) {
            echo '<input type="hidden" name="'.$field.'" value="'.htmlspecialchars($_POST[$field]).'">';
        }
    }

    // Handle arrays like work_in
    if(isset($_POST['work_in']) && is_array($_POST['work_in'])) {
        foreach($_POST['work_in'] as $work) {
            echo '<input type="hidden" name="work_in[]" value="'.htmlspecialchars($work).'">';
        }
    }
    ?>

    <!-- Single hidden input for fingerprint data -->
    <input type="hidden" id="fingerprintData" name="fingerprintData" value="">
    
    <div class="container-fluid px-0">
      <div class="row">
        <div class="col-md-12">
          <?php
          if(isset($_SESSION['message'])) {
              ?>
              <div class="alert alert-danger">
                  <?= $_SESSION['message']; ?>
              </div>
              <?php
              unset($_SESSION['message']);
          }
          ?>
          <div class="card">
            <div class="card-header">
              <h4>Register Student Assistant Fingerprint
                <a href="add3.php" class="btn btn-danger float-end">Back</a>
              </h4>
            </div>
            
            <div id="Container">
              <div class="alert alert-info">
                Please start capture and place your finger on the reader
              </div>

              <div id="content-capture">
                <div id="status"></div>
                <div id="imagediv">
                  <div>Fingerprint preview will appear here</div>
                </div>
                <div id="contentButtons">
                  <input type="button" class="btn btn-primary" id="start" value="Start Capture" onclick="onStart()">
                  <input type="button" class="btn btn-secondary" id="stop" value="Stop" onclick="onStop()">
                </div>
                <div class="action-buttons">
                  <button type="submit" name="add_btn" class="btn btn-success" 
                          onclick="return validateForm()">Save Student Assistant</button>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </form>
  
<script src="lib/jquery.min.js"></script>
<script src="lib/bootstrap.min.js"></script>
<script src="scripts/es6-shim.js"></script>
<script src="scripts/websdk.client.bundle.min.js"></script>
<script src="scripts/fingerprint.sdk.min.js"></script>

<script>
let sdk = null;
let currentFormat = null;

async function initializeSDK() {  
    try {
        console.log("Initializing SDK...");
        sdk = new Fingerprint.WebApi();
        currentFormat = Fingerprint.SampleFormat.PngImage;
        
        // Enable buttons immediately
        document.getElementById('start').disabled = false;
        document.getElementById('stop').disabled = true;
        
        // Check device
        const devices = await sdk.enumerateDevices();
        console.log("Devices found:", devices);
        
        if (devices && devices.length > 0) {
            showMessage("Device ready - Place finger when ready");
            return true;
        } else {
            showMessage("No devices found!");
            return false;
        }
      } catch (error) {
        console.error("SDK Initialization failed:", error);
        showMessage("Failed to initialize fingerprint reader");
        return false;
    }
}

// Direct button click handlers
async function handleStartCapture() {
    console.log("Start capture clicked");
    try {
        if (!sdk) {
            console.log("Reinitializing SDK...");
            await initializeSDK();
        }
        
        document.getElementById('start').disabled = true;
        document.getElementById('stop').disabled = false;
        
        await sdk.startAcquisition(currentFormat);
        showMessage("Place your finger on the reader");
    } catch (error) {
        console.error("Start capture failed:", error);
        showMessage("Failed to start capture: " + error.message);
        document.getElementById('start').disabled = false;
        document.getElementById('stop').disabled = true;
    }
}

async function handleStopCapture() {
    console.log("Stop capture clicked");
    try {
        await sdk.stopAcquisition();
        document.getElementById('start').disabled = false;
        document.getElementById('stop').disabled = true;
        showMessage("Capture stopped");
     } catch (error) {
        console.error("Stop capture failed:", error);
        showMessage("Failed to stop capture: " + error.message);
      } 
}

// Replace onclick handlers in buttons with direct event listeners
document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM loaded, setting up event listeners");
    
    // Initialize SDK
    initializeSDK();
    
    // Set up button listeners
    const startButton = document.getElementById('start');
    const stopButton = document.getElementById('stop');
    
    if (startButton) {
        startButton.onclick = handleStartCapture;
        console.log("Start button handler attached");
    }
    
    if (stopButton) {
        stopButton.onclick = handleStopCapture;
        console.log("Stop button handler attached");
    }
    
    // Set up SDK event handlers
    if (sdk) {
        sdk.onSamplesAcquired = function(s) {
            console.log("Sample acquired:", s);
            try {
                const samples = JSON.parse(s.samples);
                if (samples.length > 0) {
                    const fingerprintData = Fingerprint.b64UrlTo64(samples[0]);
                    document.getElementById('fingerprintData').value = fingerprintData;
                    
                    const vDiv = document.getElementById('imagediv');
                    vDiv.innerHTML = '<img src="data:image/png;base64,' + fingerprintData + '" />';
                    
                    showMessage("Fingerprint captured successfully");
                    handleStopCapture();
                }
            } catch (error) {
                console.error("Sample processing error:", error);
                showMessage("Error processing fingerprint");
            }
        };
    }
});

function showMessage(message) {
    const status = document.getElementById('status');
    if (status) {
        status.innerHTML = '<div class="alert alert-' + 
            (message.toLowerCase().includes('error') ? 'danger' : 'info') + 
            '">' + message + '</div>';
        console.log("Status message:", message);
    }
}
</script>

<!-- Include app.js last -->
<script src="app.js"></script>

</body>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>