<?php 
include '../includes/header.php';
$page_title = 'Login';

?>
<div class="row text-center">
    <div class="col-sm-12 md-3 lg-3">
        <h1>Login</h1>
    </div>
</div>
<?php

if(isset($errors) && !empty($errors))
{
    echo '<div class="row justify-content-center text-center"><div class="col-sm-12 col-md-6 col-lg-6">';
    echo '<p id="err_msg"><h3>Oops! There was a problem</h3><br>';
    foreach($errors as $msg)
    {
        echo '<p class="alert alert-danger" role="alert">';
        echo "$msg<br> ";
        echo '</p>';
    }
    echo 'Please try again or <a href="register.php">register</a></p>';
    echo '</div></div>';
}

?>


<div class="row justify-content-center">
    <div class="col-sm-12 col-md-6 col-lg-6 ">
        <form action="../actions/login_action.php"method="POST">
        <div class="mb-3">
            <label for="emailAddress"class="form-label">Email address:</label>
            <input type="text" name="email"id="emailAddress"class="form-control">
            <div id="emailHelp" class="form-text">Your email address will not be shared</div>
        </div>
        <div class="mb-3">
            <label for="passwordInput" class="form-label">Password:</label>
            <input type="password"name="pass"class="form-control"id="passwordInput">
            <div id="emailHelp" class="form-text">Use at least 8 characters, using capital letters, numbers and punctuation.</div>
        </div>

        <button class="btn btn-lg btn-primary">Login</button>
        </form>
    </div>
</div>



<?php include '../includes/footer.php'; ?>