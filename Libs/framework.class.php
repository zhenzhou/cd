<?php 


class framework {

	private $running;

	public function __construct($cfg=array()){

	}

	public function set_running_variable($variable,$key=''){
		if($key == ''){
			$this->running[] = $variable;
		}else{
			$this->running[$key] = $variable;
		}
	}

	public function get_running_variable(){
		return $this->running;
	}

	

}
