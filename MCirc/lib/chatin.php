<script type="text/javascript">
function tsub(){
        var element=document.getElementById('myform');
        var element2=document.getElementById('time');
        var t= new Date();
        var x=t.getTime();
        element2.value = x;
        element.submit();
}
</script>
<body OnLoad="document.chatform.smess.focus();" text=red>
<link rel="stylesheet" type="text/css" href="chat.css" />
<?php
//dumping spaces to open up the flush buffer.
echo str_repeat(" ", 1024), "\n";
require('sql.php');
// !!!Start of functions.
//function to check for a nick from the server.
function nickcheck($uid,$user) {
	$euser="none";
	$ids=array();
 	$info=array("192.168.1.102","sql","sqlpimp","chat","ircuser");
	$where="where user='".$user."'";
        $rtn=sqlg($info,$where);
	if (mysql_num_rows($rtn)>0){
	$a=0;
	while(mysql_numrows($rtn)>$a){
                $suser[$a]=mysql_result($rtn,$a,"user");
                $suid[$a]=mysql_result($rtn,$a,"uid");
                $seuser[$a]=mysql_result($rtn,$a,"euser");
                $sid[$a]=mysql_result($rtn,$a,"id");
		//see if the sql info is for us
		array_push($ids, $sid[$a]);
		if ($uid==$suid[$a] && $user==$suser[$a]){
			$euser=$seuser[$a];
		}
		//check if the we got the final nick yet. if we did delete the sql records
		if ($euser != "none"){
			$info=array("192.168.1.102","sql","sqlpimp","chat","ircuser");
			$rec=$ids;
			$stype="idv";
			sqld($stype,$rec,$info);
		}
		// send back out nick.
		return $euser;
	$a++;}
	}
	// if nick in the db it fails and dies.
	return "SQL ISSUES";
}
//function to display our chat input
function formit($user,$force){
echo "<FORM NAME =chatform METHOD =POST ACTION = chatin.php>";
echo "<INPUT TYPE=hidden VALUE=".$user." name=user>";
echo "<INPUT TYPE=TEXT VALUE='' name=smess size=85>";
echo "<input type='hidden' name='time' id=time value='' />";
echo "<INPUT TYPE = Submit Name = sayit id=chatbutton VALUE ='Say it' onClick=tsub()>";
//auto send form?
if ($force == 1){echo "<script language='Javascript'>tsub();</script>";}
//document.chatform.submit();</script>";}
echo "</form>";
}
// End of Functions!!!
// if this is our loading up action.
if (isset($_GET['user'])){
	flush();
	$euser="none";
	$user=$_GET['user'];
	$uid=$_GET['uid'];
	//run while we have no nick from sql
	while ($euser=="none"){
		$euser=nickcheck($uid,$user);
		echo "<span id=site>LOADING NICK.....</span><BR>";
		flush();
		echo " <script language=javascript>window.scroll(0,50000);</script>";
		sleep(1);
	}
	// this is where we go to die if we had sql issues
	if ($euser=="SQL ISSUES"){break;}
	else{formit($euser,1);}
}
//if message was sent and has a message.
elseif (isset($_POST['user']) && $_POST['smess'] != "") {
	$user=$_POST['user'];
	$stime=$_POST['time'];
	$stime=intval(substr($stime,0,-3));
	$info=array("192.168.1.102","sql","sqlpimp","chat","ircweb");
	$smess=$_POST['smess'];
	// checking to see if it's a pm.
	$xmsg=explode(" ",$smess);
	if ($xmsg[0] =="/msg"){
		$tgt=$xmsg[1];
		$xmsg=explode($tgt, $smess);
		$smess=$xmsg[1];
	}
	if ($xmsg[0]=="/who"){
	$smess="/who";
	$tgt="who";
	}
	elseif ($xmsg[0]=="/quit"){
	$tgt="logout";
	}
	//if not we send it on to the channel
	else{$tgt="public";}
	// getting rid of the 's sql hates them
	$smess=ereg_replace("'","",$smess);
	$dta=array("msg","trgt","user","time");
	$value=array($smess,$tgt,$user,$stime);
	$howmany=4;
	//sending message to sql
	sqlw($howmany,$value,$info,$dta);
	formit($user,0);
}
//if the button was pressed and no message redisplay the form.
elseif (isset($_POST['user'])){
	formit($_POST['user'],0);
}
else{
//if you see this something is wrong.
echo "umm you messed up!";
var_dump($_POST);
}
?>
</body>
