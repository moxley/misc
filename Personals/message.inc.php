<?php
function message_rows($user, $inboxSent='inbox')
{
	require_once './test.inc.php';
	$data = test_get_data();
	$rows = array();
	foreach ($data['messages'] as $m) {
		if ($m[$inboxSent == 'sent' ? 'fromUserID' : 'toUserID'] == $user['id']) {
			$rows[] = $m;
		}
	}
	return $rows;
}

function message_rows_html($rows)
{
	echo "<div id=\"blockMessageRows\">\n",
        "<h2>Messages</h2>\n";
    if (empty($rows)) {
        echo "<p>You have no messages.</p>\n";
    }
    else {
        echo "<table>\n",
            "<tr><th>User</th><th>Subject</th></tr>\n";
        foreach ($rows as $msg) {
            echo "<tr>\n<td>",
                "<a href=\"",
                h(ROOT_PATH, "/profile.php?a=detail&id=", $msg['fromUserID']),
                "\">", h($msg['fromUserName']), "</a>",
                "</td>\n<td>",
                "<a href=\"",
                h(ROOT_PATH, "/message.php?a=detail&id=", $msg['id']),
                "\">", h($msg['body']), "</a>",
                "</td></tr>";
        }
        echo "</table>\n";
    }
    echo "</div>\n";
}

function message_detail($user, $msgID)
{
	require_once './test.inc.php';
	$data = test_get_data();
	$rows = array();
	foreach ($data['messages'] as $m) {
		if ($m['id'] == $msgID && ($m['fromUserID'] == $user['id'] || $m['toUserID'] == $user['id'])) {
			return $m;
		}
	}
	return false;
}

function message_detail_html($msg)
{
	echo "<div id=\"blockMessageDetail\">\n",
		"<table>\n",
		"<tr>\n",
		"<th>From:</th>",
		"<td><a href=\"", h(ROOT_PATH, "/profile.php?a=detail&id=", $msg['fromUserID']), "\">", h($msg['fromUserName']), "</a></td>",
		"</tr>\n",
		"<tr>\n",
		"<th>Subject:</th>",
		"<td>", h($msg['subject']), "</td>",
		"</tr>\n",
		"<tr>\n",
		"<th>Message:</th>\n",
		"<td>", h($msg['body']), "</td>\n",
		"</tr>\n",
		"</table>\n",
		"<a href=\"", h(ROOT_PATH, "/message.php?a=reply&id=", $msg['id']), "\">Reply</a>\n",
		"</div>\n";
}

function message_compose_html($msg)
{
	echo "<div id=\"blockMessageCompose\">\n",
		"<form method=\"post\" action=\"message.php?a=send\">\n",
		"<table>\n<tr>\n",
		"<th>To:</th>\n",
		"<td><input type=\"hidden\" name=\"toUserID\" value=\"", $msg['toUserID'], "\"/>",
		h($msg['toUserName']),
		"</td>\n",
		"</tr><tr>\n",
		"<th>Subject:</th>\n",
		"<td><input type=\"text\" name=\"subject\" value=\"", h($msg['subject']), "\"/></td>\n",
		"</tr><tr>\n",
		"<th>Message:</th>\n",
		"<td><textarea cols=\"60\" rows=\"10\" name=\"body\"></textarea></td>\n",
		"</tr>\n<tr>\n",
		"<td colspan=\"2\">\n",
		"<input type=\"submit\" value=\"Send\"/>\n",
		"</td>\n",
		"</tr>\n</table>",
		"</form>\n</div>\n";
}

function message_send($user, $msg)
{
    require_once './profile.inc.php';
    $msg['fromUserID'] = $user['id'];
    $msg['fromUserName'] = $user['userName'];
    $toUser = profile_detail($user, $msg['toUserID']);
    $msg['toUserName'] = $toUser['userName'];
    
    require_once './test.inc.php';
    $data = test_get_data();
    $id = 1;
    foreach ($data['messages'] as $m) {
        if ($m['id'] > $id) $id = $m['id'] + 1;
    }
    $msg['id'] = $id;
    $data['messages'][] = $msg;
    test_save_data($data);
    return $msg;
}

function message_to_reply($msg)
{
	$m2 = $msg;
	if (!preg_match('#^re:#i', $msg['subject'])) {
		$m2['subject'] = 'Re: ' . $msg['subject'];
	}
	$m2['fromUserID'] = $msg['toUserID'];
	$m2['fromUserName'] = $msg['toUserName'];
	$m2['toUserID'] = $msg['fromUserID'];
	$m2['toUserName'] = $msg['fromUserName'];
	unset($m2['id']);
	return $m2;
}
