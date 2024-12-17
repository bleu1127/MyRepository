var sdk = new Fingerprint.WebApi();
var currentFormat = Fingerprint.SampleFormat.Iso19794;
var isCapturing = false;
var MATCHING_THRESHOLD = 0.70;
var state = document.getElementById('content-capture');
var test = null;
var myVal = ""; 
var disabled = true;
var startEnroll = false;

var deviceTechn = {
    0: "Unknown",
    1: "Optical",
    2: "Capacitive",
    3: "Thermal",
    4: "Pressure"
}

var deviceModality = {
    0: "Unknown",
    1: "Swipe",
    2: "Area",
    3: "AreaMultifinger"
}

var deviceUidType = {
    0: "Persistent",
    1: "Volatile"
}

// Single showMessage implementation
function showMessage(message) {
    if (!message || message === "undefined") return;
    
    const status = document.getElementById('status') || state.querySelector("#status");
    if (status) {
        status.innerHTML = '<div class="alert alert-' + 
            (message.toLowerCase().includes('error') ? 'danger' : 'info') + 
            '">' + message + '</div>';
        
        // Auto-clear message after 5 seconds
        setTimeout(() => status.innerHTML = "", 5000);
    }
    console.log('Status:', message);
}

// Show notification in profile card
function showNotification(message, type = 'info') {
  const notificationDiv = document.createElement('div');
  notificationDiv.classList.add('notification', type);
  notificationDiv.innerHTML = `
    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  `;

  const profileImg = document.querySelector('.profile-img');
  if(profileImg) {
    profileImg.parentNode.insertBefore(notificationDiv, profileImg);
  }

  // Auto dismiss after 5 seconds
  setTimeout(() => {
    notificationDiv.remove();
  }, 5000);
}

// Single implementation of fingerprint capture start
function startFingerprintCapture(callback) {
    if (isCapturing) {
        showMessage('Capture already in progress');
        return;
    }
    
    sdk.startAcquisition(currentFormat).then(() => {
        isCapturing = true;
        showMessage('Place finger on reader');
        if (callback) callback(null);
    }).catch(error => {
        showMessage('Failed to start capture: ' + error.message);
        if (callback) callback(error);
    });
}

// Single implementation of fingerprint capture stop
function stopFingerprintCapture() {
    if (!isCapturing) return;
    
    sdk.stopAcquisition().then(() => {
        isCapturing = false;
        showMessage('Capture stopped');
    }).catch(error => {
        showMessage('Failed to stop capture: ' + error.message);
    });
}

// Main fingerprint processing logic
sdk.onSamplesAcquired = async function(capture) {
    if (!isCapturing) return;

    try {
        const samples = JSON.parse(capture.samples);
        if (samples.length > 0) {
            const fingerprintData = samples[0]; // ISO19794 format

            console.log('Fingerprint data captured');

            // Verify fingerprint and get SA ID if matched
            const saId = await verifyFingerprint(fingerprintData);

            if (saId) {
                // Submit attendance if fingerprint matched
                await submitAttendance(saId);
            } else {
                console.log('No SA ID returned from verifyFingerprint');
            }
        }
    } catch (error) {
        console.error('Error processing fingerprint:', error);
        showNotification('Error processing fingerprint', 'error');
    } finally {
        isCapturing = false;
        sdk.stopAcquisition().catch(console.error);
    }
};

// Helper functions
async function verifyFingerprint(fingerprintData) {
    try {
        const cleanFingerprint = fingerprintData.trim();

        // Debug log: fingerprint data being sent
        console.log('Sending fingerprint data for verification, length:', cleanFingerprint.length);

        const response = await fetch('tito_log.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'verify_fingerprint',
                fingerprint: cleanFingerprint
            })
        });

        const result = await response.json();
        console.log('Verification result:', result);

        if (result.matched && result.sa_id) {
            const saId = parseInt(result.sa_id, 10);
            console.log('Matched SA ID:', saId);

            if (isNaN(saId) || saId <= 0) {
                showNotification('Invalid SA ID received', 'error');
                return null;
            }
            showNotification(`Fingerprint matched: ${result.sa_name}`, 'success');
            return saId;
        } else {
            showNotification('No matching fingerprint found', 'error');
            return null;
        }

    } catch (error) {
        console.error('Verification error:', error);
        showNotification('Error verifying fingerprint', 'error');
        return null;
    }
}

async function submitAttendance(saId) {
    try {
        if (!saId || saId <= 0) {
            showNotification('Invalid SA ID', 'error');
            return;
        }

        // Debug log: SA ID being sent for attendance recording
        console.log('Submitting attendance for SA ID:', saId);

        const response = await fetch('tito_log.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                sa_id: saId,
                action: 'record_attendance'
            })
        });

        const result = await response.json();
        console.log('Attendance submission result:', result);

        if (result.success) {
            showNotification(result.message, 'success');
        } else {
            showNotification(result.message || 'Error recording attendance', 'error');
        }

    } catch (error) {
        console.error('Error submitting attendance:', error);
        showNotification('Error recording attendance', 'error');
    }
}

function compareFingerprints(template1, template2) {
    return template1 === template2;
}

function updateFingerprintDisplay(fingerprintData) {
    const canvas = document.getElementById('fingerprint-canvas');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        const img = new Image();
        img.onload = function() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
        };
        img.src = 'data:image/png;base64,' + fingerprintData;
    }
}

