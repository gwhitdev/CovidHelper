<?php

//    require_once '../../auth/account_class.php';
    $loggedIn = FALSE;
    $account = new Account();
    if(!$loggedIn)
    {
        $loggedIn = $account->SessionLogin();
        $authenticated = $account->IsAuthenticated();
    }
    else
    {
        header('Location: /login.php');
    }

    ?>