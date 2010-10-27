<?php
require './lib/boot.php';
require_once './message.inc.php';

$user = require_user();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (av($_REQUEST, 'a') == 'send') {
		message_send($user, $_POST);
		$_SESSION['notice'] = "Message was <strong>sent</strong>";
		header('Location: message.php');
	}
}
else {
	html_head();
	if (av($_GET, 'a') == 'detail') {
		$msgID = $_GET['id'];
		message_detail_html(message_detail($user['id'], $msgID));
	}
	else if (av($_GET, 'a') == 'compose') {
		require_once './profile.inc.php';
		$toUser = profile_detail($user, $_GET['toUserID']);
		$msg = array('toUserID' => $toUser['id'],
			'toUserName' => $toUser['userName'],
			'subject'    => '');
		message_compose_html($msg);
	}
	else if (av($_GET, 'a') == 'reply') {
		$msgID = $_GET['id'];
		$msg = message_to_reply(message_detail($user['id'], $msgID));
		message_compose_html($msg);
	}
	else {
		message_rows_html(message_rows($user['id']));
	}
	html_foot();
}
