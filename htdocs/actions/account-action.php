<?php
    global $pdo;
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