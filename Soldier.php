<?php

interface ISoldier {
	public function setName(string $soldier_name);
	public function setClassType(string $soldier_type);
	public function setAdvantageOver(array $advantage_over);
	public function getFullDetails(): string;
}

class Soldier implements ISoldier
{
    public $name;
    public $class_type;
    public $advantage_over;

    function __construct($name, $class_type, array $advantage_over)
    {
        $this->name = $name;
        $this->class_type = $class_type;
        $this->advantage_over = $advantage_over;
    }
	
	public function setName(string $name)
	{
		$this->name = $name;
	}
	
	public function setClassType(string $class_type)
	{
		$this->class_type = $class_type;
	}
	
	public function setAdvantageOver(array $advantage_over)
	{
		$this->advantage_over = $advantage_over;
	}
	
	public function getFullDetails(): string
	{
		return "\n\nName: ".$this->name."\nType: ".$this->class_type."\nAdvantage Over: ".json_encode($this->advantage_over);
	}
}

?>