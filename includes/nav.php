<?php 
session_start();
  
  /*
  if(isset($_SESSION['user_id']))
  {
    require_once '../config/connect_site_db.php'; 
  require_once '../auth/login_tools.php'; 
    $checked = checkPermissions($dbc,$_SESSION['user_id']);

  }
  */
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="/">CovidHelper</a>
      
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php if(isset($_SESSION['user_id'])) {
        echo '
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/home.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/dashboard">Your Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/forum/forum.php">Forum</a>
          </li>';
        }
        if($checked == 'admin') 
        {
          echo '
          <li class="nav-item">
            <a class="nav-link" href="/dashboard/admin">Admin</a>
          </li>';
        }?>
          
        
      </ul>
        <?php if(!isset($_SESSION['user_id']))
        {
          
          echo '<a class="nav-link" href="/login.php"><button class="btn btn-sm btn-outline btn-success">Login</button></a>';
        }
        else
        {
          echo "Hello {$_SESSION['first_name']}, you are logged in.";
          echo '<a class="nav-link" href="/goodbye.php"><button class="btn btn-sm btn-outline btn-success">Logout</button></a>';
        }
        ?>
        
      
    </div>
  </div>
</nav>