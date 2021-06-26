<?php
    session_start();
    if(!isset($_SESSION['user_id']))
    {
        require_once '../../../auth/login_tools.php';
        load();
    }
    
    require_once '../../../config/connect_site_db.php';
    require_once '../../../auth/login_tools.php';
    $checked = checkPermissions($dbc,$_SESSION['user_id']);
    if($checked != 'admin') load('home.php');
    
    $page_title = 'Delete user account';
    include_once '../../../includes/header.php';
    
    if($_SERVER['REQUEST_METHOD'] == 'GET')
    {
        $user_id = $_SESSION['user_id'];
        $id_to_delete = $_GET['id'];
        $errors = array();
        if($user_id == $id_to_delete)
        {
            array_push($errors, "You cannot delete your own user account.<br>Please <a href='/dashboard/admin/view-users.php'>go back</a> and try again.");
        }
        if($user_id != $id_to_delete)
        {
            $user_to_delete = "DELETE FROM users WHERE user_id = $id_to_delete";
            $res = $dbc->query($user_to_delete);
            if(mysqli_affected_rows($dbc) > 0)
            {
                load('dashboard/admin/view-users.php');
            }
            if(mysqli_affected_rows($dbc) == 0)
            {
                array_push($errors,"Deleting user $id_to_delete didn't work.<br>Please <a href='/dashboard/admin/view-users.php'>go back</a> and try again.");
            }
            $dbc->close();
        }
    }

?>

<div class="row text-center justify-content-center">
    <div class="col-sm-6">
        <?php
            if($errors > 0)
            {
                foreach($errors as $error)
                {
                    echo "<div class='alert alert-danger' role='alert'>";
                    echo $error;
                    echo "</div>";
                }
            }
        ?>
    </div>
</div>

<?php include_once '../../../includes/footer.php'; ?>