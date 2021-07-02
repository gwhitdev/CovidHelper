<?php 
  if(isset($_SESSION['user_id']))
  {
    $authenticated = TRUE;
    $user_role = $_SESSION['user_type'];
  }
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
      <a class="navbar-brand" href="/">CovidHelper</a>
      
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <?php if($user_role == 'admin' || $user_role == 'medical' || $user_role == 'user') {
        echo '
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/home.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/dashboard">Your Dashboard</a>
          </li>
         ';
        }
        if($user_role == 'admin') 
        {
          echo '
          <li class="nav-item">
            <a class="nav-link" href="/dashboard/admin">Admin</a>
          </li>';
        }?>
          
        
      </ul>
        <?php if(!$authenticated)
        {
          
          echo '<a class="nav-link" href="/login.php"><button class="btn btn-sm btn-outline btn-success"><i class="bi bi-door-open-fill"></i> Login</button></a>';
        }
        else
        {
          echo "Welcome, {$_SESSION['first_name']}";
          echo '<a class="nav-link" href="/goodbye.php"><button class="btn btn-sm btn-outline btn-danger"><i class="bi bi-door-closed-fill"></i> Logout</button></a>';
        }
        ?>
        
      
    </div>
  </div>
</nav>