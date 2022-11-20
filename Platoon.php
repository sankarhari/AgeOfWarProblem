<?php

enum Battle_Result {
    case WIN;
    case LOST;
    case DRAW;
}

class Platoon {

    public $soldier;
    public $count;

    public function __construct(Soldier $soldier, int $count) {
        $this->soldier = $soldier;
        $this->count = $count;
    }

    public function battle(Platoon $player2_seq): Battle_Result
    {
        $P1_adv = $this->soldier->advantage_over;
        $P2_adv = $player2_seq->soldier->advantage_over;
        $P1_count = $this->count;
        $P2_count = $player2_seq->count; 

        if(in_array($this->soldier->class_type, $P2_adv)) {
            $P2_count = $P2_count * 2;
        }
        else if(in_array($player2_seq->soldier->class_type,$P1_adv)) {
            $P2_count = $P2_count / 2;
        }

        if($P1_count > $P2_count) {
            return Battle_Result::WIN;
        }
        else if ($P1_count < $P2_count) {
            return Battle_Result::LOST;
        }
        else {
            return Battle_Result::DRAW;
        }
    }
}

class Player {
    
    public $name;
    public $platoon_list = array();
	public $all_sequence = array();
	public $winning_sequence = array();

    public function __construct(string $name, array $platoon_list)
    {
        $this->name = $name;
        $this->platoon_list = $platoon_list;
    }   
    
    public function getWinningSequence(int $count)
    {
        $winning_seq = array();
        for($i = 0; $i < $count; $i++)
        {
            $winning_seq[] = $this->winning_sequence[$i];
        }
        return $winning_seq;
    }
	
	public function startBattle(Player $player2)
	{
		$this->all_sequence = array();
		$this->generateAllSequenceList($this->platoon_list);
        foreach($this->all_sequence as $player1_seq)
        {
            $this->filterWinningSequence($player1_seq, $player2->platoon_list);
        }
	}
	
    public function filterWinningSequence($player1_seq,$player2_seq)
    {
        $win_counter = 0;
        for($i = 0; $i < sizeof($player1_seq); $i++)
        {          

            // print_r($player1_seq[$i]);
            $battle_result = $player1_seq[$i]->battle($player2_seq[$i]);

            if($battle_result == Battle_Result::WIN)
            {
                $win_counter += 1;
            }
            // break;
        }

        if($win_counter > 2)
        {
            $this->winning_sequence[] = $player1_seq;
        }
    }
    
	public function generateAllSequenceList($platoons,$perms = array())
	{
		//Using Backtracking approch to for generate list of all permutations of given input array
		if (empty($platoons)) { 
			$this->all_sequence[] = $perms;
        } else {
            for ($i = count($platoons) - 1; $i >= 0; --$i) {
                $newitems = $platoons;
                $newperms = $perms;
                list($foo) = array_splice($newitems, $i, 1);
                array_unshift($newperms, $foo);
                $this->generateAllSequenceList($newitems, $newperms);
            }
        }
	}
	
	
}