<?php
  
$dsn = 'mysql://root@localhost/wood';

require_once 'DB.php';
 
    $db = DB::connect($dsn);
	$result=$db->query("SET NAMES 'UTF8'");
    if (DB::isError($db))
    die($db->getMessage());
 
  
 
?>
