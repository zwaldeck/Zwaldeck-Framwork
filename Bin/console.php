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
            case "db":
                $this->createDb();
                break;
            case "acl":
                $this->createAcl();
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
namespace Application\\Controllers;
use Zwaldeck\\Controller\\Controller;
				
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
namespace Application\\Models;
		
class {$modelName}

}
?>";
		fwrite($fHandle, $data);
		fclose($fHandle);
	}

    private function createDb() {

        echo "\033[1;31mWarning this will override if the database exists.\n";
        $line = readline("Do you want to continue [Y/N]\033[0m");
        while($line !='y' && $line != 'n') {
            echo "\033[1;31mWarning this will override if the database exists.\n";
            $line = readline("Do you want to continue [Y/N]\033[0m");
        }

        if(strtolower($line) == 'n') {
            echo "\nDid nothing\n";
            exit;
        }

        $host = readline("\033[32mHost: \033[0m");
        $user = readline("\033[32mDatabase user: \033[0m");
        $pass = readline("\033[32mDatabase user password: \033[0m");
        $dbname = readline("\033[32mDatabase name: \033[0m");

        if (!defined('PDO::ATTR_DRIVER_NAME')) {
            die ("\033[31mPDO unavailable\033[0m");
        }

        try {
            $dbh = new PDO("mysql:host=$host", $user, $pass);
            echo "\n\nDropping database\n";
            $dbh->exec("DROP DATABASE IF EXISTS `$dbname`;");

            echo "\n\nCreating database\n";
            $dbh->exec("CREATE DATABASE `$dbname`;
                CREATE USER '$user'@'localhost' IDENTIFIED BY '$pass';
                GRANT ALL ON `$dbname`.* TO '$user'@'localhost';
                FLUSH PRIVILEGES;")
            or die(print_r($dbh->errorInfo(), true));

            echo "\nDatabase Created\n\n";
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function createAcl() {
        $host = readline("\033[32mHost: \033[0m");
        $user = readline("\033[32mDatabase user: \033[0m");
        $pass = readline("\033[32mDatabase user password: \033[0m");
        $dbname = readline("\033[32mDatabase name: \033[0m");

        try {
            $db = new PDO("mysql:dbname={$dbname};host={$host}", $user, $pass);
            $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );//Error Handling
            $sql ="CREATE table users_role(
                     id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                     user_id VARCHAR( 50 ) NOT NULL,
                     role VARCHAR( 250 ) NOT NULL);" ;
            $db->exec($sql);

            print("Created users_role Table.\n");

        } catch(PDOException $e) {
            echo $e->getMessage();//Remove in production code
        }
    }


}

//the entry point
new Console();