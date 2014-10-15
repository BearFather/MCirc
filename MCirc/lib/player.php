<head>
</head>
<link rel="stylesheet" type="text/css" href="chat.css" />
<?php
echo str_repeat(" ", 1024), "\n";
require('plist.php');
require('config.php');
require('MinecraftQuery.class.php');
$rtn=plist($mod,$admin,$vip);
if ($rtn != "empty"){
	echo "<center><table border=0>";
	$count=0;
	foreach ($rtn as $value){
		//echo "Name: ".$value[0]." Server: ".$value[1]." Color: ".$value[2]."<br>";
		if ($value[1]=="rpg"){echo "<td id=tdback align=center><div id=clltxt><img src='../img/r.png' width='20' height='20' alt='Admin'><br><font color=".$value[2].">".$value[0]."</div></td>";}
		elseif($value[1]=="tek"){echo "<td id=tdback align=center><div id=clltxt><img src='../img/f.png' width='20' height='20' alt='Moderator'><br><font color=".$value[2].">".$value[0]."</div></td>";}
		else{echo "<td id=tdback align=center><div id=clltxt><img src='../img/m.png' width='20' height='20' alt='Moderator'><br><font color=".$value[2].">".$value[0]."</div></td>";}
		if ($count == "6" || $count == "11" || $count == "15" || $count == "20") {echo "</tr><tr>";}
		$count++;
	}
}
else{echo "<font color=red><bold>NOBODY ONLINE</bold></font>";}
echo "</table></center></div>";

flush();
$run=1;
while ($run == 1){
        sleep(30);
        $newlist=plist($mod,$admin,$vip);
        if ($newlist != $rtn){$run=0;}
}
echo "<form name=reload method=post action=player.php>";
echo "<script language='Javascript'>document.reload.submit();</script>";

?>
