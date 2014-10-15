<link rel="stylesheet" type="text/css" href="chat.css" />
<?php
echo str_repeat(" ", 1024), "\n";
if (isset($_GET['blah'])){sleep(5);}
require('sql.php');
$info=array("192.168.1.102","sql","sqlpimp","chat","ircnames");

function nlist($info){
	$rtn=sqlg($info,"");
	if (mysql_num_rows($rtn) != 0){
	        $a=0;
	        //sorting the info from the sql
	        while(mysql_numrows($rtn)>$a){
			$names=mysql_result($rtn,$a,"names");
		$a++;}
	}
	else{$names="";}
	$names=explode(",",$names);
	$nlist=array();
	foreach ($names as $name){
		$name=trim($name);
		if ($name == "MAIN" || $name == "ADV" || $name == "FTB" || $name =="tester"){}
		else {array_push($nlist,$name);}
	}
return $nlist;
}
$list=nlist($info);
echo "<span id=site>WebChat Users:</span><br>";
foreach ($list as $name){echo "<span id=ulist>".$name."</span><BR>";}
flush();
$run=1;
while ($run == 1){
	sleep(30);
	$newlist=nlist($info);
	if ($newlist != $list){$run=0;}
}
echo "<form name=reload method=post action=users.php>";
echo "<script language='Javascript'>document.reload.submit();</script>";
?>
