<?php

    session_start();
    require_once '../../../config/connect_site_db.php';
    require_once '../../../auth/account_class.php';
    include_once '../../actions/account-action.php';
    $errors = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        global $pdo;
        $first_name = $_POST['patient_first_name'];
        $last_name = $_POST['patient_last_name'];
        $dob = $_POST['patient_dob'];

        $search_query = "SELECT * FROM patients WHERE deleted = 0 AND (patient_last_name LIKE :last_name OR patient_first_name LIKE :first_name)";
        $values = array(':last_name' => $last_name, ':first_name' => $first_name);
        $response = $pdo->prepare($search_query);
        $response->execute($values);
        $rows = $response->rowCount();
        
    }

$page_title = 'Admin and Medical Dashboard';
include_once '../../../includes/header.php';
?>
<div class="row text-center">
    <div class="col-sm-12 md-3 lg-3">
        <h1>Medical Dashboard</h1>
    </div>
</div>
<div class="row">
    <!-- Left column -->
    <div class="col-sm-12 col-md-12">
    <div class="row text-center"style="margin-top:25px;margin-bottom:25px">
            <div class="col-sm-12">
                <a class="btn btn-lg btn-primary"href="/dashboard/patients/create-patient.php"><i class="bi bi-person-plus-fill"></i> Add a new patient</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-6">
                <h4>Patient search</h4>
                <form id="patientSearchForm" action="/dashboard/house/index.php"method="POST">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <label for="patient_name">Patient's first name:</label>
                            <input type="text" name="patient_first_name"id="patient_first_name"class="form-control">
                        </div>

                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <label for="patient_name">Patient's last name:</label>
                            <input type="text" name="patient_last_name"id="patient_last_name"class="form-control">
                        </div>
                        
                        
                    </div>
                    <div class="mb-3">
                        <label for="patient_dob" class="form-label">Date of birth:</label>
                        <input type="date"name="patient_dob"class="form-control"id="patient_dob">
                     </div>
                     <button id="searchForPatient" class="btn btn-lg btn-success"><i class="bi bi-search"></i> Search</button>
                </form>
                <button id="clearPatientSearch" style="margin-top:10px"class="btn btn-lg btn-warning"><i class="bi bi-stars"></i> Clear</button>
            </div>
        </div>
        
        
    </div>
    </div>
    <div class="row justify-content-center text-center"style="margin-top:15px">
        <div class="col-sm-12 col-md-6">
        <?php 
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                echo "<strong>Number of patients found: $rows</strong>";
                if($rows > 0)
                {
                    echo '<ul class="list-group list-group-flush">';
                    while($row = $response->fetch(PDO::FETCH_ASSOC))
                    {
                        echo "<li class='list-group-item'>ID: {$row['patient_id']} <a href='/dashboard/patients/patient.php?id={$row['patient_id']}'>{$row['patient_first_name']} {$row['patient_last_name']}</a> (Created: {$row['date_created']})";
                        
                    }
                    echo '</ul>';
                }
            }
            
        ?>
        </div>
    </div>
    <!-- Right column -->
    
    
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