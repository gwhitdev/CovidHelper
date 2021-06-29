<?php


    function validatePatientFirstName($dbc,$first_name)
    {
        $error = '';
        if(empty($first_name)) $error = 'Please enter a first name';
        $fn = mysqli_real_escape_string($dbc,trim($_POST['patient_first_name']));
        return array ($error,$fn);
    }

    function validatePatientLastName($dbc,$last_name)
    {
        $error = '';
        if(empty($last_name)) $error = 'Please enter a last name';
        $ln = mysqli_real_escape_string($dbc,trim($_POST['patient_last_name']));
        return array ($error,$ln);
    }

    function validatePatientEmail($dbc,$email)
    {
        $error = '';
        if(empty($email)) $error = 'Please enter an email address';
        $e = mysqli_real_escape_string($dbc,trim($_POST['patient_email']));
        return array ($error,$e);
    }

    function validatePatientVaccinationOne($dbc,$v1)
    {
        if(empty($v1)) return '0000-01-01';
        return mysqli_real_escape_string($dbc,trim($v1));
    }

    function validatePatientVaccinationTwo($dbc,$v2)
    {
        if(empty($v2)) return '0000-01-01';
        return mysqli_real_escape_string($dbc,trim($v2));
    }

    function validatePatientNotes($dbc,$notes)
    {
        if(empty($notes)) return $notes = 'None';
        return mysqli_real_escape_string($dbc,trim($notes));
    }

    function validatePatientPostCode($dbc,$pc)
    {
        $error = '';
        if(empty($pc)) $error = 'Please enter a post code';
        $pc = mysqli_real_escape_string($dbc,trim($_POST['patient_postcode']));
        return array ($error,$pc);
    }

    function validatePatientDob($dbc,$dob)
    {
        $error = '';
        if(empty($dob)) $error = 'Please enter a date of birth.';
        $dob = mysqli_real_escape_string($dbc,trim($_POST['patient_dob']));
        return array ($error,$dob);
    }
