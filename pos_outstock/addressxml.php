<?php
	header('Content-Type: text/xml');
	require('../include/config.php');
	
	$mem_add = $_GET['mem_add'];

	 
	 $db = DB::connect($dsn);
   if (DB::isError($db))
      die($db->getMessage());
	   $query="SET NAMES 'UTF8'";
    if (DB::isError($db)) die($db->getMessage());
	
	$result =$db->query($query ) or die (mysql_error()."Couldn't execute query: $query");
	 
	$query = "select alert from address where '$mem_add' like CONCAT('%', address, '%') and alert !='' limit 0,1";
 
	
 	$result =$db->query($query ) or die (mysql_error()."Couldn't execute query: $query");
	
 
    echo '<?xml version="1.0" encoding="utf8"?><address>';
	
	$num_results=$result->numRows();
	for ($i=0;$i<$num_results;$i++)
	{
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		echo "<address_mem_add>" . $mem_add . "</address_mem_add>";
		echo "<address_alert>" . htmlspecialchars($row['alert']) . "</address_alert>";
 

	}
	
	 
	
	echo "</address>";
?>