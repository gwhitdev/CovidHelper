<?php
    session_start();
    require_once '../../../config/connect_site_db.php';
    require_once '../../../auth/account_class.php';
    include_once '../../actions/account-action.php';
    $errors = array();
    if(!isset($_SESSION['user_id'])) header('Location: /login.php');
    if(isset($_SESSION['user_id']) && $_SESSION['user_type'] != 'admin') header('Location: /home.php');
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
            $user_to_delete = "DELETE FROM users WHERE user_id = :id_to_delete";
            $res = $pdo->prepare($user_to_delete);
            $values = array(':id_to_delete'=>$id_to_delete);
            $res->execute($values);
            if($res->rowCount() > 0)
            {
                header('Location: view-users.php');
            }
            if($res->rowCount() == 0)
            {
                array_push($errors,"Deleting user $id_to_delete didn't work.<br>Please <a href='/dashboard/admin/view-users.php'>go back</a> and try again.");
            }
            die();
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