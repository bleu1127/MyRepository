<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5" style="background-image: url('assets/witbg.jpg'); background-size: cover; background-position: center; height: 94vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card" style="background-color: rgba(255, 255, 255, 0.5); border: none; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                    <div style="background-color: #F16E04;" class="card-header">
                        <h4 class="text-white">Register</h4>
                    </div>
                    <div class="card-body" style="background-color: rgba(255, 255, 255, 0.3);">
                        <form class="row g-3" action="registercode.php" method="POST" onsubmit="return validateRegistrationForm()">
                            <div class="col-md-6">
                                <label>Name</label>
                                <input required type="text" name="name" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label>Username</label>
                                <input required type="text" name="username" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Email</label>
                                <input required type="email" name="email" class="form-control" placeholder="example@email.com">
                            </div>
                            <div class="col-md-6">
                                <label>Password</label>
                                <input required type="password" name="password" id="password" class="form-control"
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                                    title="Password must contain at least 8 characters, including a number, uppercase letter, lowercase letter, and a special character.">
                            </div>
                            <div class="col-md-6">
                                <label>Confirm Password</label>
                                <input required type="password" name="cpassword" id="confirm_password" class="form-control">
                            </div>
                            <div id="passwordHelpBlock" class="form-text password-requirements">
                                Your password must meet the following requirements:
                            </div>
                            <ul class="list-group password-requirements" id="passwordRules">
                                <li class="list-group-item" id="rule-letter">● At least 1 letter</li>
                                <li class="list-group-item" id="rule-number">● At least 1 number</li>
                                <li class="list-group-item" id="rule-capital">● At least 1 capital letter</li>
                                <li class="list-group-item" id="rule-length">● Minimum of 8 characters</li>
                                <li class="list-group-item" id="rule-unique">● At least 3 unique characters</li>
                            </ul>
                            <div class="form-group mb-3">
                                <input type="checkbox" onclick="togglePassword()"> Show Password
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="register_btn" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
    .password-requirements {
        display: none;
    }

    .password-requirements ul {
        list-style-type: disc;
        /* Add bullets */
        padding-left: 20px;
        /* Indent bullets */
        background-color: transparent;
        /* Ensure the background is transparent */
    }

    .list-group-item {
        color: red;
        border: none;
        /* Remove border */
        padding-left: 0;
        /* Align bullets properly */
        margin-bottom: 2px;
        /* Reduce the space between list items */
        padding: 0 0 2px 0;
        /* Adjust padding to reduce space inside list items */
        font-size: 0.9rem;
        /* Optionally, reduce font size to further compact it */
        background-color: transparent;
        /* Remove any background color */
    }

    .valid .list-group-item {
        color: green;
        background-color: transparent;
        /* Ensure the valid items also have no background color */
    }
</style>


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

    // Show requirements when user starts typing
    passwordField.addEventListener('focus', function() {
        requirements.forEach(function(req) {
            req.style.display = 'block';
        });
    });

    // Hide requirements again if the user clears the input
    passwordField.addEventListener('blur', function() {
        if (this.value === "") {
            requirements.forEach(function(req) {
                req.style.display = 'none';
            });
        }
    });

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