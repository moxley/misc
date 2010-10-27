<?php
require './lib/boot.php';
require_once './register.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = register_save($_POST);
    if ($user == false) {
        html_head();
        register_html();
        html_foot();
        exit;
    }
    else {
        $_SESSION['user'] = $user;
        header('Location: profile.php?a=edit');
        exit;
    }
}
else {
    html_head();
    register_html();
    html_foot();
}
