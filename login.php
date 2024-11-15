<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5" style="background-image: url('assets/witbg.jpg'); background-size: cover; background-position: center; height: 94vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                <?php
                if (isset($_GET['error_msg'])) {
                    $msg = $_GET['error_msg'];
                    echo "<div class='alert alert-danger' role='alert'>$msg</div>";
                }
                ?>

                <div class="card" style="background-color: rgba(255, 255, 255, 0.5); border: none; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <div style="background-color: #F16E04;" class="card-header">
                        <h4 class="text-white">Login</h4>
                    </div>
                    <div class="card-body" style="background-color: rgba(255, 255, 255, 0.3);">
                        <form action="logincode.php" method="POST" onsubmit="return validatePassword()">
                            <div class="form-group mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <input type="checkbox" onclick="togglePassword()"> Show Password
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
                            </div>
                            <div class="form-group mb-3 text-center">
                                <a href="forgot_password.php" class="text-black">Forgot Password?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







<script>
    function togglePassword() {
        let passwordField = document.getElementById("password");
        let confirmPasswordField = document.getElementById("confirm_password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
            confirmPasswordField.type = "text";
        } else {
            passwordField.type = "password";
            confirmPasswordField.type = "password";
        }
    }

    const passwordField = document.getElementById('password');
    const requirements = document.querySelectorAll('.password-requirements');

 
    

    // Add live validation as user types
    passwordField.addEventListener('input', function() {
        var password = this.value;
        var ruleLetter = /[a-zA-Z]/.test(password); // At least 1 letter (capital or small)
        var ruleNumber = /\d/.test(password); // At least 1 number
        var ruleCapital = /[A-Z]/.test(password); // At least 1 capital letter
        var ruleLength = password.length >= 8; // Minimum length of 8 characters
        var ruleUnique = (new Set(password)).size >= 3; // At least 3 unique characters

        // Toggle validation for each rule
        document.getElementById('rule-letter').classList.toggle('valid', ruleLetter);
        document.getElementById('rule-number').classList.toggle('valid', ruleNumber);
        document.getElementById('rule-capital').classList.toggle('valid', ruleCapital);
        document.getElementById('rule-length').classList.toggle('valid', ruleLength);
        document.getElementById('rule-unique').classList.toggle('valid', ruleUnique);

        document.getElementById('rule-letter').classList.toggle('text-success', ruleLetter);
        document.getElementById('rule-letter').classList.toggle('text-danger', !ruleLetter);

        document.getElementById('rule-number').classList.toggle('text-success', ruleNumber);
        document.getElementById('rule-number').classList.toggle('text-danger', !ruleNumber);

        document.getElementById('rule-capital').classList.toggle('text-success', ruleCapital); // Capital letter rule
        document.getElementById('rule-capital').classList.toggle('text-danger', !ruleCapital);

        document.getElementById('rule-length').classList.toggle('text-success', ruleLength);
        document.getElementById('rule-length').classList.toggle('text-danger', !ruleLength);

        document.getElementById('rule-unique').classList.toggle('text-success', ruleUnique);
        document.getElementById('rule-unique').classList.toggle('text-danger', !ruleUnique);
    });
</script>




<?php
include('includes/footer.php');
?>