// Fingerprint SDK Test Class
var FingerprintSdkTest = (function () {
    function FingerprintSdkTest() {
        var _instance = this;
        this.operationToRestart = null;
        this.acquisitionStarted = false;
        this.sdk = new Fingerprint.WebApi();
        this.lastConnectionState = false;

        // Add connection recovery handler
        this.sdk.onCommunicationFailed = function (e) {
            if (_instance.lastConnectionState) {
                setTimeout(function() {
                    _instance.sdk.startAcquisition(currentFormat, myVal).then(function() {
                        _instance.lastConnectionState = true;
                        showMessage("Connection recovered");
                    }).catch(function(err) {
                        showMessage("Communication failed: " + err.message);
                    });
                }, 1000);
            }
        };

        this.sdk.onDeviceConnected = function (e) {
            _instance.lastConnectionState = true;
            showMessage("Device connected: " + e.deviceInfo.DeviceID);
        };

        this.sdk.onDeviceDisconnected = function (e) {
            _instance.lastConnectionState = false;
            showMessage("Device disconnected: " + e.deviceInfo.DeviceID);
        };

        this.sdk.onSamplesAcquired = function (s) {
            sampleAcquired(s);
        };
        this.sdk.onQualityReported = function (e) {
            document.getElementById("qualityInputBox").value = Fingerprint.QualityCode[(e.quality)];
        };
    }

    FingerprintSdkTest.prototype.startCapture = function () {
        if (this.acquisitionStarted) {
            return;
        }

        var _instance = this;
        this.operationToRestart = this.startCapture;
        this.acquisitionStarted = true;

        this.sdk.startAcquisition(currentFormat, myVal).then(function () {
            _instance.lastConnectionState = true;
            showMessage("Place your finger on the reader.");
        }, function (error) {
            _instance.acquisitionStarted = false;
            _instance.lastConnectionState = false;
            showMessage("Failed to start capture: " + error.message);
        });
    };

    FingerprintSdkTest.prototype.stopCapture = function () {
        if (!this.acquisitionStarted) return;
        var _instance = this;
        showMessage("");
        this.sdk.stopAcquisition().then(function () {
            _instance.acquisitionStarted = false;
            disableEnableStartStop();
        }, function (error) {
            showMessage(error.message);
        });
    };

    FingerprintSdkTest.prototype.getInfo = function () {
        return this.sdk.enumerateDevices();
    };

    FingerprintSdkTest.prototype.getDeviceInfoWithID = function (uid) {
        return this.sdk.getDeviceInfo(uid);
    };

    return FingerprintSdkTest;
})();

// Initialize when page loads
document.addEventListener('DOMContentLoaded', () => {
    test = new FingerprintSdkTest();
    
    sdk.enumerateDevices()
        .then(devices => {
            if (devices.length === 0) {
                showMessage("No fingerprint devices found");
            } else {
                showMessage("Fingerprint device ready");
                // Auto-select first device if available
                if (devices[0]) startFingerprintCapture();
            }
        })
        .catch(error => {
            showMessage("Error initializing SDK: " + error.message);
        });

    // Initialize reader selection with slight delay to ensure device is ready
    setTimeout(function() {
        readersDropDownPopulate(true);
        
        // Auto-select first reader if available
        setTimeout(function() {
            var reader = document.getElementById('readersDropDown');
            if (reader && reader.options.length > 1) {
                reader.selectedIndex = 1;
                selectChangeEvent();
                
                // Force switch to capture tab after reader is selected
                toggle_visibility(['content-capture','content-reader']);
                setActive('Capture','Reader');
            }
        }, 500);
    }, 1000);
});

// Window onload initialization
window.onload = function () {
    localStorage.clear();
    test = new FingerprintSdkTest();
    
    // Force PNG format selection at startup
    currentFormat = Fingerprint.SampleFormat.PngImage;
    
    // Initialize reader and UI
    readersDropDownPopulate(true);
    disableEnable();
    enableDisableScanQualityDiv("content-reader");
    disableEnableExport(true);

    // Auto-check PNG format
    if(document.querySelector('input[name="PngImage"]')) {
        document.querySelector('input[name="PngImage"]').checked = true;
    }
};

// Function to handle sample acquisition
function sampleAcquired(s){   
    try {
        console.log("Sample acquired:", s);
        if(currentFormat == Fingerprint.SampleFormat.PngImage){   
            localStorage.setItem("imageSrc", "");                
            var samples = JSON.parse(s.samples);            
            localStorage.setItem("imageSrc", "data:image/png;base64," + Fingerprint.b64UrlTo64(samples[0]));
            
            var vDiv = document.getElementById('imagediv');
            vDiv.innerHTML = "";
            var image = new Image();
            image.id = "image";
            image.src = localStorage.getItem("imageSrc");
            image.onload = function() {
                var canvas = document.getElementById('fingerprint-canvas');
                var ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                // Draw the image scaled to canvas dimensions
                ctx.drawImage(image, 0, 0, canvas.width, canvas.height);
            };
            vDiv.appendChild(image);
            
            showMessage("Fingerprint captured successfully");
            
            // Additional debugging log
            console.log("Fingerprint image stored.");
            disableEnableExport(false);
        }
    } catch(err) {
        showMessage("Error capturing fingerprint: " + err.message);
        console.error("Error in sampleAcquired:", err);
    }
}
