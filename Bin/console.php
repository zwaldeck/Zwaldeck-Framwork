<?php
class Console {
	
	/**
	 * @var string
	 */
	private $create;
	
	/**
	 * @var string
	 */
	private $createType;
	
	/**
	 * @var array
	 */
	private $options;
	
	private $scriptPath;
	
	public function __construct() {
		
		$this->scriptPath = (dirname(__FILE__));
		
		array_shift($_SERVER['argv']);
		$this->create = array_shift($_SERVER['argv']);
		$this->createType = array_shift($_SERVER['argv']);
		$this->options = $_SERVER['argv'];
		
		$this->checkType();
		
	}
	
	private function checkType() {
		if(strtolower($this->create) != 'create') {
			throw new Exception("Cannot find the command {$this->create}");
		}
		
		switch (strtolower($this->createType)) {
			case "project":
				$this->createProject();
				break;
			case "controller":
				$this->createController();
				break;
			case "action":
				$this->createAction();
				break;
			case "model":
				$this->createModel();
				break;
			default:
				throw new Exception("Cannot find command {$this->create} {$this->createType}");
		}
	}
	
	/**
	 * usage = php /path/to/console.php create project {projectname}
	 */
	private function createProject() {
		$root = $this->options[0];
		$ds = DIRECTORY_SEPARATOR;
		
		mkdir($this->options[0]);
		
		//aplication folder
		mkdir($root.$ds.'Application', 777);
		mkdir($root.$ds.'Application'.$ds.'Controllers', 777);
		mkdir($root.$ds.'Application'.$ds.'Models', 777);
		mkdir($root.$ds.'Application'.$ds.'Views', 777);
		mkdir($root.$ds.'Application'.$ds.'Views'.$ds.'index', 777);
		copy($this->scriptPath.$ds.'Copy'.$ds.'Application'.$ds.'Views'.$ds.'index'.$ds.'index.phtml', $root.$ds.'Application'.$ds.'Views'.$ds.'index'.$ds.'index.phtml');
		copy($this->scriptPath.$ds.'Copy'.$ds.'Application'.$ds.'Views'.$ds.'layout.php', $root.$ds.'Application'.$ds.'Views'.$ds.'layout.php');
		copy($this->scriptPath.$ds.'Copy'.$ds.'Application'.$ds.'Controllers'.$ds.'IndexController.php', $root.$ds.'Application'.$ds.'Controllers'.$ds.'IndexController.php');
		
		//config
		mkdir($root.$ds.'Config', 777);
		copy($this->scriptPath.$ds.'Copy'.$ds.'Config'.$ds.'config.php', $root.$ds.'Config'.$ds.'config.php');
		
		//make Lib
		mkdir($root.$ds.'Library', 777);
		
		//public
		mkdir($root.$ds.'public', 777);
		mkdir($root.$ds.'public'.$ds.'css', 777);
		mkdir($root.$ds.'public'.$ds.'js', 777);
		mkdir($root.$ds.'public'.$ds.'img', 777);
		copy($this->scriptPath.$ds.'Copy'.$ds.'public'.$ds.'.htaccess', $root.$ds.'public'.$ds.'.htaccess');
		copy($this->scriptPath.$ds.'Copy'.$ds.'public'.$ds.'index.php', $root.$ds.'public'.$ds.'index.php');
		
		//base dir
		copy($this->scriptPath.$ds.'Copy'.$ds.'.htaccess', $root.$ds.'.htaccess');
		copy($this->scriptPath.$ds.'Copy'.$ds.'CodeConventions.txt', $root.$ds.'CodeConventions.txt');
		copy($this->scriptPath.$ds.'Copy'.$ds.'LICENSE.txt', $root.$ds.'LICENSE.txt');
		
		
		echo "\n\nDont forget to replace the Library folder with the Library downloaded from the site\n\n";
		
	}
	
	/**
	 * you need to be insde the project root folder
	 * 
	 * usage = php /path/to/console.php create controller {controllername}
	 */
	private function createController() {
		$ds = DIRECTORY_SEPARATOR;
		
		$controllerName = $this->options[0];
		$controllerName = ucfirst(strtolower($controllerName)).'Controller';
		$fHandle = fopen('Application'.$ds.'Controllers'.$ds.$controllerName.'.php', 'w');
		$data = "<?php
namespace Application\Controllers;
use Zwaldeck\Controller\Controller;
				
class {$controllerName} extends Controller 
				
	public function indexAction() {
		//TO-DO fill this index action
	}
}
?>";
		
		fwrite($fHandle, $data);
		fclose($fHandle);
	}
	
	/**
	 * you need to be insde the project root folder
	 *
	 * usage = php /path/to/console.php create action {controllername} {actionname}
	 */
	private function createAction() {
		echo "\n\n This is not implemented yet";
	}
	
	/**
	 * you need to be insde the project root folder
	 *
	 * usage = php /path/to/console.php create model {modelname}
	 */
	private function createModel() {
		$ds = DIRECTORY_SEPARATOR;
		
		$modelName = $this->options[0];
		$modelName = ucfirst(strtolower($modelName));
		$fHandle = fopen('Application'.$ds.'Models'.$ds.$modelName.'.php', 'w');
		$data = "<?php
namespace Application\Models;
		
class {$modelName}

}
?>";
		fwrite($fHandle, $data);
		fclose($fHandle);
	}
}

//the entry point
new Console();