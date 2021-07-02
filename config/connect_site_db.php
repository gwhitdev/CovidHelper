<?php

$host = 'localhost';
$user = 'gareth';
$pass = 'password';
$schema = 'covidhelper';
/*$name = 'covidhelper';
$dbc = new mysqli($db_host,$db_user,$db_pass,$db_name);
if($dbc->connect_error)
{
    echo 'Could not connect to database<br>';
    die("Connection failed: " . $dbc->connect_error);
}
*/

$pdo  = NULL;
$dsn = 'mysql:host=' . $host . ';dbname=' . $schema;

try
{
    $pdo = new PDO($dsn,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    echo 'Database connection failed';
    die();
}






