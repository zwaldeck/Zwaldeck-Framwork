<?php
define('DS' ,DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

use Zwaldeck\Exceptoin\Exception404;

try {
	require_once (ROOT.DS.'library/bootstrap.php');
}catch(InvalidArgumentException $e) {
	showError($e);
}
catch(Exception404 $e) {
	showError($e);
}
catch(ErrorException $e) {
	showError($e);
}
catch (Exception $e) {
	showError($e);
}

function showError($e) {
	echo "<h3>Line: {$e->getLine()}</h3>";
	echo "<h3>File: {$e->getFile()}</h3>";
	echo "<h2>Error: {$e->getMessage()}</h2>";
}
?>
