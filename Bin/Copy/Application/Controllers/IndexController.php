<?php

namespace Application\Controllers;

use Zwaldeck\Controller\Controller;

class IndexController extends Controller {
	
	public function indexAction() {
		$this->set('title', 'Zwaldeck loves you');
		
		$response = $this->getResponse();
	}
}

?>