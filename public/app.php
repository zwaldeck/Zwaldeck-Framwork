<?php
define('ENV', 'development');
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

if (strtolower(ENV) == "development") {
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $start = $time;
}

session_start();
if (strtolower(ENV) == "development") {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
}

use Zwaldeck\Exception\Exception404;

try {
    require_once(ROOT . DS . 'Library/Zwaldeck/Bootstrap.php');
    new Zwaldeck\Bootstrap();
} catch (InvalidArgumentException $e) {
    showError($e);
} catch (Exception404 $e) {
    showError($e);
} catch (ErrorException $e) {
    showError($e);
} catch (Exception $e) {
    showError($e);
}


function showError(Exception $e)
{
    echo "<h3>Line: {$e->getLine()}</h3>";
    echo "<h3>File: {$e->getFile()}</h3>";
    echo "<h2>Error: {$e->getMessage()}</h2>";
    if(strtolower(ENV) == "development") {
        echo "<h2>StackTrace</h2>";
        var_dump($e->getTrace());
    }
}


if (strtolower(ENV) == "development") {
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $finish = $time;
    $total_time = round(($finish - $start), 4);


    echo 'Page generated in ' . $total_time . ' seconds.';
    echo '<h5>Memory usage</h5><ul>';
    echo '<li>'.number_format(memory_get_usage(true) / 1048576, 2) . ' MB'.'</li>';
    echo '</ul>';
}