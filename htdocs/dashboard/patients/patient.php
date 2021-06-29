<?php
    session_start();
    require_once '../../../config/connect_site_db.php';  
    require_once '../../../audit/audit-tasks.php';
    require_once '../../../validators/patient-validator.php';
    if(isset($_SESSION['user_id']))
    {
        require_once '../../../auth/login_tools.php';
        $checked = checkPermissions($dbc,$_SESSION['user_id']);
        if($checked != 'admin')
        {
            load('home.php');
        }
    
        if($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $patient_id = $_GET['id'];
            function getPatientDetails($dbc,$patient_id)
            {

                $q = "SELECT * FROM patients WHERE patient_id = $patient_id";
                $get_user = $dbc->query($q);
                if($get_user)
                {
                    $patient = mysqli_fetch_assoc($get_user);
                    $dbc->close();
                    return array($patient['patient_first_name'], $patient['patient_last_name'], $patient['patient_dob'],$patient['patient_email'],
                                    $patient['patient_notes'],$patient['date_created'],$patient['vaccination_one'],$patient['vaccination_two']);
                }
                else
                {
                    $dbc->close();
                    return 'No patient';
                }
            }

            list ($patient_first_name,$patient_last_name,$patient_dob,$patient_email,$patient_notes,$date_created,$vaccination_one,$vaccination_two) = getPatientDetails($dbc,$patient_id);
        }

    }
    
    
    $page_title = 'Patient Detail';
    include_once '../../../includes/header.php';
?>

<div class="row justify-content center" style="margin-top:25px">
    <div class="col-sm-12">
        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Delete</button>
        <a class="btn btn-sm btn-primary" href="update-patient.php?id=<?php echo $patient_id ?>">Update</a>
    </div>
    
</div>
<div class="row justify-content-center"style="margin-top:25px">
    <div class="col-sm-12 col-md-6">
        <div class="card" >
            <div class="card-body">
                <h5 class="card-title"><?php echo "$patient_first_name $patient_last_name";?></h5>
                <p class="card-text">
                    <p>Date of birth: <?php echo $patient_dob; ?></p>
                    <p>Email address: <?php echo $patient_email ?></p>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="card" >
            <div class="card-body">
                <p class="card-text">
                <p>Notes:<br>
                    <?php echo $patient_notes ?></p>
                    <p>First vaccination date:<br>
                    <?php if($vaccination_one) echo $vaccination_one; else { 'Not received yet';} ?>
                    </p>
                    <p>Second vaccination date:<br>
                    <?php if($vaccination_two) echo $vaccination_two; else { 'Not received yet';} ?>
                    </p>
                </p>
            </div>
        </div>
    </div>
    
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Delete patient record</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this record?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="/dashboard/patients/delete-record.php?id=<?php echo $patient_id?>" type="button" class="btn btn-danger">Delete record</a>
      </div>
    </div>
  </div>
</div>
<?php

include_once '../../../includes/footer.php';
?>