<?php

session_start();
if(!isset($_SERVER['user_id']))
{
    require_once '../auth/login_tools.php';
    $_SESSION = array();
    session_destroy();
}
$page_title = 'Good bye';
include_once '../includes/header.php';

?>


<h1>Good bye!</h1>
<p>You are now logged out</p>


<?php include '../includes/footer.php'?>