<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;

session_start();

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
define('ENV', getenv('APPLICATION_ENV'));

if (strtolower(ENV) == "development") {
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
}

use Zwaldeck\Exceptoin\Exception404;

try {
    require_once(ROOT . DS . 'Library/bootstrap.php');
} catch (InvalidArgumentException $e) {
    showError($e);
} catch (Exception404 $e) {
    showError($e);
} catch (ErrorException $e) {
    showError($e);
} catch (Exception $e) {
    showError($e);
}


function showError($e)
{
    echo "<h3>Line: {$e->getLine()}</h3>";
    echo "<h3>File: {$e->getFile()}</h3>";
    echo "<h2>Error: {$e->getMessage()}</h2>";
}


$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo 'Page generated in ' . $total_time . ' seconds.';
?>

