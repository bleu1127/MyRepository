<!DOCTYPE html>
<html>
<head>
    <title>Fingerprint Verification</title>
    <!-- SDK dependencies must be loaded in correct order -->
    <script src="admin/scripts/es6-shim.js"></script>
    <script src="admin/scripts/websdk.client.bundle.min.js"></script>
    <script src="admin/scripts/fingerprint.sdk.min.js"></script>
    <!-- Your application script should be loaded last -->
    <script src="fingerprintComp.js"></script>
    <style>
        .fp-box {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px;
            width: 300px;
            float: left;
        }
        .fp-image {
            width: 160px;
            height: 200px;
            border: 1px solid #999;
            margin: 10px auto;
        }
        .message-dialog {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            border-radius: 5px;
            display: none;
            max-width: 300px;
            z-index: 1000;
        }
        .error {
            background-color: #ffebee;
            border: 1px solid #ef5350;
            color: #c62828;
        }
        .success {
            background-color: #e8f5e9;
            border: 1px solid #66bb6a;
            color: #2e7d32;
        }
        .preview-container {
            margin-top: 10px;
            text-align: center;
        }
        .preview-image {
            width: 120px;
            height: 160px;
            border: 1px dashed #666;
            margin: 5px auto;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }
        .preview-label {
            font-size: 12px;
            color: #666;
            margin-bottom: 5px;
        }
        .fp-box.active {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }
    </style>
</head>
<body>
    <div id="messageDialog" class="message-dialog"></div>
    <div class="fp-box" id="enrollmentBox">
        <h3>Fingerprint Enrollment</h3>
        <div id="enrollmentImage" class="fp-image"></div>
        <div class="preview-container">
            <div class="preview-label">Preview:</div>
            <div id="enrollmentPreview" class="preview-image"></div>
        </div>
        <button onclick="startEnrollmentCapture()">Start Capture</button>
        <button onclick="stopCapture()">Stop</button>
        <button onclick="submitEnrollment()">Submit</button>
    </div>

    <div class="fp-box" id="verificationBox">
        <h3>Fingerprint Verification</h3>
        <div id="verificationImage" class="fp-image"></div>
        <div class="preview-container">
            <div class="preview-label">Preview:</div>
            <div id="verificationPreview" class="preview-image"></div>
        </div>
        <button onclick="startVerificationCapture()" disabled>Start Capture</button>
        <button onclick="stopCapture()">Stop</button>
        <button onclick="verifyFingerprint()" disabled>Verify</button>
    </div>
</body>
</html>
