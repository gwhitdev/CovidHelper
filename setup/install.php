<?php

require_once '../config/connect_site_db.php';
require_once '../config/site_config.php';

function createUsersTables($dbc)
{
    $q = 'CREATE TABLE IF NOT EXISTS users
    (
        user_id     INT UNSIGNED NOT NULL AUTO_INCREMENT,
        first_name  VARCHAR(20) NOT NULL,
        last_name   VARCHAR(40) NOT NULL,
        email       VARCHAR(60) NOT NULL,
        pass        CHAR(60) NOT NULL,
        reg_date    DATETIME NOT NULL,
        user_type   VARCHAR(10) NOT NULL,
        PRIMARY KEY (user_id),
        UNIQUE (email)
    )';
    
    $r = mysqli_query($dbc,$q);
    echo '<p>';
    echo "Users database created successfully.";
    echo '</p>';
    return $r;
}

function checkForSuperUser($dbc,$email)
{
    echo 'Checking for superuser in database.';
    echo '<br>';
    $q = "SELECT * FROM users WHERE email IN ('$email')";
    $res = $dbc->query($q);
    $num = mysqli_num_rows($res);
    echo '<br>';
    echo "Number of users in database? (There should be just 1 at the moment): $num";
    echo '<br>';
    if($num == 1)
    {
        echo '<br>Superuser exists, skipping superuser creation.';
        echo '<br>';
        echo '<br>';
        return true;
    }
    else
    {
        echo "<br>Superuser doesn't exist, create one.";
        echo '<br>';
        echo '<br>';
        return false;
    }
    
    
}

function addSuperUser($dbc,$email,$DEFAULT_PASSWORD)
{
    $p = mysqli_real_escape_string($dbc,$DEFAULT_PASSWORD);
    $hash = password_hash($p, PASSWORD_DEFAULT);

    $q = "INSERT INTO users (first_name,last_name,email,pass,reg_date,user_type)
        VALUES
        ('Gareth','Whitley','$email','$hash',NOW(),'admin')";
       $r = mysqli_query($dbc,$q);
       echo '<br>Added superuser';
       echo '<br>';
       return $r;
}

function getUsers($dbc)
{
    $q = 'SELECT * FROM users';
    $r = mysqli_query($dbc, $q);
    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    return $row;
}

function getRows($dbc)
{
    $q = 'SELECT * FROM users';
    $r = mysqli_query($dbc,$q);
    $rows = mysqli_num_rows($r);
    return $rows;
}

function addTestPatientData($dbc,$res)
{
    if($res)
    {
        $test_patient = "INSERT INTO patients(
            patient_first_name,patient_last_name,patient_email,patient_postcode,patient_dob,patient_notes,date_created)
            VALUES (
            'Test First Name','Test Last Name','testpatient@test.com','LL1 1LL','1986-06-01','Test notes',NOW());";
        $insert_test_patient = $dbc->query($test_patient);
        $test_patient_insert_confirmed = mysqli_num_rows($insert_test_patient);
        if($test_patient_insert_confirmed)
        {
            return true;
        }
    }
}
function createPatientsTable($dbc)
{
    $query = "CREATE TABLE IF NOT EXISTS patients 
    (
    patient_id              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    patient_first_name      VARCHAR(40) NOT NULL,
    patient_last_name       VARCHAR(60) NOT NULL,
    patient_email           VARCHAR(50) NOT NULL,
    patient_postcode        VARCHAR(50) NOT NULL,
    patient_dob             DATE NOT NULL,
    vaccination_one         DATE,
    vaccination_two         DATE,
    patient_notes           TEXT,
    date_created            DATE NOT NULL,
    user_id                 INT UNSIGNED,
    PRIMARY KEY (patient_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    UNIQUE (patient_email,user_id)
    );";
    $res = $dbc->query($query);
    return $res;
    
}

function checkForPatientsTable($dbc)
{
    $checkQuery = "SELECT * FROM patients";
    $present = $dbc->query($checkQuery);
    $table_rows = mysqli_num_rows($present);
    if($table_rows > 0)
    {
        return true;
    }
    return false;
}

if($dbc)
{
    $created = createUsersTables($dbc);
    if($created && !checkForSuperUser($dbc,$DEFAULT_EMAIL))
    {
        addSuperUser($dbc,$DEFAULT_EMAIL,$DEFAULT_PASSWORD);
    }
    
    echo '<br>';
    echo '<p>User database setup. Will now try to create patients database</p>';
    echo '<p>Checking if patients table already exists.';

    $doesPatientsTableExist = checkForPatientsTable($dbc);
    if(!$doesPatientsTableExist)
    {   
        echo "<p>Patients table doesn't exist. Trying to create it.";
        $createPatientsTable = createPatientsTable($dbc);
        echo "<p>Created.</p>";
    }
    else
    {
        echo '<p>Patients table already exists. Table creation skipped.';
    }

    if($createPatientsTable)
    {
        echo '<p>Trying to add test patient data.</p>';
        $testPatientAdded = addTestPatientData($dbc,$createPatientsTable);
        echo '<p>Test patient data added.</p>';
    }

}
else
{
    return 'No database connected';
    echo '<br><br>';
}
