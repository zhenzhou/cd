<?php 

class test extends framework{

	public function __construct(){

	}

	public function index(){

		$this->set_running_variable(array('asdf'=>'asdf12341234'),'test1');
		$this->set_running_variable(array('asdf2'=>'asdf12341234'));
		echo 'test it!';

	}

	public function parent_method(){
		echo 'invoke parent method';
	}

}
