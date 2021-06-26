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
    if($checked != 'admin'){
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
    <div class="col-sm-12 col-md-6"style="margin-top:15px">
        <div class="row text-center justify-content-center"style="margin-top:25px;margin-bottom:25px">
            <div class="col-sm-12 col-md-6 d-grid gap-2">
                <a class="btn btn-lg btn-primary"href="/dashboard/admin/news.php"><i class="bi bi-newspaper"></i> Add latest news</a>
                    
            </div>
        </div>
        <div class="row text-center justify-content-center">
            <div class="col-sm-12 col-md-6 d-grid gap-2 d-md-block">
                <a style="margin-top:5px" class="btn btn-lg btn-dark"href="/dashboard/admin/new-user.php"><i class="bi bi-person-plus-fill"></i> Create new user</a>
                <a style="margin-top:5px" class="btn btn-lg btn-dark"href="/dashboard/admin/view-users.php"><i class="bi bi-binoculars-fill"></i> View all users</a>
            </div>
         </div>
        <div class="row">
            <div class="col-sm-12">
                <!-- PLACEHOLDER -->
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <!-- PLACEHOLDER -->
            </div>
        </div>
    </div>
    <!-- Right column -->
    <div class="col text-center"style="margin-top:15px">
        <h3>Activity Feed</h3>
    </div>
</div>

    
</div>

<?php include_once '../../../includes/footer.php' ?>
