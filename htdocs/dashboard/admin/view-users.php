<?php
    session_start();
    if(!isset($_SESSION['user_id']))
    {
        session_start();
        require_once '../../../auth/login_tools.php';
        load();
    }
    if(isset($_SESSION['user_id']))
    {
        require_once '../../../config/connect_site_db.php';
        require_once '../../../auth/login_tools.php';
        $checked = checkPermissions($dbc,$_SESSION['user_id']);
        include_once '../../../includes/header.php';
        
    }

    

    
?>
<div class="row">
    <h4>Users list</h4>
</div>
<div class="row">
    <div>
        <table class="table table-light table-hover">
            <thead class="table-dark">
                <tr>
                   <th scope="col">Id</th> <th scope="col">Name</th><th scope="col">User role</th><th scope="col">Utils</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                if($checked == 'admin')
                {
                    $query = "SELECT * FROM users";
                    $r = $dbc->query($query);
                    $num_of_rows = mysqli_num_rows($r);
                    if($num_of_rows > 0)
                    {
                        while($user = mysqli_fetch_assoc($r))
                        {
                            echo "<tr><td>{$user['user_id']}</td><td>{$user['first_name']} {$user['last_name']} </td><td>{$user['user_type']}</td>";
                            echo "<td><a  href='delete-user.php?id={$user['user_id']}'><i class='bi bi-x-circle-fill text-danger'data-bs-toggle='tooltip' data-bs-placement='left'title='Delete user'></i></a>&nbsp;";
                            echo "<a href='update-user.php?id={$user['user_id']}'><i class='bi bi-arrow-repeat text-secondary' data-bs-toggle='tooltip' data-bs-placement='right'title='Update user'></i></a>";
                            echo "</td></tr>";
                        }
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

