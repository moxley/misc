<?php
require './lib/boot.php';
require_once './profile.inc.php';

$user = require_user();

html_head();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (av($_REQUEST, 'a') == 'edit') {
        if (profile_update($user, $_POST) == false) {
            $_SESSION['notice'] = 'Failed to update your profile';
            $profile = profile_detail($user);
            $profile = array_merge($profile, $_POST);
            html_head();
            profile_edit_html($profile);
            html_foot();
            exit;
        }
        else {
            $_SESSION['notice'] = 'Successfully updated your profile';
            header('Location: profile.php?a=edit');
            exit;
        }
    }
}
else {
    if (av($_REQUEST, 'a') == 'detail') {
        $profile = profile_detail($user, $_GET['id']);
        profile_detail_html($profile);
    }
    else if (av($_REQUEST, 'a') == 'edit') {
        $profile = profile_detail($user);
        profile_edit_html($profile);
    }
    else {
        $profiles = profile_rows($user);
        profile_rows_html($profiles);
    }
}

html_foot();
