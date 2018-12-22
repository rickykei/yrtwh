<?php
	header('Content-Type: text/xml');
	require_once('../include/config.php');
	require_once("../include/functions.php");
	$product_id = $_GET['term'];

 
	$goods_partno=strtoupper($product_id);
    
	$db = DB::connect($dsn);
	if (DB::isError($db))
     die($db->getMessage());
	$query="SET NAMES 'UTF8'";
	$result =$db->query($query ) or die (mysql_error()."Couldn't execute query: $query");
  
    if (DB::isError($db)) die($db->getMessage());
	
	
	$query = "SELECT goods_partno as value,goods_detail as 'label',market_price as 'desc' ,readonly FROM sumgoods where goods_partno like '%$goods_partno%' and status='Y' limit 0,10";
	 
	$result =$db->query($query ) or die (mysql_error()."Couldn't execute query: $query");
  
	$return_arr = array();
 	while($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	{
       $return_arr[] =  $row;
	}
	
	   echo json_encode($return_arr);
	
 
?>