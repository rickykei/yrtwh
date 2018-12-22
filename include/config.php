<?php
 
require_once('DB.php'); 
$dsn = 'mysql://root@localhost/woodwarehouse';
$db = DB::connect($dsn);
$connection = DB::connect($dsn);
if (DB::isError($connection))
 die($connection->getMessage());
$result = $connection->query("SET NAMES 'UTF8'");

$conn = mysqli_connect('localhost', 'root', '', 'woodwarehouse') or die("Connection failed: " . mysqli_connect_error());

   
 if ($_SESSION['username']==''){
 
	 $uname=$_REQUEST['username'];
	 $pass=$_REQUEST['password'];
	 $browseryrt = $_SERVER['HTTP_USER_AGENT'];
	list($LTD,$AREA,$PC) =  split("_",$browseryrt);
	$LTD=strtoupper($LTD);
	$AREA=strtoupper($AREA);
	$PC=strtoupper($PC);
 }else{
	$browseryrt = "YRT_".$AREA."_".$PC;
	$UNAME=$_SESSION['username'];
	$UROLE=$_SESSION['userrole'];
	$USER=$_SESSION['name'];
	$AREA=$_SESSION['area'];
	$PC=$_SESSION['pc'];
	$LTD=$_SESSION['ltd'];
 }
 

 
?>
