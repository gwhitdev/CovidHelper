<?php
session_start();
if(!isset($_SESSION['user_id']))
{
    require_once '../../auth/login_tools.php';
    load();
}
$page_title = 'Add a new message';
include_once '../../includes/header.php';

?>

    <form action="../actions/post_action.php"method="POST"accept_charset="utf-8">
        <p>
            Subject: <input type="text"name="subject"size="64">
        </p>
        <p>
            Message:<br>
            <textarea name="message"rows="5"cols="50"></textarea>
        </p>
        <p>
            <button class="btn btn-lg btn-success">Submit</button>
        </p>
    </form>
    

    <?php include '../../includes/footer.php' ?>

