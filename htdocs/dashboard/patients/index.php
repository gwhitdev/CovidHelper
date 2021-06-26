<?php

session_start();
include_once '../../../includes/header.php';
if(!isset($_SESSION['user_id']))
{
    require_once '../../../auth/login_tools.php';
    load();
}
?>


<div class="row">
    <!-- Left column -->
    <div class="col">
        <div class="row">
            <div class="col-sm-12">
                <h4>Add a patient</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <form>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label for="patient_name">Patient's first name:</label>
                            <input type="text" name="patient_first_name"id="patient_first_name"class="form-control">
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <label for="patient_name">Patient's last name:</label>
                            <input type="text" name="patient_last_name"id="patient_last_name"class="form-control">
                        </div>
                        
                        
                    </div>
                    <div class="mb-3">
                        <label for="patient_dob" class="form-label">Date of birth:</label>
                        <input type="date"name="patient_dob"class="form-control"id="patient_dob">
                     </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Right column -->
    <div class="col">

    </div>

    <?php include_once '../../../includes/footer.php'; ?>