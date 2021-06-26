<?php

session_start();
include '../includes/header.php';
if(!isset($_SESSION['user_id']))
{
    require_once '../auth/login_tools.php';
    load();
}
?>


<div class="row text-center">
    <div class="col-sm-12 md-3 lg-3">
        <h1>Home</h1>
    </div>
</div>

<div class="row">
    
    
</div>

<?php include_once '../includes/footer.php' ?>
<script>
    const clearPatientSearchButton = document.getElementById('clearPatientSearch');
    const patientSearchForm = document.getElementById('patientSearchForm');
    
    function clearForm(form) {
        console.log('click');
        form.reset();
    }

    clearPatientSearchButton.addEventListener('click',() => clearForm(patientSearchForm));
    
    
</script>