<?php
namespace Zwaldeck;

use Zwaldeck\ACL\ACL;
use Zwaldeck\AnnotationEngine\AnnotationEngine;
use Zwaldeck\Exception\ConfigErrorException;
use Zwaldeck\Registry\FrameworkRegistry;
use Zwaldeck\Registry\Registry;
use Zwaldeck\Util\Constants;
use Zwaldeck\Db\Adapter\PdoAdapter;
use Zwaldeck\Db\Adapter\MysqliAdapter;
use Zwaldeck\Http\Request;
use Zwaldeck\Http\Response;
use Zwaldeck\Router\Router;

/**
 * Class Bootstrap
 * @package Zwaldeck
 * @author wout schoovaerts
 */
class Bootstrap
{
    public function __construct()
    {
        spl_autoload_register('Zwaldeck\Bootstrap::autoload');
        set_error_handler('Zwaldeck\Bootstrap::exception_error_handler');
        register_shutdown_function('Zwaldeck\Bootstrap::fatal_error_handler');

        $config = require_once(ROOT . DS . 'Config/Config.php');

        if (array_key_exists('acl_enabled', $config) && $config['acl_enabled']) {
            $this->checkPermissions(); //check permissions is valid
        }

        Registry::put('config', $config); // put config in registery

        $this->removeMagicQuotes();

        $config = Registry::get('config');

        if (!isset ($_GET ['url']))
            $_GET ['url'] = $config ['defaultController'] . '/' . $config ['defaultAction'];

        $url = $_GET ['url'];

        $this->initDbAdapter($config ['db']);

        //tmp code
        new AnnotationEngine(new TmpClass());

        $layout = file_exists(ROOT . DS . 'Application/Views/layout.php') ? require(ROOT . DS . 'Application/Views/layout.php') : null;

        $request = new Request ($_SERVER ['REQUEST_METHOD'], $url, $_SERVER, file_get_contents('php://input'));
        $response = new Response ();

        FrameworkRegistry::put('response', $response); //don't change this is used internally

        $router = new Router ($url, $layout, $response, $request);
        Registry::put('route', $router);



    }

    /**
     * @param $className
     * @throws \Exception
     */
    private static function autoLoad($className)
    {
        if (strpos(strtolower($className), 'application') === 0) {
            $path = ROOT;
        } else {
            $path = ROOT . DS . 'Library';
        }

        foreach (explode('\\', $className) as $value) {
            $path .= DS . $value;
        }
        if (!file_exists($path . '.php')) {
            throw new \Exception ("Could not load class {$className}");
        } else {
            require_once $path . '.php';
        }
    }

    /**
     * @param $value
     * @return array|string
     */
    private function stripSlashesDeep($value)
    {
        $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
        return $value;
    }

    private function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = stripSlashesDeep($_GET);
            $_POST = stripSlashesDeep($_POST);
            $_COOKIE = stripSlashesDeep($_COOKIE);
        }
    }

    /**
     * @param $db
     */
    private function initDbAdapter($db)
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
        FrameworkRegistry::get('dbAdapter', $dbAdapter); //don't change this is used internally
    }

    /**
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @throws \ErrorException
     */
    public static function exception_error_handler($errno, $errstr, $errfile, $errline)
    {
        throw new \ErrorException ($errstr, 0, $errno, $errfile, $errline);
    }


    public static function fatal_error_handler()
    {
        $last_error = error_get_last();
        if ($last_error ['type'] === E_ERROR) {
            // fatal error
            exception_error_handler(E_ERROR, $last_error ['message'], $last_error ['file'], $last_error ['line']);
        }
    }

    private function checkPermissions()
    {
        $config = require_once(ROOT . DS . 'Config/ACLConfig.php');

        $config['roles'] = array_unique($config['roles']);

        if (!empty($config)) {
            if (!array_key_exists('roles', $config)) {
                throw new ConfigErrorException("Config array 'ACLConfig' must contain an array 'roles'");
            }

            if (!is_array($config['roles'])) {
                throw new ConfigErrorException("Config array 'ACLConfig' must contain an array 'roles'");
            }

            if (!in_array('anonymous', $config['roles'])) {
                throw new ConfigErrorException("Config array 'ACLConfig' --> 'roles' must contain a value 'anonymous'");
            }

            if (!array_key_exists('routes', $config)) {
                throw new ConfigErrorException("Config array 'ACLConfig' must contain an array 'roles'");
            }

            if (!is_array($config['routes'])) {
                throw new ConfigErrorException("Config array 'ACLConfig' must contain an array 'roles'");
            }

            foreach ($config['routes'] as $route) {
                if (!is_array($route)) {
                    throw new ConfigErrorException("in config array 'ACLConfig' must all routes be arrays");
                }
            }

            if (!array_key_exists('login_uri', $config)) {
                throw new ConfigErrorException("Config array 'ACLConfig' must contain a element 'login_uri'");
            }

            $roles = $config['roles'];
            foreach ($config['routes'] as $route) {
                if (!in_array($route['role'], $roles)) {
                    throw new ConfigErrorException('Role "' . $route['role'] . '" is not in the array roles');
                }
            }

            Registry::set('ACLConfig', $config);
            Registry::set('ACL', new ACL());
            $_SESSION['current_role'] = 'anonymous';
        }
    }
}

