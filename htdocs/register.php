<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    require '../config/connect_users_db.php';
    $errors = array();
    if(empty($_POST['first_name']))
    {
        array_push($errors,'Enter your first name');
    }
    else
    {
        $fn = mysqli_real_escape_string($dbc,trim($_POST['first_name']));
    }

    if(empty($_POST['last_name']))
    {
        array_push($errors,'Enter your last name');
    }
    else 
    {
        $ln = mysqli_real_escape_string($dbc,trim($_POST['last_name']));
    }
    if(empty($_POST['email']))
    {
        array_push($errors,'Enter your email address');
    }
    else
    {
        $e = mysqli_real_escape_string($dbc,trim($_POST['email']));
    }

    if(!empty($_POST['pass1']))
    {
        if($_POST['pass1'] != $_POST['pass2'])
        {
            array_push($errors,'Passwords do not match');
        }
        else
        {
            $p = mysqli_real_escape_string($dbc,$_POST['pass1']);
            $hash = password_hash($p, PASSWORD_DEFAULT);
            $verify = password_verify($p,$hash);
        }
    }
    else
    {
        array_push($errors,'Enter your password.');
    }

    if(empty($errors))
    {
        $q = "SELECT user_id FROM users WHERE email='$e'";
        $r = mysqli_query($dbc,$q);
        if(mysqli_num_rows($r) != 0)
        {
            array_push($errors,'Email address already registered. <a href="login.php">Please login</a>.');
        }
    }
    if(empty($errors))
    {
        $q = "INSERT INTO users (first_name,last_name,email,pass,reg_date) VALUES ('$fn','$ln','$e','$hash',NOW())";
        $r = mysqli_query($dbc,$q);

        if($r)
        {
            echo '<h1>Registered!</h1>
            <p>You are now registered</p>
            <p><a href="login.php">Login</a></p>';
        }
        mysqli_close($dbc);
        exit();
    }
    else
{
    echo '<h1>Error!</h1>
    <p id="err_msg">The following error(s) occurred:<br>';
    foreach($errors as $error)
    {
        echo " - $error<br>";
    }
    echo 'Please try again.</p>';
    mysqli_close($dbc);
}
}

$page_title = 'Register';
include '../includes/header.php';

?>

<h1>Register</h1>

<form action="register.php" method="POST">
    <p>
        First name: <input type="text" name="first_name" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']; ?>"><br>
        Last name: <input type="text" name="last_name" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name'];?>"><br>
    </p>
    <p>
        Email address: <input type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>">
    </p>
    <p>
        Password: <input type="password" name="pass1" value="<?php if(isset($_POST['pass1'])) echo $_POST['pass1'];?>">
        Confirm password: <input type="password" name="pass2" value="<?php if(isset($_POST['pass2'])) echo $_POST['pass2'];?>">
    </p>
    <button>Register</button>
</form>

<?php include '../includes/footer.php'; ?>