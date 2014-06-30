<?php
use Zwaldeck\Registry\Registry;
use Zwaldeck\Http\Response;
use Zwaldeck\Http\Request;
use Zwaldeck\Router\Router;
use Zwaldeck\Db\Adapter\PdoAdapter;
use Zwaldeck\Util\Constants;
use Zwaldeck\Db\Adapter\MysqliAdapter;

set_error_handler("exception_error_handler");
register_shutdown_function('fatal_error_handler');

$config = require_once(ROOT . DS . 'Config/config.php');

Registry::put('config', $config); // put config in registery

init();

/**
 * Bootstrap functions
 */

/**
 * Code convention filename == classname + .
 *
 *
 * php
 */
function __autoload($className)
{ // never again we need a require

    if (strpos(strtolower($className), 'application') === 0) {
        $path = ROOT;
    } else {
        $path = ROOT . DS . 'Library';
    }

    foreach (explode('\\', $className) as $value) {
        $path .= DS . $value;
    }
    if (!file_exists($path . '.php')) {
        throw new Exception ("Could not load class {$className}");
    } else {
        require_once $path . '.php';
    }
}

/**
 * check for magic quotes and remove them --> Maybe to Request
 */
function stripSlashesDeep($value)
{
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}

function removeMagicQuotes()
{
    if (get_magic_quotes_gpc()) {
        $_GET = stripSlashesDeep($_GET);
        $_POST = stripSlashesDeep($_POST);
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}

function init()
{
    removeMagicQuotes();

    $config = Registry::get('config');

    if (!isset ($_GET ['url']))
        $_GET ['url'] = $config ['defaultController'] . '/' . $config ['defaultAction'];

    $url = $_GET ['url'];

    initDbAdapter($config ['db']);

    $layout = file_exists(ROOT . DS . 'Application/Views/layout.php') ? require(ROOT . DS . 'Application/Views/layout.php') : null;

    $request = new Request ($_SERVER ['REQUEST_METHOD'], $url, $_SERVER, file_get_contents('php://input'));
    $response = new Response ();

    $router = new Router ($url, $layout, $response, $request);
}

function initDbAdapter($db)
{
    $dbAdapter = null;

    // port
    if (!isset ($db ['port']) || trim($db ['port']) == '') {
        $port = Constants::DEFAULT_DATABASE_PORT;
    } else {
        $port = $db ['port'];
    }

    // charset
    if (!isset ($db ['charset']) || trim($db ['charset']) == '') {
        $charset = Constants::DEFAULT_DATABASE_CHARSET;
    } else {
        $charset = $db ['charset'];
    }

    if (strtolower($db ['type']) == 'pdo') {
        $dbAdapter = new PdoAdapter ($db ['host'], $db ['user'], $db ['password'], $db ['database'], $port, $charset);
    } else if (strtolower($db ['type']) == 'mysqli') {
        $dbAdapter = new MysqliAdapter($db['host'], $db['user'], $db['password'], $db['database'], $port, $charset);
    }

    Registry::set('dbAdapter', $dbAdapter);
}

function exception_error_handler($errno, $errstr, $errfile, $errline)
{
    throw new \ErrorException ($errstr, 0, $errno, $errfile, $errline);
}

function fatal_error_handler()
{
    $last_error = error_get_last();
    if ($last_error ['type'] === E_ERROR) {
        // fatal error
        exception_error_handler(E_ERROR, $last_error ['message'], $last_error ['file'], $last_error ['line']);
    }
}

/**
 *
 * end Bootstrap functions
 */

