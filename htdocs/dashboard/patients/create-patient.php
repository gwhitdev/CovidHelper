<?php

use Symfony\Component\Mime\Test\Constraint\EmailHtmlBodyContains;

session_start();
    require_once '../../../config/connect_site_db.php';    
    if(isset($_SESSION['user_id']))
    {
        
        require_once '../../../auth/login_tools.php';
        $checked = checkPermissions($dbc,$_SESSION['user_id']);
        
        if($checked != 'admin')
        {
            load('home.php');
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $errors = array();
            if(empty($_POST['patient_first_name']))
            {
                array_push($errors,'Enter your first name');
            }
            else
            {
                $fn = mysqli_real_escape_string($dbc,trim($_POST['patient_first_name']));
            }

            if(empty($_POST['patient_last_name']))
            {
                array_push($errors,'Enter your last name');
            }
            else 
            {
                $ln = mysqli_real_escape_string($dbc,trim($_POST['patient_last_name']));
            }

            if(empty($_POST['patient_email']))
            {
                array_push($errors,'Enter your email address');
            }
            else
            {
                $e = mysqli_real_escape_string($dbc,trim($_POST['patient_email']));
            }

            if(empty($_POST['vaccination_one']))
            {
                $v1 = '0000-01-01';
            }
            else
            {
                $v1 = mysqli_real_escape_string($dbc,trim($_POST['vaccination_one']));
                
            }
            if(empty($_POST['vaccination_two']))
            {
                $v2 = '0000-01-01';
            }
            else
            {
                $v2 = mysqli_real_escape_string($dbc,trim($_POST['vaccination_two']));
                
            }
            if(empty($_POST['patient_notes']))
            {
                $notes = '';
            }
            else
            {
                $notes = mysqli_real_escape_string($dbc,trim($_POST['patient_notes']));
                
            }
            if(empty($_POST['patient_postcode']))
            {
                array_push($errors,'Please provide a post code');
            }
            else
            {
                $pc = mysqli_real_escape_string($dbc,trim($_POST['patient_postcode']));
                
            }

            if(empty($_POST['patient_dob']))
            {
                array_push($errors,'Please provide a date of birth for the patient.');
            }
            else
            {
                $dob = mysqli_real_escape_string($dbc,trim($_POST['patient_dob']));
                
            }

            if(empty($errors))
            {
                $q = "SELECT patient_id FROM patients WHERE patient_email='$e'";
                $r = mysqli_query($dbc,$q);
                if(mysqli_num_rows($r) > 0)
                {
                    array_push($errors,'Email address already registered.');
                }
            }

            if(empty($errors))
            {
                /*$q = "INSERT INTO patients (patient_first_name,patient_last_name,patient_email,patient_postcode,patient_dob,vaccination_one,vaccination_two,patient_notes,date_created) 
                        VALUES ('$fn','$ln','$e','$pc','$dob','$v1','$v2','$notes',NOW());";*/
                $q = "INSERT INTO patients (patient_first_name,patient_last_name,patient_email,patient_postcode,patient_dob,vaccination_one,vaccination_two,patient_notes,date_created)
                VALUES ('$fn','$ln','$e','$pc','$dob','$v1','$v2','$notes',NOW())";
                $r = mysqli_query($dbc,$q);

                if($r)
                {
                    $success_string = "<h1>Created!</h1><p>The new patient record has been created.</p>";
                    $page_title = 'Success!';
                    include '../../../includes/header.php';
                    echo $success_string;
                    include '../../../includes/footer.php';
                    mysqli_close($dbc);
                    exit();
                }
                else
                {
                    array_push($errors, 'Error!');
                    array_push($errors, "$fn,$ln,$e,$pc,$dob,$v1,$v2,$notes");
                }
            }
        }
       
    }
    $page_title = 'Create patient record';
    include_once '../../../includes/header.php';
?>
<div class="row">
    <h1>Create new patient record</h1>
</div>
<div class="row">
<?php
    if(!empty($errors))
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

?>
<form action="create-patient.php" method="POST">
    <p>
        First name: <input type="text" name="patient_first_name" value="<?php if(isset($_POST['patient_first_name'])) echo $_POST['patient_first_name']; ?>"><br>
        Last name: <input type="text" name="patient_last_name" value="<?php if(isset($_POST['patient_last_name'])) echo $_POST['patient_last_name'];?>"><br>
    </p>
    <p>
        Email address: <input type="text" name="patient_email" value="<?php if(isset($_POST['patient_email'])) echo $_POST['patient_email'];?>">
    </p>
    <p>
        Patient date of birth: <input type="date" name="patient_dob" value="<?php if(isset($_POST['patient_dob'])) echo $_POST['patient_dob'];?>">
    </p>
    <p>
        Post code: <input type="text" name="patient_postcode" value="<?php if(isset($_POST['patient_postcode'])) echo $_POST['patient_postcode'];?>">
    </p>
    <p>
        Date received first vaccination: <input type="date" name="vaccination_one" value="<?php if(isset($_POST['vaccination_one'])) echo $_POST['vaccination_one'];?>"><br>
        Date received first vaccination: <input type="date" name="vaccination_two" value="<?php if(isset($_POST['vaccination_two'])) echo $_POST['vaccination_two'];?>">
    </p>
    <p>
        Notes:<br>
        <textarea  name="patient_notes" cols="100"rows="10"><?php if(isset($_POST['patient_notes'])) echo $_POST['patient_notes'];?></textarea>
    </p>
    <button>Create</button>
</form>
</div>

<?php
include '../../../includes/footer.php';
?>