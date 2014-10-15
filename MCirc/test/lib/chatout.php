<body text=white>
</body>
<?php
//just loading up or class, nothing else here.  See irc.class.php for the good stuff.
require('irc.class.php');
$bot = new irc();
$bot->entrar();
?>
