<?php

session_start();
if(!isset($_SESSION['user_id']))
{
    require_once '../auth/login_tools.php';
    load();
}
if(isset($_SESSION['user_id']))
{
    require_once '../config/connect_site_db.php';
    require_once '../auth/login_tools.php';
    $checked = checkPermissions($dbc,$_SESSION['user_id']);
}
$page_title = 'Home';
include_once '../includes/header.php';
?>


<div class="row text-center">
    <div class="col-sm-12 md-3 lg-3">
        <h1>Home</h1>
    </div>
</div>

<div class="row">
    
    <?php print_r($checked);?>
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