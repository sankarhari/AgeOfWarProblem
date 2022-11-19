<?php

class BattleSim{

    public $P1_perm = array();
    public $P1_winning_combo = array();
    public $P2_combo;
    public $adv;

    public function __construct($P2_combo, $adv)
    {
        $this->P2_combo = $P2_combo;
        $this->adv = $adv;
    }

    public function getP1Perm()
    {
        return $this->P1_perm;
    }

    public function getP1WinningPerm()
    {
        return $this->P1_winning_combo;
    }

    public function Battle($P1_combo,$P2_combo)
    {
        $win_counter = 0;
        for($i = 0; $i < sizeof($P1_combo); $i++)
        {
            // echo json_encode($P1_combo);
            $P1_adv = $this->adv[$P1_combo[$i][0]];
            $P2_adv = $this->adv[$P2_combo[$i][0]];
            $P1_count = $P1_combo[$i][1];
            $P2_count = $P2_combo[$i][1]; 

            if(in_array($P1_combo[$i][0], $P2_adv))
            {
                // echo "P1 avaialble in P2 adv multiply count by 2";
                $P2_count = $P2_count * 2;
            }
            else if(in_array($P2_combo[$i][0],$P1_adv))
            {
                // echo "P2 available in P1 adv divide count by 2";
                $P2_count = $P2_count / 2;
            }

            if($P1_count > $P2_count)
            {
                $win_counter += 1;
            }
        }

        if($win_counter > 2)
        {
            $this->P1_winning_combo[] = $P1_combo;
        }
    }

    public function pc_permute($items, $perms = array()) {
        if (empty($items)) { 
            // echo "\nSize of Perm array: ". sizeof($perms);
            echo json_encode($items);
            $this->P1_perm[] = $perms;
            $this->Battle($perms,$this->P2_combo);
            // echo "\n==================\n";
        } else {
            for ($i = count($items) - 1; $i >= 0; --$i) {
                $newitems = $items;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);
                $this->pc_permute($newitems, $newperms);
            }
        }
    }
}

$advantage_data = array(
	"Militia" => array("Spearmen","LightCavalry"),
	"Spearmen" => array("LightCavalry","HeavyCavalry"),
	"LightCavalry" => array("FootArcher","CavalryArcher"),
	"HeavyCavalry" => array("Militia","FootArcher","LightCavalry"),
	"CavalryArcher" => array("Spearmen","HeavyCavalry"),
	"FootArcher" => array("Militia","CavalryArcher")
);

$player1_input = "Spearmen#10;Militia#30;FootArcher#20;LightCavalry#1000;HeavyCavalry#120";
$player2_input = "Militia#10;Spearmen#10;FootArcher#1000;LightCavalry#120;CavalryArcher#100";

function parseInput($input)
{
    $platoon_list = array();
    foreach (explode(";",$input) as $platoon)
	{
		$each_platoon = explode("#", $platoon);
		$platoon_list[] = $each_platoon;
	}
    return $platoon_list;
}

$P1_list = parseInput($player1_input);
$P2_list = parseInput($player2_input);



$arr = $P1_list;

$Battle = new BattleSim($P2_list, $advantage_data);

$Battle->pc_permute($arr);

$all_perms = $Battle->getP1WinningPerm();

echo sizeof($all_perms);