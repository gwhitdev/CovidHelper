<?php
    session_start();
    require_once '../../../config/connect_site_db.php';
    require_once '../../../auth/account_class.php';
    include_once '../../actions/account-action.php';
    $errors = array();
    if(!isset($_SESSION['user_id'])) header('Location: /login.php');
    if(isset($_SESSION['user_id']) && $_SESSION['user_type'] != 'admin') header('Location: /home.php');
    $page_title = 'View Users';
    include_once '../../../includes/header.php';
?>
<div class="row">
    <div class="col-sm-12 col-md-6">
        <h4>Users list</h4> 
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
    <a class="btn btn-sm btn-dark"href="/dashboard/admin/new-user.php"><i class="bi bi-person-plus-fill"></i> Create new user</a>
    </div>
</div>
<div class="row"style="margin-top:15px">
    <div>
        <table class="table table-light table-hover">
            <thead class="table-dark">
                <tr>
                   <th scope="col">Id</th> <th scope="col">Name</th><th scope="col">User role</th><th scope="col">Utils</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            
                    $query = "SELECT * FROM users";
                    $r = $pdo->prepare($query);
                    $r->execute();
                    $num_of_rows = $r->rowCount();
                    if($num_of_rows > 0)
                    {
                        while($user = $r->fetch(PDO::FETCH_ASSOC))
                        {
                            echo "<tr><td>{$user['user_id']}</td><td>{$user['first_name']} {$user['last_name']} </td><td>{$user['user_type']}</td>";
                            echo "<td><a  href='delete-user.php?id={$user['user_id']}'><i class='bi bi-x-circle-fill text-danger'data-bs-toggle='tooltip' data-bs-placement='left'title='Delete user'></i></a>&nbsp;";
                            echo "<a href='update-user.php?id={$user['user_id']}'><i class='bi bi-arrow-repeat text-secondary' data-bs-toggle='tooltip' data-bs-placement='right'title='Update user'></i></a>";
                            echo "</td></tr>";
                        }
                    }
            ?>
            </tbody>
            <tfoot class="table-dark">
                <td><strong>Id</strong></td>
                <td><strong>Name</strong></td>
                <td><strong>User role</strong></td>
                <td><strong>Utils</strong></td>
            </tfoot>
        </table>
    </div>
</div>

<?php include_once '../../../includes/footer.php'; ?>
<script>

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})


</script>

