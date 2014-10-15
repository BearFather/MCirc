<body OnLoad="document.chatform.smess.focus();" text=red>
<link rel="stylesheet" type="text/css" href="chat.css" />
<?php
//dumping spaces to open up the flush buffer.
echo str_repeat(" ", 1024), "\n";
require('sql.php');
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
		if ($uid==$suid[$a] && $user==$suser[$a]){
			$euser=$seuser[$a];
			array_push($ids, $sid[$a]);
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
echo "<INPUT TYPE = Submit Name = sayit id=chatbutton VALUE ='Say it'>";
//auto send form?
if ($force == 1){echo "<script language='Javascript'>document.chatform.submit();</script>";}
echo "</form>";
}
// if this is our load from index run.
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
	$info=array("192.168.1.102","sql","sqlpimp","chat","ircweb");
	$smess=$_POST['smess'];
	$user=$_POST['user'];
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
	//if not we send it on to the channel
	else{$tgt="public";}
	// getting rid of the 's sql hates them
	$smess=ereg_replace("'","&#39;",$smess);
	$dta=array("msg","trgt","user");
	$value=array($smess,$tgt,$user);
	$howmany=3;
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
}
?>
</body>
