<?php
/**
 * Profile module.
 */
function profile_rows($user)
{
	require_once './test.inc.php';
	$data = test_get_data();
    $rows = array();
    foreach ($data['users'] as $u) {
        if ($u['id'] != $user['id']) {
            $rows[] = $u;
        }
    }
	return $rows;
}

/**
 * Display profiles in tabular format.
 */
function profile_rows_html($profiles)
{
	echo "<div id=\"blockProfileRows\">\n",
		"<h1>Profiles</h1>\n",
		"<table>\n";
	foreach ($profiles as $i=>$p) {
		echo "<tr>\n",
			"<td>", $i+1, "</td>\n",
            "<td>", h($p['userName']), "</td>\n",
			"<td><a href=\"", ROOT_PATH, "/profile.php?a=detail&amp;id=", $p['id'], "\">", h($p['title']), "</a></td>\n",
			"</tr>\n";
	}
	echo "</table>\n",
		"</div>\n";
}

/**
 * Fetch a profile details array.
 *
 * @return array
 */
function profile_detail($user, $id=null)
{
    if (empty($id)) $id = $user['id'];
    require_once './test.inc.php';
    $data = test_get_data();
    foreach ($data['users'] as $u) {
        if ($u['id'] == $id) {
            return $u;
        }
    }
    return false;
}

/**
 * Show profile's detail.
 */
function profile_detail_html($profile)
{
	echo "<div id=\"blockProfileDetail\">\n",
		"<h1>Detail for ", h($profile['userName']), "</h1>\n",
		"<h2>", h($profile['title']), "</h2>\n",
		"<p>", h($profile['body']), "</p>\n",
		"<p><a href=\"", h(ROOT_PATH, "/message.php?a=compose&toUserID=", $profile['id']), "\">Email</a></p>\n",
		"</div>\n";
}

/**
 * Show form for editing profile.
 */
function profile_edit_html($profile)
{
	echo "<div id=\"blockProfileEdit\">\n",
		"<h1>Edit Your Profile</h1>\n",
        "<form method=\"post\" action=\"\">\n",
        "<label for=\"edit_title\">Your ad's title:</label>\n",
		"<input type=\"text\" name=\"title\" value=\"", h(av($profile, 'title')), "\" id=\"edit_title\"/><br/>\n",
        "<label for=\"edit_body\">Describe yourself and what you are looking for:</label>\n",
		"<textarea name=\"body\" id=\"edit_body\" cols=\"80\" rows=\"10\">", h(av($profile, 'body')), "</textarea><br/>\n",
		"<input type=\"submit\" value=\"Update your profile\"/>",
        "</form>\n",
		"</div>\n";
}

function profile_update($user, $values)
{
    require_once './test.inc.php';
    $data = test_get_data();
    foreach ($data['users'] as $i=>$u) {
        if ($u['id'] == $user['id']) {
            $data['users'][$i] = array_merge($u, $values);
            test_save_data($data);
            return true;
        }
    }
    return false;
}
