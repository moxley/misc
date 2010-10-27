<?php
function register_html($reg=array(), $options=array())
{
    echo "<div id=\"blockRegister\">\n",
        "<h2>Create An Account</h2>\n",
        (av($options, 'showLoginLink', true) ? "<p>Already have an account? <a href=\"login.php\" class=\"login\">Login here</a>.</p>\n" : ''),
        "<form method=\"post\" action=\"register.php\">\n",
        "<label for=\"register_userName\">Username:</label>\n",
        "<input type=\"text\" name=\"userName\" id=\"register_userName\" value=\"", h(av($reg, 'userName')), "\"/><br/>\n",
        "<label for=\"register_password\">Password:</label>\n",
        "<input type=\"text\" name=\"password\" id=\"register_password\"/><br/>\n",
        "<label for=\"register_email\">Email:</label>\n",
        "<input type=\"text\" name=\"email\" id=\"register_email\" value=\"", h(av($reg, 'email')), "\"/><br/><br/>\n",
        "<input type=\"submit\" value=\"Begin\"/>",
        "</form>\n",
        "</div>\n";
}

function register_save($values)
{
    require_once './test.inc.php';
    $data = test_get_data();
    $id = 1;
    foreach ($data['users'] as $i=>$u) {
        if ($u['userName'] == $values['userName']) {
            $_SESSION['notice'] = "The username '" . h($values['userName']) . "' is already in use.";
            return false;
        }
        if ($u['id'] >= $id) $id = $u['id'] + 1;
    }
    $values['id'] = $id;
    $data['users'][] = $values;
    test_save_data($data);
    return $values;
}
