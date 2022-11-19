<?php
require 'Soldier.php';

interface SoldierFactoryInterface {
	public function createSoldier(string $class_type);
}

class SoldierFactory implements SoldierFactoryInterface {
	
	private $advantage_over_data = array();
	
	public function __construct(array $advantage_over_data)
	{
		$this->advantage_over_data = $advantage_over_data;
	}
	
	public function createSoldier(string $class_type) {
		try {
			if(isset($this->advantage_over_data[$class_type])) {
				
				$advantage = $this->advantage_over_data[$class_type];
				return new Soldier($class_type.rand(10,100), $class_type, $advantage); 
				
			} else {
				throw new Exception("The soldier class type is invalid");
			}
		} catch (Exception $e) {
			echo "Cought an Exception while creation soldiers:\n".$e;
			die();
		}
	}
}

?>
