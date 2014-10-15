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
<?php
$stime=$_POST['time'];
$stime=intval(substr($stime,0,-3));
$ctime=time();
$ttime=$ctime+60;
echo "server time: ".$ctime."<br>";
echo "Sent time: ".$stime."<br>";
echo "t/o time: ".$ttime."<br>";
if ($stime < $ttime){echo "we are old";}
else{echo "we are current";}
?>
<form id="myform" method=post action="test.php">
<input type='hidden' name='time' id=time value='' />
<div id=blah>
<input type=button value='clickme' onClick=tsub() />
</form>
