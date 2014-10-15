<meta http-equiv="refresh" content="30" url="users.php">
<link rel="stylesheet" type="text/css" href="chat.css" />
<?php
if (isset($_GET['blah'])){sleep(5);}
require('sql.php');
$info=array("192.168.1.102","sql","sqlpimp","chat","ircnames");
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
$nlist="";
echo "<span id=site>WebChat Users:</span><br>";
foreach ($names as $name){echo "<span id=ulist>".$name."</span><BR>";}
?>
