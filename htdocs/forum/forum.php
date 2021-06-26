<?php

session_start();

if(!isset($_SESSION['user_id']))
{
    require_once '../../auth/login_tools.php';
    load();
}

require_once '../../auth/login_tools.php';
require_once '../../config/connect_site_db.php';

$checked = checkPermissions($dbc,$_SESSION['user_id']);
$page_title = 'Forum';
include_once '../../includes/header.php';

$q = "SELECT * FROM forum";
$r = mysqli_query($dbc,$q);
if(mysqli_num_rows($r) > 0)
{
    echo '<table><tr><th>Posted By</th>
    <th>Subject</th><th>Message</th>';
    while($row = mysqli_fetch_assoc($r))
    {
        echo '<tr>
        <td>'.$row['first_name'].' '.$row['last_name'].'<br>'.$row['post_date'].'</td>
        <td>'.$row['subject'].'</td><td>'.$row['message'].'</td></tr>';
    }
    echo '</table>';
}
else
{
    echo '<p>There are currently no messages.';
}

?>
<div class="row">
<a href="post.php">Post message</a> 
</div>

<?php $dbc->close(); ?>
<?php include '../../includes/footer.php' ?>