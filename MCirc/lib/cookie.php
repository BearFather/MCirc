<?php
$value = 'something from somewhere';
if (isset($_COOKIE["Test"])) {
echo "cookie is set";
}
else {
setcookie("Test", $value);
echo "set cookie";
}
?>
