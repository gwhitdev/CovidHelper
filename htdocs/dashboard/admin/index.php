<?php

    session_start();
    require_once '../../../config/connect_site_db.php';
    require_once '../../../auth/account_class.php';
    include_once '../../actions/account-action.php';
    $errors = array();
    if(!isset($_SESSION['user_id'])) header('Location: /login.php');
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
                <!--<a class="btn btn-lg btn-primary"href="/dashboard/admin/news.php"><i class="bi bi-newspaper"></i> Add latest news</a>-->
                    
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
        <h3>Recent Activity Feed</h3>
        <div class="row">
            <div class="col-sm-12">
            <?php global $pdo; $q = "SELECT * FROM patient_audit ORDER BY activity_date DESC LIMIT 10"; $res = $pdo->prepare($q);$res->execute();?>
                <ul class="list-group">
                <?php
                    while($row = $res->fetch(PDO::FETCH_ASSOC))
                    {
                        $date = strtotime($row['activity_date']);
                        echo '<li class="list-group-item">'. date("D, d M Y H:m",$date). ' >> ' .$row['activity'] . '</li>';
                    }
                ?>
                </ul>
            </div>
        </div>
    </div>
</div>

    
</div>

<?php include_once '../../../includes/footer.php' ?>
