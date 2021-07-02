<?php
   session_start();
   require_once '../config/connect_site_db.php';
   require_once '../auth/account_class.php';
   include 'actions/account-action.php';
   try
   {
   
        $account->LogOut();
        session_destroy();
        header('Location: /');
   }
   catch (Exception $e)
   {
       echo $e->getMessage();
       die();
   }
   
   
?>