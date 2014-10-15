<?php session_start(); ?>
<html>
<body id="body">
<?php
//Set your user tag here..I use php digest.
require('lib/sql.php');
$user = $_SERVER['PHP_AUTH_USER'];
$uid=rand(11,99).rand(11,99);
$euser="none";
$info=array("192.168.1.102","sql","sqlpimp","chat","ircuser");
$value=array($uid,$user,$euser);
$howmany=3;
$data=array("uid","user","euser");
sqlw($howmany,$value,$info,$data);

print("<link rel=stylesheet type=text/css href=lib/chat.css />");
print("<Center><h1>SMB Web Chat</h1></center>");
print("<iframe id=users src='lib/users.php?blah=blah' width=120 height=200 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no></iframe>");
print("<iframe id=chat src='lib/chatout.php?user=".$user."&uid=".$uid."' width=620 height=425 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=auto><br></iframe>");
print("<iframe id=input src='lib/chatin.php?user=".$user."&uid=".$uid."' width=620 height=30 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no></iframe>");
print("<iframe id=players src=lib/player.php width=800 height=345 marginwidth=0 marginheight=0 hspace=0 vspace=0 frameborder=0 scrolling=no></iframe>");
print("</html>");
?>
