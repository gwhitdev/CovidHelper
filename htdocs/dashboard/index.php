<?php 
    session_start();
    require_once '../../config/connect_site_db.php';
    require_once '../../auth/account_class.php';
    include_once '../actions/account-action.php';
    $errors = array();

    if(isset($_SESSION))
    {
        $user_type = $_SESSION['user_type'];
        if($user_type == 'admin' || $user_type == 'medical') header('Location: /dashboard/house/');
    }
    else
    {
        header('Location: /login.php');
    }

    $page_title = 'User Dashboard';
    include_once '../../includes/header.php';
?>

<h1>User Dashboard</h1>
<?php $authenticated ?>
<?php include '../../includes/footer.php'; ?>