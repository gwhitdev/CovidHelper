<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    require_once '../../../auth/login_tools.php';
    load();

}
if(isset($_SESSION['user_id']))
{
    require_once '../../../auth/login_tools.php';
    require_once '../../../config/connect_site_db.php';
    $user_id = $_SESSION['user_id'];
    $checked = checkPermissions($dbc,$user_id);
    if($checked == 'Not authorised'){
        load('home.php');
    }
    
}

$page_title = 'Admin and Medical Dashboard';
include_once '../../../includes/header.php';
?>
<div class="row text-center">
    <div class="col-sm-12 md-3 lg-3">
        <h1>Admin Dashboard</h1>
    </div>
</div>

<div class="row">
    <!-- Left column -->
    <div class="col-sm-12 col-md-6">
        <div class="row"style="margin-top:25px;margin-bottom:25px">
            <div class="col-sm-12">
                <a class="btn btn-lg btn-primary"href="/dashboard/admin/news.php">Add latest news</a>
                    
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-lg btn-primary"href="/dashboard/admin/new-user.php">Create new user</a>
                <a class="btn btn-lg btn-primary"href="/dashboard/admin/view-users.php">View all users</a>
            </div>
         </div>
        <div class="row">
            <div class="col-sm-12">
                FORM
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                

            </div>
        </div>
    </div>
    <!-- Right column -->
    <div class="col">
    List of latest news articles published and admin functions
    </div>
</div>

    
</div>

<?php include_once '../../../includes/footer.php' ?>
