<?php

    session_start();
    require_once '../../../config/connect_site_db.php';  
    require_once '../../../audit/audit-tasks.php';
    require_once '../../../validators/patient-validator.php';

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
            
            list ($fn_error, $fn) = validatePatientFirstName($dbc, $_POST['patient_first_name']);
            list ($ln_error, $ln) = validatePatientLastName($dbc, $_POST['patient_last_name']);
            list ($e_error, $e) = validatePatientEmail($dbc,$_POST['patient_email']);
            list ($pc_error, $pc) = validatePatientPostCode($dbc,$_POST['patient_postcode']);
            list ($dob_error, $dob) = validatePatientDob($dbc,$_POST['patient_dob']);
            $v1 = validatePatientVaccinationOne($dbc,$_POST['vaccination_one']);
            $v2 = validatePatientVaccinationTwo($dbc,$_POST['vaccination_two']);
            $notes = validatePatientNotes($dbc,$_POST['patient_notes']);

            $errors_array = array($fn_error,$ln_error,$e_error,$pc_error,$dob_error);
            foreach($errors_array as $err)
            {
                if($err != '') array_push($errors,$err);
            }

            

            if(empty($errors))
            {
                $q = "UPDATE patients SET patient_first_name = '$fn',patient_last_name = '$ln',patient_email='$e',patient_postcode='$pc',patient_dob='$dob',vaccination_one='$v1',vaccination_two='$v2',patient_notes='$notes'
                WHERE patient_email = '$e'";
                $r = mysqli_query($dbc,$q);
                $audit_updated = false;
                if($r)
                {
                    $audit_user_id = $_SESSION['user_id'];
                    $patient_id_query = "SELECT patient_id FROM patients WHERE patient_email = '$e'";
                    $get_patient_id = $dbc->query($patient_id_query);
                    $num = mysqli_num_rows($get_patient_id);
                    if($num > 0)
                    {
                        $patient = mysqli_fetch_assoc($get_patient_id);
                        $audit_patient_id = $patient['patient_id'];
                        applyPatientAuditActivity($dbc,$audit_user_id,$audit_patient_id,'Patient record updated');
                        if(mysqli_affected_rows($dbc) == 1)
                        {
                            $audit_entry_added = 'Successfully added audit entry';
                            $audit_updated = true;
                            $dbc->close();
                        }
                        else
                        {
                            array_push($errors, 'Patient record updated, but activity not recorded in audit. Please contact your database administrator.');
                        }
                    }

                }
                if($r && $audit_updated)
                {
                    load("/dashboard/patients/patient.php?id=$audit_patient_id");
                }
                else
                {
                    array_push($errors, 'Error!');
                    //array_push($errors, "$fn,$ln,$e,$pc,$dob,$v1,$v2,$notes");
                }
            }
        }
       
    }

        $patient_id = $_GET['id'];
        function getPatientDetails($dbc,$patient_id)
        {
            $q = "SELECT * FROM patients WHERE patient_id = $patient_id";
            $get_user = $dbc->query($q);
            if($get_user)
            {
                $patient = mysqli_fetch_assoc($get_user);
                $dbc->close();
                return array($patient['patient_first_name'], $patient['patient_last_name'], $patient['patient_dob'],$patient['patient_email'],
                                $patient['patient_notes'],$patient['date_created'],$patient['vaccination_one'],$patient['vaccination_two'],$patient['patient_postcode']);
            }
            else
            {
                $dbc->close();
                return 'No patient';
            }
        }

        list ($patient_first_name,$patient_last_name,$patient_dob,$patient_email,$patient_notes,$date_created,$vaccination_one,$vaccination_two,$patient_postcode) = getPatientDetails($dbc,$patient_id);
    
        $page_title = 'Update patient record';
    include_once '../../../includes/header.php';
?>


<div class="row">
    <h1>Update patient record</h1>
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
<form action="update-patient.php?id=<?php echo $patient_id ?>" method="POST">
    <p>
        First name: <input type="text" name="patient_first_name" value="<?php if(isset($patient_first_name)) echo $patient_first_name; ?>"><br>
        Last name: <input type="text" name="patient_last_name" value="<?php if(isset($patient_last_name)) echo $patient_last_name;?>"><br>
    </p>
    <p>
        Email address: <input type="text" name="patient_email" value="<?php if(isset($patient_email)) echo $patient_email;?>">
    </p>
    <p>
        Patient date of birth: <input type="date" name="patient_dob" value="<?php if(isset($patient_dob)) echo $patient_dob;?>">
    </p>
    <p>
        Post code: <input type="text" name="patient_postcode" value="<?php if(isset($patient_postcode)) echo $patient_postcode;?>">
    </p>
    <p>
        Date received first vaccination: <input type="date" name="vaccination_one" value="<?php if(isset($vaccination_one)) echo $vaccination_one;?>"><br>
        Date received first vaccination: <input type="date" name="vaccination_two" value="<?php if(isset($vaccination_two)) echo $vaccination_two;?>">
    </p>
    <p>
        Notes:<br>
        <textarea  name="patient_notes" cols="100"rows="10"><?php if(isset($patient_notes)) echo $patient_notes;?></textarea>
    </p>
    <button>Update</button>
</form>
</div>

<?php
include '../../../includes/footer.php';
?>