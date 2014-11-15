<?php 

class test_103 extends test_101{

	public function __construct(){

	}

	public function index(){

		$this->set_running_variable(array('asdf'=>'asdf12341234'),'test1');
		$this->set_running_variable(array('asdf2'=>'asdf12341234'));
		echo '1.03 test it!';

		$this->get_name();
		$this->parent_method();

	}


}
