<?php
   session_start();
   require_once '../config/connect_site_db.php';
   require_once '../auth/account_class.php';
   include 'actions/account-action.php';
   try
   {
        $account->LogOut();
        header('Location: /');
   }
   catch (Exception $e)
   {
       echo $e->getMessage();
       die();
   }
   
   include_once 'header.php'; 
   include 'nav.php';
?>