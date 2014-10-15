/*
YOU MUST COPY THIS FILE TO LIB FILE AFTER EDIT.  NEED BOTH COPIES!


*/
<?php
//This is to make sure we only define constants once!
function define_once($define, $value) {
  if (!defined((string)$define)) {
    define($define, $value);
    return true;
  }
  return false;
}

//Use seperate MCplayers page. "no" will display server users in users panel. NO UPPERCASES. No doesnt mean no.
$useplayers="yes";

//SQL info
$sqladdy="192.168.1.102";
$sqluser="sql";
$sqlpswd="sqlpimp";

//Users list
//Add your admin's to this list
$admin=array("BearFather", "ZokWobblefotz", "Omnombulist");
//Add your Moderator's to this list
$mod=array("PsychoNavigator", "elemento");
//Add your VIP's to this list
$vip=array("globalc", "CptCabey", "libelle", "PsychoSuzy", "Ninjedi", "cypher1024", "binarynomad", "drekinn", "PompadourJay", "ewe2", "idlegamer", "ninjawh0re", "zplough", "canison", "wombatunder", "sagum", "tudalu", "Lemmingski", "arradius", "Sneegerodd", "_vjay_");

//Server 1 info
//Server 2 name Initails
$Server_initails="Main";
//Public address
$serveraddy="play.superminerbros.com";
//Private address
define_once('MQ_SERVER_ADDR', 'localhost');
define_once('MQ_SERVER_PORT', 25565);

//Server 2 Info
//Server name Initails
$Server2_initails="RPG";
//Public address
$server2addy="play.superminerbros.com:23456";
//Private address
define_once('MQ_SERVER_ADDR2', '192.168.1.12');
define_once('MQ_SERVER_PORT2', 23456);

//Server 3 Info
//Server name Initails
$Server3_initails="TEK";
//Public address
$server3addy="play.superminerbros.com:25568";

//Query timeout
define_once('MQ_TIMEOUT', 3);
