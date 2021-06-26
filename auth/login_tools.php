<?php

function load($page = 'login.php')
{
    $url = 'http://' . $_SERVER['HTTP_HOST'];
    $url = rtrim($url,'/\\');
    $url .='/' . $page;

    header("Location: $url");
    exit();
}
function checkPermissions($dbc,$user_id)
{
    $q = "SELECT user_type FROM users WHERE user_id = '$user_id'";
    $r = $dbc->query($q);
    $r;
    if(mysqli_num_rows($r) > 0)
    {
       while($row = mysqli_fetch_assoc($r))
      {
      if($row['user_type'] == 'admin') return 'admin';
      if($row['user_type'] == 'user') return 'user';
      if($row['user_type'] == 'medical') return 'medical';
      }
       
    }
   else
   {
      return 'Not authorised';
   }
    
}
function validate($dbc,$email='',$pwd='')
{
    $errors = array();

    if(empty($email))
    {
        array_push($errors, 'Please enter your email address.');
    }
    else
    {
        $e = mysqli_real_escape_string($dbc, trim($email));
    }

    if(empty($pwd))
    {
        array_push($errors, 'Please enter your password.');
    }
    else
    {
        $p = mysqli_real_escape_string($dbc, trim($pwd));
    }

    if(empty($errors))
    {
        
        $q = "SELECT user_id, first_name, last_name, pass
        FROM users
        WHERE email = '$e'";
        $r = mysqli_query($dbc, $q);
        if(mysqli_num_rows($r) == 1)
        {
            $row = mysqli_fetch_assoc($r);
            if(password_verify($p,$row['pass']))
            {
                return array(true, $row);
            }
        }
        else
        {
            array_push($errors, 'Email address or password not found.');
        }
    }
    return array(false, $errors);
}