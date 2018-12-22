<?
session_start();
$_SESSION['username']="";
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = '';
header("Location: http://$host$uri/$extra");
?>
