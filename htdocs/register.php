<?php
    session_start();
    require '../config/connect_users_db.php';
    require '../auth/account_class.php';
    include 'actions/account-action.php';
    $errors = array();
    $page_title ='Register';

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $account = new Account();
        $email = $_POST['email'];
        $password = $_POST['password'];
        try
        {
            $newId = $account->AddAccount($email,$password);
        }
        catch (Exception $e)
        {
            array_push($errors, $e->getMessage());
            die();
        }
    }

    if(!empty($errors))
    {
        echo '<h1>Error!</h1>
        <p id="err_msg">The following error(s) occurred:<br>';
        foreach($errors as $error)
        {
            echo " - $error<br>";
        }
        echo 'Please try again.</p>';
    }
    else
    { ?>
        <h1>Registered!</h1>
        <p>You are now registered</p>
        <p>Please <a href="login.php">login</a></p>
<?php } ?>

<?php 

    
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