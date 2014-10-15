<?php

//$rtn=plist();
//foreach ($rtn as $value){echo "Name: ".$value[0]." Server: ".$value[1]." Color: ".$value[2]."<br>";}

function plist(){
require('config.php');
require('MinecraftQuery.class.php');
$players=array();
$query1 = new MinecraftQuery();
try {
        $query1->Connect(MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT);
} catch (MinecraftQueryException $e) {
        $error = $e->getMessage();
}
$query2 = new MinecraftQuery();
try {
        $query2->Connect("192.168.1.12", "23456", MQ_TIMEOUT);
} catch (MinecraftQueryException $e) {
        $error1 = $e->getMessage();
}
$query3 = new MinecraftQuery();
try {
	$address="192.168.1.6";
        $port="25568";
        $query3->Connect($address, $port, MQ_TIMEOUT);
} catch (MinecraftQueryException $e) {
        $error2 = $e->getMessage();
}
//echo "<center></br><font color=red>Players Online:</font></br>";
$players3=$query3->GetPlayers();
$players2=$query1->GetPlayers();
$players1=$query2->GetPlayers();
if ($players2 != ""){
	foreach ($players2 as $play){
		$play1=array($play,"main");
		array_push($players, $play1);
	}
}
if ($players1 != ""){
	foreach ($players1 as $play){
		$play1=array($play,"rpg");
		array_push($players, $play1);
	}
}
if ($players3 != ""){
        foreach ($players3 as $play){
		$play1=array($play,"tek");
                array_push($players, $play1);
        }
}
if ($players1 != "" or $players2 != "" or $players3 != ""){
// Enter names below of Your admins, moderator, and VIP's.
	$plst=array();
        foreach ($players as $value) {
		$pclr="yellow";
                foreach ($admin as $chk1){if ($value[0] == $chk1){$pclr="purple";}}
                foreach ($mod as $chk2){if ($value[0] == $chk2){$pclr="red";}}
                foreach ($vip as $chk3){if ($value[0] == $chk3){$pclr="blue";}}
		array_push($value, $pclr);
		array_push($plst, $value);
        }
	return $plst;
}
else{echo "<font color=red><bold>NOBODY ONLINE</bold></font>";}
}
?>
