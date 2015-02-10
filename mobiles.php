<?php

function mobileDevice()
{
$type = $_SERVER['HTTP_USER_AGENT'];
if(strpos((string)$type, "Windows Phone") != false || strpos((string)$type, "iPhone") != false || strpos((string)$type, "Android") != false)
return true;
else
return false;
}
if(mobileDevice() == true)
header('Location: login.php');

?>