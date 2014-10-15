<body text=black>
<link rel="stylesheet" type="text/css" href="chat.css" />
<?php
require('sql.php');
require('config.php');
//pull our info from our index page.
$uid=$_GET['uid'];
$snick=$_GET['user'];
//Function to kill connection.
function killme(){
@fclose($this->server['socket']);
}
register_shutdown_function('killme');
//our class
class IRC{
var $server_host = "192.168.1.9";
var	$server_chan = "#smb";
var	$server_port = 7778;
var $nick;
    function __construct() {
        $this->nick = $_GET['user'];
    }
var $server;

function comando($cmd){
    fwrite($this->server['SOCKET'], $cmd, strlen($cmd)); //sends the command to the server
	}
//Set your nick after connection to sql
function nickset($nick,$uid,$nnck){
	$info=array("192.168.1.102","sql","sqlpimp","chat","ircuser");
	sqlu($nick,$nnck,$info);
}

function Entrar(){
$kill=0;
$connected=0;
set_time_limit(0);
 $this->server = array(); //we will use an array to store all the server data.
    //Open the socket connection to the IRC server
    $this->server['SOCKET'] = fsockopen($this->server_host, $this->server_port, $errno, $errstr, 2);
    if($this->server['SOCKET'])
    {
        //Ok, we have connected to the server, now we have to send the login commands.
        $this->Comando("PASS NOPASS\n\r"); //Sends the password not needed for most servers
          $this->Comando("NICK $this->nick\n\r"); //sends the nickname
          $this->Comando("USER $this->nick USING PHP IRC\n\r"); //sends the user must have 4 paramters
        while(!@feof($server['SOCKET'])) //while we are connected to the server
        {
//we making the socket read happen and if no input move on no waiting.
if ($connected==1){stream_set_blocking($this->server['SOCKET'], 0);$connected=2;}
            $this->server['READ_BUFFER'] = fgets($this->server['SOCKET'], 1024); //get a line of data from the server
//setting an easier variable to write
	    $out=$this->server['READ_BUFFER'];
//to catch anything we put it in here....
	  if ($out != ""){
//echo $out."<BR>";
	    if (preg_match("/.+433.+:nickname is already in use/i", $out)) {
		$nick=$this->nick;
            	$nick .= rand(0,9);
		$this->nick=$nick;
	        echo "<font color=red>Nick already in use, changing to: $nick</font><br>\n";
	      	$this->Comando("NICK :$nick\r\n");
            }
//messages coming in catcher

//Start of the catching of the name.
            $xout=explode("~",$out);
	    if (isset($xout[1])){
		$mname=substr($xout[0],1,-1);
		$xout=explode("@",$xout[1]);
		//just havent thought of what should be first in the catch so here's a dummy if clause.
		$blahblah=0;
		if ($blahblah==1){echo "haha";}
		//join messages
		elseif(preg_match("/JOIN :".$this->server_chan."/", $out)){echo "<span id=site>(WWW)</span><span id=private>[".$mname." connected]</span><br>";$this->Comando("NAMES $this->server_chan\n\r");}
		//quit messages
		elseif(preg_match("/QUIT :/", $out)){echo "<span id=site>(WWW)</span><span id=private>[".$mname." disconnected]</span><br>";$this->Comando("NAMES $this->server_chan\n\r");}
		//notice messages
		elseif (preg_match("/NOTICE/", $out)){
			$xmsg=explode("NOTICE $this->server_chan :", $out);
			echo "<span id=site>* NOTICE from <span id=site>".$mname."</span>: ".$xmsg[1]." *</span><br>";}
		//pm's from irc/web users
		elseif(preg_match("/PRIVMSG $this->nick :/", $out)){
			$xmsg=explode("PRIVMSG $this->nick :", $xout[1]);
		    	echo "<span id=private>Message from </span> <span id=serv> ".$mname.":</span> <span id=mess> ".$xmsg[1]."<br>";
		}
		//break down of normal messages
		elseif (preg_match("/PRIVMSG $this->server_chan :/", $out) && $mname != $this->nick){
			$xmsg=explode("PRIVMSG $this->server_chan :", $xout[1]);
			//actions /me blah
			if (preg_match("/ACTION/", substr($xmsg[1],1,7))){echo "<span id=private>* ".$mname.substr($xmsg[1],7)." *</span><br>";}
			//messages from mc servers
			elseif ($mname=="MAIN" || $mname=="ADV" || $mname=="FTB"){
				$xmsg[1]=trim($xmsg[1]);
				//connects and disconnects on MC server
				if (substr($xmsg[1],0,1) == "[" && substr($xmsg[1], -1) == "]"){echo "<span id=serv>(".$mname.")</span><span id=private>".$xmsg[1]."</span><BR>";}
				//actual messages from mc server
				else {
					$nmsg=explode(")", $xmsg[1]);
					$mnm=substr($nmsg[0], 1);
					echo "<span id=serv>".$mname."</span>:(<span id=author>".$mnm."</span>) <span id=mess>".$nmsg[1]."</span><br>";
				}

			}
			//messages from website
			else {echo "<span id=site>WWW</span>:(<span id=author>".$mname."</span>) ".$xmsg[1]."<BR>";}
		}
//enable this to debug unseen messages.
		else {echo $out."<BR>";}

//this is to catch !goodbye to kill the service. Good way to kill all stray connections. Add names you want to allow from
		    if (isset($xmsg[1]) && substr($xmsg[1],0,14) == "!admin goodbye"){
			if ($mname=="root" || $mname=="tester"){$this->Comando("QUIT :Pimp Out"); @fclose($this->server['SOCKET']);break;}
		    }
	    }//end of message catching

            /*
            IRC Sends a "PING" command to the client which must be anwsered with a "PONG"
            Or the client gets Disconnected
            */
            //Now lets check to see if we have joined the server
            if(strpos($this->server['READ_BUFFER'], "376")) //Mine is 376! 422 is the message number of the MOTD for the server (The last thing displayed after a successful connection)
            {
		$this->nickset($_GET['user'],$_GET['uid'],$this->nick);
                //If we have joined the server
                $this->Comando("JOIN $this->server_chan\n\r"); //Join the chanel
		if ($connected=0){echo "<span id=site>CONNECTING......</span><BR>";}
		$connected=1;
            }
            if(substr($this->server['READ_BUFFER'], 0, 6) == "PING :") //If the server has sent the ping command
            {
                $this->Comando("PONG :".substr($this->server['READ_BUFFER'], 6)."\n\r"); //Reply with pong
                //As you can see i dont have it reply with just "PONG"
                //It sends PONG and the data recived after the "PING" text on that recived line
                //Reason being is some irc servers have a "No Spoof" feature that sends a key after the PING
                //Command that must be replied with PONG and the same key sent.
            }
	    //building a users list
	    if(strpos($this->server['READ_BUFFER'], "353")){
		$names=explode("$this->nick = $this->server_chan :", $out);
		$names=str_replace("@","",$names[1]);
		$names=str_replace(" ",",",trim($names));
		$info=array("192.168.1.102","sql","sqlpimp","chat","ircnames");
		$howmany=1;
		$data="names";
		sqlu2($names,$data,1,$info);

	    }
        }
	    // check sql for messages.
	    if ($connected>=1){
		$info=array("192.168.1.102","sql","sqlpimp","chat","ircweb");
		$rtn=sqlg($info,"");
		$delete=0;
		if (mysql_num_rows($rtn) != 0){
		        $a=0;
			$rec=array();
			//sorting the info from the sql
			while(mysql_numrows($rtn)>$a){
		                $sid[$a]=mysql_result($rtn,$a,"id");
		                $suser[$a]=mysql_result($rtn,$a,"user");
		                $smsg[$a]=mysql_result($rtn,$a,"msg");
		                $strgt[$a]=mysql_result($rtn,$a,"trgt");
				 // if a public message send to channel
				if ($strgt[$a] == "public" && $suser[$a]==$this->nick){
					$this->Comando("PRIVMSG $this->server_chan :$smsg[$a]\n\r");
					echo "<span id=site>You </span>said: <span id=mess> ".$smsg[$a]."</span><BR>";
					array_push($rec, $sid[$a]);
					$delete=1;
				}
				 //are we trying to logout
				elseif ($strgt[$a] == "logout" && $suser[$a]==$this->nick){
					$this->Comando("QUIT : Pimp Out");
					@fclose($this->server['SOCKET']);
					array_push($rec, $sid[$a]);
					$delete=1;
					$kill=1;
				}
				 //getting irc server names
                                elseif($strgt[$a]=="who"){
					$this->Comando("NAMES $this->server_chan\n\r");
					array_push($rec,$sid[$a]);
					$delete=1;
				}
				 //if private send to user web and irc only.  No MC servers.
				elseif($suser[$a]==$this->nick){
					$this->Comando("PRIVMSG $strgt[$a] :$smsg[$a]\n\r");
					echo "<span id=site>You</span> told <span id=private>".$strgt[$a].":</span> <span id=mess> ".$smsg[$a]."</span><BR>";
					array_push($rec, $sid[$a]);
					$delete=1;
				}
				else {
                                 array_push($rec,$sid[$a]);
                                 $delete=1;
				}
	        	$a++;}
			$stype="multi";
			if ($delete==1){sqld($stype,$rec,$info);}
		}
	    }

	    //This flushes the output buffer forcing the text in the while loop to be displayed "On demand"
	    flush();
	    //scroll the screen
	    echo " <script language=javascript>window.scroll(0,50000);</script>";
	    //lets sleep for 2 seconds take it easy on the sql server.  If you want a fast responce you can lower this.
	    if($kill==1){echo "<script>parent.document.location.href='../loggedout.php';</script>";}
	    if($connected>=1){sleep($GLOBALS['speed']);}
        }

    }
}
}
?>
</body>
