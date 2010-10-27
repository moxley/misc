<?php
/**
 * HTML-encode one or more strings.
 *
 * @param $str string  A string. Additional strings can be passed, one for each parameter.
 */
function h()
{
	$args = func_get_args();
    foreach ($args as $i=>$arg) {
        if (is_array($arg)) $args[$i] = (string) $arg;
    }
	return implode('', array_map('htmlspecialchars', $args));
}

/**
 * Get the value from an $array, at the specified $key.
 *
 * @param $array array
 * @param $key string
 * @param $default mixed
 */
function av($array, $key, $default=null)
{
    if (!is_array($array)) throw new Exception("\$array isn't an array");
	if (array_key_exists($key, $array)) {
		return $array[$key];
	}
	else {
		return $default;
	}
}

/**
 * Used internally to fix magic_quotes_gpc.
 */
function stripslashes_r($value)
{
    return is_array($value) ?
		array_map('stripslashes_r', $value) :
		stripslashes($value);
}

/**
 * Render the before-content HTML for the page.
 */
function html_head()
{
	echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">\n",
        "<html>\n",
        "<head>\n",
        "<title>", h(config_val('site_name')), "</title>\n",
        "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">\n",
        "<link rel=\"stylesheet\" type=\"text/css\" href=\"", ROOT_PATH, "/assets/style.css\">\n",
        "<script type=\"text/javascript\" src=\"", ROOT_PATH, "/assets/jquery-1.3.1.js\"></script>\n",
        "<script type=\"text/javascript\" src=\"", ROOT_PATH, "/assets/jquery-blockUI.js\"></script>\n",
        "</head><body>\n";

    echo "<div id=\"header\">\n",
        "<h1><a href=\"", ROOT_PATH, "/\">", h(config_val('site_name')), "</a></h1>\n",
        (isset($userHTML) ? $userHTML : ''),
        (($user = av($_SESSION, 'user')) ?
        	"<div class=\"userInfo\">User: " . h($user['userName']) . " <br/>\n" .
            "<a href=\"login.php?a=logout\" class=\"login\">Sign Out</a>&nbsp; \n" .
	        "<a href=\"profile.php?a=edit\">Your Profile</a>\n" .
            "</div>\n"
	        : "<div class=\"userInfo\">" .
         		"<a href=\"login.php\">Login</a>\n" .
         		"</div>"),
        "<div class=\"nav\">\n",
        "<a href=\"profile.php\">Profiles</a> | ",
        "<a href=\"message.php\">Messages</a>",
        "</div>\n",
        "</div>\n";
	if (av($_SESSION, 'notice')) {
		echo "<div class=\"notice\">", $_SESSION['notice'], "</div>\n";
		unset($_SESSION['notice']);
	}
    echo "<div id=\"body\">\n";
}

/**
 * Render the post-content HTML for a page.
 */
function html_foot()
{
	echo "\n</div>\n",
        "<div id=\"footer\">&copy; ", date('Y'), " ", h(config_val('site_name')), "</div>\n",
        "</html>";
}

/**
 * Require a valid user.
 *
 * @return array User information
 */
function require_user()
{
    $user = av($_SESSION, 'user');
    if ($user) {
        return $user;
    }
    else {
        $forward = $_SERVER['PHP_SELF'];
        header('Location: ' . ROOT_PATH . '/?forward=' . $forward);
        exit;
    }
}

function config_val($key, $default=null)
{
    global $CONFIG;
    if (!isset($CONFIG)) {
        $CONFIG = parse_ini_file(LIB_DIR . '/config.ini');
        if ($CONFIG == false) {
            die("Cannot open configuration file");
        }
    }
    return av($CONFIG, $key, $default);
}

function die_page()
{
    html_head();
    echo "<div id=\"errorPage\">There was an error</div>\n";
    html_foot();
    exit;
}

error_reporting(E_ALL | E_STRICT);
ini_set('log_errors', true);
ini_set('display_errors', false);

define('LIB_DIR', dirname(__FILE__));
define('ROOT_DIR', dirname(LIB_DIR));
if (isset($_SERVER['REQUEST_URI'])) {
    define('ROOT_PATH', str_replace($_SERVER['DOCUMENT_ROOT'], '', ROOT_DIR));
}

date_default_timezone_set(config_val('timezone'));

/**
 * Fix the trouble that magic_quotes_gpc creates.
 */
if (get_magic_quotes_gpc()) {
	foreach (array('_GET', '_POST', '_REQUEST') as $var) {
        if (!empty($$var)) $$var = stripslashes_r($$var);
	}
}

session_start();
