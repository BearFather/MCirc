<head>
<META HTTP-EQUIV="refresh" CONTENT="30">
</head>
<link rel="stylesheet" type="text/css" href="chat.css" />
<?php
require('plist.php');
$rtn=plist();
echo "<center><table border=0>";
$count=0;
foreach ($rtn as $value){
//echo "Name: ".$value[0]." Server: ".$value[1]." Color: ".$value[2]."<br>";
	if ($value[1]=="rpg"){echo "<td id=tdback align=center><div id=clltxt><img src='../img/r.png' width='20' height='20' alt='Admin'><br><font color=".$value[2].">".$value[0]."</div></td>";}
	elseif($value[1]=="tek"){echo "<td id=tdback align=center><div id=clltxt><img src='../img/t.png' width='20' height='20' alt='Moderator'><br><font color=".$value[2].">".$value[0]."</div></td>";}
	else{echo "<td id=tdback align=center><div id=clltxt><img src='../img/m.png' width='20' height='20' alt='Moderator'><br><font color=".$value[2].">".$value[0]."</div></td>";}
	if ($count == "6" || $count == "11" || $count == "15" || $count == "20") {echo "</tr><tr>";}
	$count++;
}
//else{echo "<font color=red><bold>NOBODY ONLINE</bold></font>";}
echo "</table></center></div>";
?>
