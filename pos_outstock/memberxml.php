<?php
	header('Content-Type: text/xml');
	require('../include/config.php');
	
	$mem_id = $_GET['mem_id'];

	 $db = DB::connect($dsn);
   if (DB::isError($db))
      die($db->getMessage());
	   $query="SET NAMES 'UTF8'";
    if (DB::isError($db)) die($db->getMessage());
	
	
	 
	//$query = "select * from member where member_id='".$_GET['mem_id']."'";
	$query = " SELECT member_id,member_add,member_name,creditLevel,(select alert from address addr where mem.member_add like concat('%',addr.address,'%') limit 0,1) alert ,remark FROM member mem WHERE mem.member_id='".$_GET['mem_id']."'  ";
	$result =$db->query($query ) or die (mysql_error()."Couldn't execute query: $query");
	
	
	
	// sum of dep amt
				$sum_dep_amt_sql="SELECT sum( deposit_amt ) as sum FROM member_deposit WHERE mem_id ='".$mem_id."' ";
				
				$sum_dep_amt_result = $db->query($sum_dep_amt_sql);
				while ( $sum_dep_amt_result_row = $sum_dep_amt_result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$sum_dep_amt=$sum_dep_amt_result_row["sum"];
				//echo $sum_dep_amt;
				}
				
				// sum of invoice amt for member used deposit saving
				$sum_inv_dep_amt_sql="SELECT sum( total_price ) as sum FROM invoice WHERE member_id ='".$mem_id."' and deposit_method='D' ";
				$sum_inv_dep_amt_result = $db->query($sum_inv_dep_amt_sql);
				while ( $sum_inv_dep_amt_result_row = $sum_inv_dep_amt_result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$sum_inv_dep_amt=$sum_inv_dep_amt_result_row["sum"];
				//echo $sum_inv_dep_amt;
				}
				
	/*echo '<?xml version="1.0" encoding="ISO-8859-1"?><product>';*/
    echo '<?xml version="1.0" encoding="utf8"?><member>';
	
	if ($num_results=$result->numRows()>0){
	for ($i=0;$i<$num_results;$i++)	{
        $row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		echo "<mem_id>" . $row['member_id'] . "</mem_id>";
		echo "<mem_name>" . $row['member_name'] . "</mem_name>";
		echo "<mem_credit_level>" . $row['creditLevel'] . "</mem_credit_level>";
		echo "<mem_add>" . $row['member_add'] . "</mem_add>";
		echo "<mem_alert>" . $row['alert'] . "</mem_alert>";
		echo "<mem_remark>" . $row['remark'] . "</mem_remark>";
		echo "<sum_dep_amt>" . $sum_dep_amt . "</sum_dep_amt>";
		echo "<sum_inv_dep_amt>" . $sum_inv_dep_amt . "</sum_inv_dep_amt>";
		echo "<mem_dep_bal>" . ($sum_dep_amt-$sum_inv_dep_amt). "</mem_dep_bal>";

	}
	}else{
		echo "<mem_id></mem_id>";
		echo "<mem_name></mem_name>";
		echo "<mem_credit_level></mem_credit_level>";
		echo "<mem_add></mem_add>";
		echo "<mem_remark></mem_remark>";
		echo "<mem_alert></mem_alert>";
		echo "<sum_dep_amt>0</sum_dep_amt>";
		echo "<sum_inv_dep_amt>0</sum_inv_dep_amt>";
		echo "<mem_dep_bal>0</mem_dep_bal>";
	}
	 
	
	echo "</member>";
?>