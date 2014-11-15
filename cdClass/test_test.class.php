<?php 

require(BASE_PATH.DR.'test.class.php');

class test_test extends test{
	
	public function __construct(){

	}

	public function index(){

		parent::index();

		$running = $this->get_running_variable();
		printr($running);

		_echo('test_test class');

	}

}
