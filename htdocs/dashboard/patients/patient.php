<?php
    session_start();
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $patient_id = $_GET['id'];
    }
    $page_title = 'Patient Detail';
    include_once '../../../includes/header.php';
?>

<div class="row">
    <div class="col-sm-12">
        <h2><?php echo $patient_id ?></h2>
    </div>
</div>


<?php

include_once '../../../includes/footer.php';
?>