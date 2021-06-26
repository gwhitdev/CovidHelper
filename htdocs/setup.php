<?php

require '../setup/install.php';

$res = $dbc->query('SELECT * FROM users');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 

while($user_row = mysqli_fetch_array($res, MYSQLI_ASSOC))
{
    $email = $user_row['email'];
}
?>    
<body>
   <p>
    <strong>You can now <a href="/login.php">login</a> with <?php echo $email ?> and the default password that is set in the site config file.</strong>
   </p>
</body>
</html>


<?php mysqli_close($dbc); ?>