<?php
$db_host = 'localhost';
$db_user = 'gareth';
$db_pass = 'password';
$db_name = 'covidhelper';

$dbc = new mysqli($db_host,$db_user,$db_pass,$db_name);

if($dbc->connect_error)
{
    echo 'Could not connect to database<br>';
    die("Connection failed: " . $dbc->connect_error);
}
$dbc->set_charset('utf8');
