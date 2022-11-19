<?php
require "SoldierFactory.php";

$advantage_data = array(
	"Militia" => array("Spearmen","LightCavalry"),
	"Spearmen" => array("LightCavalry","HeavyCavalry"),
	"LightCavalry" => array("FootArcher","CavalryArcher"),
	"HeavyCavalry" => array("Militia","FootArcher","LightCavalry"),
	"CavalryArcher" => array("Spearmen","HeavyCavalry"),
	"FootArcher" => array("Militia","CavalryArcher")
);

$soldier_factory = new SoldierFactory($advantage_data);
$soldier1 = $soldier_factory->createSoldier("Spearmen");
echo $soldier1->getFullDetails();


$soldier2 = $soldier_factory->createSoldier("HeavyCavalry");
echo $soldier2->getFullDetails();

$input1 = readline("Input Platoon 1 Details: ");
$input2 = readline("Input Platoon 2 Details: ");
echo $input1."\n";
echo $input2."\n";

?>

