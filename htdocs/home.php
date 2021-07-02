<?php
    session_start();
    require_once '../config/connect_site_db.php';
    require_once '../auth/account_class.php';
    include_once 'actions/account-action.php';
    $errors = array();
    $page_title = 'Home';
    include_once '../includes/header.php';
?>


<div class="row text-center">
    <div class="col-sm-12 md-3 lg-3">
        <h1>Home</h1>
        <?php print_r($_SESSION) ?>
    </div>
</div>

<?php include_once '../includes/footer.php' ?>
