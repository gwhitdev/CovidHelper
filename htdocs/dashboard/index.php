<?php

include '../../includes/header.php';

?>

<?php 
require_once '../../auth/login_tools.php';
require_once '../../config/connect_site_db.php';
session_start();
if(isset($_SESSION['user_id']))
{
    $user_id = $_SESSION['user_id'];
    $authorised = checkPermissions($dbc,$user_id);
    if($authorised == 'Authorised') load('dashboard/admin/index.php');
}
?>

<h1>User Dashboard</h1>
<?php include '../../includes/footer.php'; ?>