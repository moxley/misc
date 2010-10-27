<?php

function login_authenticate($userName, $password)
{
    require_once './test.inc.php';
    $data = test_get_data();
    foreach ($data['users'] as $u) {
        if ($u['userName'] == $userName) {
            return $u;
        }
    }
    return false;
}

function login_html($login=array())
{
    echo "<div id=\"blockLogin\">\n",
        "<h1>Please Log In</h1>\n",
        "<p class=\"notRegistered\">Not registered? <a href=\"register.php\">register here</a></p>\n",
        "<form method=\"POST\" action=\"login.php\">\n",
        "<label for=\"userName\">Login Name:</label>\n",
        "<input type=\"text\" name=\"userName\" id=\"userName\"/>\n",
        "<br/>\n",
        "<label for=\"password\">Password:</label>\n",
        "<input type=\"password\" name=\"password\"/>\n",
        "<br/>\n",
        "<input type=\"hidden\" name=\"forward\" value=\"", h(av($_GET, 'forward')), "\"/>\n",
        "<input type=\"submit\" value=\"Login\"/>\n",
        "<input type=\"button\" value=\"Cancel\" class=\"cancel\"/>\n",
        "</form>\n",
        "</div>\n";
}
