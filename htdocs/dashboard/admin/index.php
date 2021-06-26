<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    require_once '../../../auth/login_tools.php';
    load();

}
if(isset($_SESSION))
{
    require_once '../../../auth/login_tools.php';
    require_once '../../../config/connect_site_db.php';
    $user_id = $_SESSION['user_id'];
    $checked = checkPermissions($dbc,$user_id);
    if($checked == 'Not authorised') load('home.php');
}

$page_title = 'Admin and Medical Dashboard';
include_once '../../../includes/header.php';
?>
<div class="row text-center">
    <div class="col-sm-12 md-3 lg-3">
        <h1>Admin and Medical Dashboard</h1>
    </div>
</div>

<div class="row">
    <!-- Left column -->
    <div class="col-sm-12 col-md-6">
    <div class="row"style="margin-top:25px;margin-bottom:25px">
            <div class="col-sm-12">
                <a class="btn btn-lg btn-primary"href="/dashboard/patients/">Add a new patient</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h4>Patient search</h4>
                <form id="patientSearchForm" action="index.php"method="POST">
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
                     <button id="searchForPatient" class="btn btn-lg btn-success">Search</button>
                </form>
                <button id="clearPatientSearch" style="margin-top:10px"class="btn btn-lg btn-warning">Clear</button>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                

            </div>
        </div>
    </div>
    <!-- Right column -->
    <div class="col">
    <?php 
require_once '../../../config/connect_site_db.php';

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $first_name = $_POST['patient_first_name'];
    $last_name = $_POST['patient_last_name'];
    $dob = $_POST['patient_dob'];

    $search_query = "SELECT * FROM patients WHERE patient_last_name LIKE '%$last_name%' OR patient_first_name LIKE '%$first_name%'";
    $response = $dbc->query($search_query);
    $rows = mysqli_num_rows($response);
    echo "Number of patients found: $rows";
    if($rows > 0)
    {
        echo '<ul class="list-group list-group-flush">';
        while($row = mysqli_fetch_assoc($response))
        {
            echo '<li class="list-group-item">' .$row['patient_first_name'] . '<a style="margin-left:5px" class="btn btn-sm btn-outline-dark" href="/patients/update.php?id='.$row['patient_id'].'">Update</a>';
            
        }
        echo '</ul>';
    }
}

?>
    </div>
</div>

    
</div>

<?php include_once '../../../includes/footer.php' ?>
<script>
    const clearPatientSearchButton = document.getElementById('clearPatientSearch');
    const patientSearchForm = document.getElementById('patientSearchForm');
    
    function clearForm(form) {
        console.log('click');
        form.reset();
    }

    clearPatientSearchButton.addEventListener('click',() => clearForm(patientSearchForm));
    
    
</script>