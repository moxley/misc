<?php
require './lib/boot.php';
require_once './login.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = login_authenticate($_POST['userName'], $_POST['password']);
    if (!$user) {
        $_SESSION['notice'] = 'Incorrect Login Name or Password. Try again.';
        header('Location: login.php?forward=' . urlencode($_POST['forward']));
        exit;
    }

    $_SESSION['user'] = $user;
    
    if ($_POST['forward']) {
        header('Location: ' . $_POST['forward']);
        exit;
    }
    else {
        html_head();
        echo "Welcome, ", h($user['userName']), "<br/>\n";
        html_foot();
        exit;
    }
}
else {
    if (av($_GET, 'a') == 'logout') {
        unset($_SESSION['user']);
        header('Location: ' . ROOT_PATH . '/');
        exit;
    }
}

html_head();
login_html();
html_foot();
