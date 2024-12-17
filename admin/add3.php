<?php
session_start();
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
                        <a href="add2.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form class="row g-3" action="add4.php" method="POST">
                        <?php
                        // Carry forward data from previous forms
                        foreach($_POST as $key => $value) {
                            if(is_array($value)) {
                                foreach($value as $item) {
                                    echo '<input type="hidden" name="'.$key.'[]" value="'.htmlspecialchars($item).'">';
                                }
                            } else {
                                echo '<input type="hidden" name="'.$key.'" value="'.htmlspecialchars($value).'">';
                            }
                        }
                        ?>
                        <h4>Reference</h4>

                        <center>
                            <h4>Outside WIT</h4>
                        </center>

                        <!-- First Outside WIT Reference -->
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input name="out_name1" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Company/Address</label>
                                <input name="comp_add1" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No.</label>
                                <input name="cn1" class="form-control">
                            </div>
                        </div>

                        <!-- Second Outside WIT Reference -->
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input name="out_name2" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Company/Address</label>
                                <input name="comp_add2" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No.</label>
                                <input name="cn2" class="form-control">
                            </div>
                        </div>

                        <!-- Third Outside WIT Reference -->
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input name="out_name3" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Company/Address</label>
                                <input name="comp_add3" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No.</label>
                                <input name="cn3" class="form-control">
                            </div>
                        </div>

                        <hr class="divider" />

                        <center>
                            <h4>From WIT</h4>
                        </center>

                        <!-- First From WIT Reference -->
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input name="from_wit1" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Company/Address</label>
                                <input name="comp_add4" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No.</label>
                                <input name="cn4" class="form-control">
                            </div>
                        </div>

                        <!-- Second From WIT Reference -->
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input name="from_wit2" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Company/Address</label>
                                <input name="comp_add5" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No.</label>
                                <input name="cn5" class="form-control">
                            </div>
                        </div>

                        <!-- Third From WIT Reference -->
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Name</label>
                                <input name="from_wit3" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Company/Address</label>
                                <input name="comp_add6" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact No.</label>
                                <input name="cn6" class="form-control">
                            </div>
                        </div>

                        <hr class="divider" />

                        <center>
                            <h4>Family Information</h4>
                        </center>

                        <div class="col-md-4">
                            <label class="form-label">Father's Name</label>
                            <input name="fathers_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Occupation</label>
                            <input name="fathers_occ" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Approx. Income/Mon</label>
                            <input type="number" name="fathers_income" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mother's Name</label>
                            <input name="mothers_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Occupation</label>
                            <input name="mothers_occ" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Approx. Income/Mon</label>
                            <input type="number" name="mothers_income" class="form-control">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Other Source of Income</label>
                            <input  name="source_in" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Approx. Income/Mon</label>
                            <input  name="other_in" class="form-control">
                        </div>

                        <h5>Brothers & Sisters</h5>
                        <div id="siblings-container">
                            <!-- Template row for siblings -->
                            <div class="siblings-row row mb-3">
                                <div class="col-md-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="sibling_name[]" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Age</label>
                                    <input type="text" name="sibling_age[]" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Course/Yr./Grad./Sch</label>
                                    <input type="text" name="sibling_level[]" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Work/Studying/No Work</label>
                                    <input type="text" name="sibling_status[]" class="form-control">
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-sibling">✕</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mt-2" onclick="addSiblingRow()">Add Sibling</button>

                        <script>
                        function addSiblingRow() {
                            const container = document.getElementById('siblings-container');
                            const template = container.querySelector('.siblings-row').cloneNode(true);
                            
                            // Clear input values
                            template.querySelectorAll('input').forEach(input => {
                                input.value = '';
                            });
                            
                            // Update remove button
                            template.querySelector('.remove-sibling').onclick = function() {
                                if(container.children.length > 1) {
                                    this.closest('.siblings-row').remove();
                                }
                            };
                            
                            container.appendChild(template);
                        }

                        // Add click handler to existing remove buttons
                        document.querySelectorAll('.remove-sibling').forEach(button => {
                            button.onclick = function() {
                                const container = document.getElementById('siblings-container');
                                if(container.children.length > 1) {
                                    this.closest('.siblings-row').remove();
                                }
                            };
                        });
                        </script>

                        <?php
                        // Assuming the form data is submitted using POST
                        if (isset($_POST['last_name']) && isset($_POST['first_name']) && isset($_POST['id'])) {
                            $id = htmlspecialchars(trim($_POST['id'])); // Sanitize ID
                            $last_name = htmlspecialchars(trim($_POST['last_name']));
                            $first_name = htmlspecialchars(trim($_POST['first_name']));
                        } else {
                            // Default values if form data is not submitted
                            $id = null;
                            $last_name = 'Unknown';
                            $first_name = 'User';
                        }
                        ?>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary">Next</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add this JavaScript before closing body tag -->
<script>
let counters = {
    'outside-wit': 1,
    'from-wit': 1,
    'siblings': 1
};

function addRow(type) {
    counters[type]++;
    const container = document.getElementById(`${type}-container`);
    const newRow = container.firstElementChild.cloneNode(true);
    
    // Update input names with new counter
    const inputs = newRow.getElementsByTagName('input');
    for(let input of inputs) {
        let nameParts = input.name.match(/^([a-zA-Z_]+)(\d*)$/);
        if(nameParts) {
            input.name = nameParts[1] + counters[type];
            input.value = ''; // Clear values
        }
    }
    
    // Add remove button
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn-danger btn-sm mt-2';
    removeBtn.innerHTML = 'Remove';
    removeBtn.onclick = function() {
        this.parentElement.remove();
    };
    newRow.appendChild(removeBtn);
    
    container.appendChild(newRow);
}

function addSiblingRow() {
    const container = document.getElementById('siblings-container');
    const newRow = container.firstElementChild.cloneNode(true);
    
    // Clear input values
    const inputs = newRow.getElementsByTagName('input');
    for(let input of inputs) {
        input.value = '';
    }
    
    // Add remove button
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'btn btn-danger btn-sm mt-2';
    removeBtn.innerHTML = 'Remove';
    removeBtn.onclick = function() {
        this.parentElement.remove();
    };
    newRow.appendChild(removeBtn);
    
    container.appendChild(newRow);
}
</script>

<?php
include('includes/footer.php');
include('includes/scripts.php');
?>