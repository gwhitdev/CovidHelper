<?php

    session_start();
    require_once '../../../config/connect_site_db.php';  
    require_once '../../../audit/audit-tasks.php';
    require_once '../../../validators/patient-validator.php';

    if(isset($_SESSION['user_id']))
    {
        
        require_once '../../../auth/login_tools.php';
        $checked = checkPermissions($dbc,$_SESSION['user_id']);
        $user_id = $_SESSION['user_id'];

        if($checked != 'admin')
        {
            load('home.php');
        }

        if($_SERVER['REQUEST_METHOD'] == 'GET')
        {
            $errors = array();
            $id_to_delete = $_GET['id'];
            $user_id = $_SESSION['user_id'];

            echo "id: $id_to_delete";

            $query = "UPDATE patients SET deleted = true WHERE patient_id = $id_to_delete";
            $markedToDelete = $dbc->query($query);
            if($markedToDelete)
            {
                applyPatientAuditActivity($dbc,$user_id,$id_to_delete,'Patient record marked to delete');
                $success_string = 'User deleted';
                echo $success_string;
                $dbc->close();
            }
            else
            {
                applyPatientAuditActivity($dbc,$user_id,$id_to_delete,'Tried to delete patient record. Did not work.');
                array_push($errors,'Could not delete record');
                array_push($errors, "ID: $user_id PATIENT_ID: $id_to_delete");
                foreach($errors as $err)
                {
                    echo $err;
                }
                $dbc->close();
            }
        }

    }