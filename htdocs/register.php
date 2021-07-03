<?php
    session_start();
    require_once '../config/connect_site_db.php';
    require_once '../auth/account_class.php';
    include_once 'actions/account-action.php';
    $errors = array();
    $page_title ='Register';

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $account = new Account();
        $email = $_POST['email'];
        $password1 = $_POST['pass1'];
        $password2 = $_POST['pass2'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $role = $_POST['user_type'];
        try 
        {
            list($validation_errors, $newId) = $account->AddAccount($email,$password1,$password2,$first_name,$last_name,$role);
            if(!empty($validation_errors))
            {
                foreach($validation_errors as $err)
                {
                    array_push($errors, $err);
                }
            }
        }
        catch (Exception $e)
        {
            $dberrors = array();
            array_push($dberrors, $e->getMessage());
            foreach($dberrors as $error)
            {
                echo 'db error: ', $error;
            }
            die();
        }
    }

    if($newId != NULL)
    {
        include_once '../includes/header.php';
        echo '<p><h2>Success!</h2></p>';
        echo "<p>You are now a registered user. Please <a href='/login.php'>login</a>.</p>";
        include_once '../includes/footer.php';
    }
    else
    {
        $page_title = 'Register';
        include_once '../includes/header.php';
    ?>

    <div class="row">
        <h1>Register as a new user</h1>
    </div>

    <div class="row">
    <?php if(!empty($errors))
    {
        foreach($errors as $error)
        {
            echo $error;
        } 
    }?>
    </div>

    <div class="row">
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
            <p>User type: <input type="text"value="user"name="user_type"></p>
            <button>Register</button>
        </form>
    </div>

    <?php
        include_once '../includes/footer.php';
    }?>