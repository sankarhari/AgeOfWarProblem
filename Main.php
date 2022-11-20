<?php
require "Soldier.php";
require "Platoon.php";

class Main
{
	protected $advantage_data = array(
		"Militia" => array("Spearmen","LightCavalry"),
		"Spearmen" => array("LightCavalry","HeavyCavalry"),
		"LightCavalry" => array("FootArcher","CavalryArcher"),
		"HeavyCavalry" => array("Militia","FootArcher","LightCavalry"),
		"CavalryArcher" => array("Spearmen","HeavyCavalry"),
		"FootArcher" => array("Militia","CavalryArcher")
	);

	public function processInput($input): array
	{

		$platoon_list =array();

		foreach (explode(";",$input) as $platoon)
		{
			$each_platoon = explode("#", $platoon);
			$advantages = 
			$soldier = new Soldier($each_platoon[0].rand(10,100), $each_platoon[0], $this->advantage_data[$each_platoon[0]]);
			$platoon_list[] = new Platoon($soldier, $each_platoon[1]);
		}

		return $platoon_list;
	}

	public function platoonToString(array $platoons): string
	{
		$platoon_list = array();
		foreach ($platoons as $platoon)
		{ 
			$platoon_list[] = $platoon->soldier->class_type."#". $platoon->count;
		}
		return implode(";",$platoon_list);
	}
}

$player1_input = "Spearmen#10;Militia#30;FootArcher#20;LightCavalry#1000;HeavyCavalry#120";
$player2_input = "Militia#10;Spearmen#10;FootArcher#1000;LightCavalry#120;CavalryArcher#100";

$main = new Main();
$player1 = new Player("Player1", $main->processInput($player1_input));
$player2 = new Player("Player2", $main->processInput($player2_input));

$player1->startBattle($player2);

echo "Winning Sequeces:\n";
foreach ($player1->getWinningSequence(10) as $each_seq)
{
	echo $main->platoonToString($each_seq)."\n";
}
?>

