<script src="java.js"></script>
<?php
echo "<FORM NAME =chatform METHOD =POST ACTION = test.php>";
echo "<INPUT TYPE=hidden VALUE=".time()." name=ptime>";
echo "<input type='hidden' name='time' id=time value='' />";
echo "<INPUT TYPE = Submit Name = sayit id=chatbutton VALUE ='Say it' onClick=tsub()>";
echo "</form>";

if (isset($_POST['time'])){
echo substr($_POST['time'], 0,-3)."<br>";
echo $_POST['ptime']."<br>";
}

?>
