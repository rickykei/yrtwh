<?php


function correct_delTimeSlot_to_delDate($delivery_date,$delivery_timeslot){
	
	if($delivery_timeslot==1){
		$delivery_date= date('Y-m-d 08:01',strtotime($delivery_date));
	}else if($delivery_timeslot==2){
		$delivery_date=date('Y-m-d 11:01',strtotime($delivery_date));
	}else if($delivery_timeslot==3){
		$delivery_date=date('Y-m-d 14:01',strtotime($delivery_date));
	}
	
	return $delivery_date;
}
function choose_timeslot(){
	$i=0;
	if (date('H')>=8 && date('H')<11)
		$i=1;
	else if (date('H')>=11 && date('H')<14)
		$i=2;
	else if (date('H')>=14 && date('H')<18)
		$i=3;
	else
		$i=4;
 
		return $i;
}
function print_del_date_by_timeslot(){
	
	if (date('H')>=8 && date('H')<11)
			echo Date("Y-m-d 08:01");
	else if (date('H')>=11 && date('H')<14)
		echo Date("Y-m-d 11:01");
	else if (date('H')>=14 && date('H')<18)
		echo Date("Y-m-d 14:01");
	else
		echo date('Y-m-d 08:01',strtotime(date("Y-m-d") . "+1 days"));
}
function add_del_time_SQL($invoicesql){
	
	//count qty til to current timeslot end by delivery date
	$datestr="";
 
	if (date('H')>=8 && date('H')<11)
		$datestr= Date("Y-m-d 11:00");
	else if (date('H')>=11 && date('H')<14)
		$datestr=date("Y-m-d 14:00");
	else if (date('H')>=15 && date('H')<18)
		$datestr=Date("Y-m-d 18:00");
	else
		$datestr=date('Y-m-d 11:00',strtotime(date("Y-m-d") . "+1 days"));
	
	$invoicesql=$invoicesql." and delivery_date <='$datestr'";
	return $invoicesql;
}

function add_del_time_SQL_by($invoicesql,$timeSlot,$year,$month,$day){
	$datestr=$year."-".$month."-".$day;
 
	if ($timeSlot==1)
		$datestr= Date("Y-m-d 11:00",strtotime($datestr));
	else if ($timeSlot==2)
		$datestr=date("Y-m-d 14:00",strtotime($datestr));
	else if ($timeSlot==3)
		$datestr=Date("Y-m-d 18:00",strtotime($datestr));
	 
	$invoicesql=$invoicesql." and delivery_date <='$datestr'";
	
	return $invoicesql;
}

function sqllog($sql)
{
	include("./include/config.php");
    $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

		$sql2 = str_replace("'", "''", "$sql");
		$username = $_SESSION[user_name];
		$ip_addr = $_SERVER['REMOTE_ADDR'];
		$page = $_SERVER['PHP_SELF'];
		$log_sql = "INSERT INTO sql_log SET
					ip_addr = '$ip_addr',
					area = '$AREA',
					pc = '$PC',
					username = '$username',
					page = '$page',
					sql_stmt = '$sql2'";
	 	$result=$connection->query($log_sql);
	  if (DB::isError($result))
    	  die ($result->getMessage());
	
}

function chkUserName($dsn,$area,$pc)
{
	 
    $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);
	   if (DB::isError($connection))
      die($connection->getMessage());
	$sql=" SELECT name FROM  `staff`  WHERE pc =  '".$pc."' AND area =  '".$area."' ";
	$result=$connection->query($sql);
	if (DB::isError($result))
    	  die ($result->getMessage());
    $row=$result->fetchRow(DB_FETCHMODE_ASSOC);
    return $row["name"];
}


function findBalFromPartNo($goods_partno,$isPredict,$year,$month,$day,$dsn)
{
	
	 
	 $db = DB::connect($dsn);
   if (DB::isError($db))
      die($db->getMessage());
	   $query="SET NAMES 'UTF8'";
    if (DB::isError($db)) die($db->getMessage());
	
	 
	 
	$query = "SELECT * FROM sumgoods where goods_partno = '$goods_partno' and status='Y'";
	 
	$result =$db->query($query ) or die (mysql_error()."Couldn't execute query: $query");
	$num_results=$result->numRows();
	$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
	
	// 20160315 Add bundle items code
	 
		//search stock bal  signle item Logic 2016
		 $invoiceSql="select ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where deductstock='Y' and  i.invoice_no=gi.invoice_no and goods_partno = '$goods_partno' and delivery!='W' ";
		 
		 if($isPredict<=0)
		 $invoiceSql=add_del_time_SQL($invoiceSql);
			else
		 $invoiceSql=add_del_time_SQL_by($invoiceSql,$isPredict,$year,$month,$day);
		 
		  
		 $inshopSql="select ifnull(sum(qty),0) as qty from inshop i , goods_inshop gi where deductstock='Y' and i.inshop_no=gi.inshop_no and goods_partno = '$goods_partno'";
		 
		 $scrapSql= "select ifnull(sum(qty),0) as qty from goods_scrap gs, scrap s where s.invoice_no=gs.invoice_no and goods_partno = '$goods_partno' ";
		
		 if($isPredict<=0)
		 $scrapSql=add_del_time_SQL($scrapSql);
			else
		 $scrapSql=add_del_time_SQL_by($scrapSql,$isPredict,$year,$month,$day);
	 
		 
		 echo $invoiceSql;
		 $result2 = $db->query($invoiceSql);
		 while(  $row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		  $invoiceQty=$row2['qty'];
		 }
		 $result2 = $db->query($inshopSql);
		 while(  $row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		  $inshopQty=$row2['qty'];
		 }
		  $result2 = $db->query($scrapSql);
		 while(  $row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		  $scrapQty=$row2['qty'];
		 }
		 
		 $stockbal=$inshopQty-$invoiceQty-$scrapQty;
		 
	 
	//echo $stockbal;
	
	$prodresult['stockbal']=$stockbal;
	$prodresult['scrapQty']=$scrapQty;
	$prodresult['invoiceQty']=$invoiceQty;
	$prodresult['inshopQty']=$inshopQty;
	$prodresult['slaveBalQty']=$slaveBalQty;
	 
	return $prodresult;
}


function predictSpecifyDate($day,$month,$year,$modelSelectR,$pre3Days=0,$tmps_exclude_item_for_3days){
	
	 
	include("./include/config.php");
	 $db = DB::connect($dsn);
   if (DB::isError($db))
      die($db->getMessage());
	   $query="SET NAMES 'UTF8'";
    if (DB::isError($db)) die($db->getMessage());
	
	
	$inDateStrStart=$year.'-'.$month.'-'.$day.' 00:01';
	$inDateStrEnd=$year.'-'.$month.'-'.$day.' 23:59';
	$inDateStrStart_3DayAgo=  date('Y-m-d H:i',strtotime($inDateStrStart . ' -3 day'));
	//echo $inDateStrStart;
	//echo $inDateStrStart_3DayAgo;
	
	for ($j=1;$j<4;$j++){
	//search tomorrow invoice items
	if ($modelSelectR=="NULL"){
		$invoice="select distinct goods_partno from invoice, goods_invoice where deductstock='Y' and invoice.invoice_no=goods_invoice.invoice_no and invoice.delivery_timeslot=$j  and delivery!='W' ";
		$scrap="select distinct goods_partno from scrap, goods_scrap where deductstock='Y' and scrap.invoice_no=goods_scrap.invoice_no and scrap.delivery_timeslot=$j ";
	}
	else{
		
		$invoice="select distinct sumgoods.goods_partno from invoice, goods_invoice,sumgoods where deductstock='Y' and invoice.invoice_no=goods_invoice.invoice_no and invoice.delivery_timeslot=$j and sumgoods.goods_partno=goods_invoice.goods_partno and sumgoods.model='$modelSelectR'  and delivery!='W' "; 
		$scrap="select distinct sumgoods.goods_partno from scrap, goods_scrap,sumgoods where deductstock='Y' and scrap.invoice_no=goods_scrap.invoice_no and scrap.delivery_timeslot=$j and sumgoods.goods_partno=goods_scrap.goods_partno and sumgoods.model='$modelSelectR' "; 
	}
	
	
	
		if ($pre3Days==0){
			//$invoice=$invoice." and month(invoice.delivery_date)=$month && year(invoice.delivery_date)=$year && DAYOFMONTH(invoice.delivery_date)=$day ";
			//$scrap=$scrap." and month(scrap.delivery_date)=$month && year(scrap.delivery_date)=$year && DAYOFMONTH(scrap.delivery_date)=$day ";
			$invoice=$invoice." and invoice.delivery_date >='$inDateStrStart' and invoice.delivery_date<='$inDateStrEnd' ";
			$scrap=$scrap." and scrap.delivery_date>='$inDateStrStart' and scrap.delivery_date <='$inDateStrEnd' ";
		}else{
			$invoice=$invoice." and invoice.delivery_date >='$inDateStrStart_3DayAgo' and invoice.delivery_date<='$inDateStrStart' ";
			if ($tmps_exclude_item_for_3days!="")
				$invoice=$invoice." and goods_invoice.goods_partno not in (".$tmps_exclude_item_for_3days.")";
			
			$scrap=$scrap." and scrap.delivery_date>='$inDateStrStart_3DayAgo' and scrap.delivery_date <='$inDateStrStart' ";
		}
		  
		/*
		if ($j==1){
	}else if ($j==2){

		$invoice=$invoice." and month(invoice.delivery_date)=$month && year(invoice.delivery_date)=$year && DAYOFMONTH(invoice.delivery_date)=$day ";
		$scrap=$scrap." and month(scrap.delivery_date)=$month && year(scrap.delivery_date)=$year && DAYOFMONTH(scrap.delivery_date)=$day ";
	}elseif ($j==3){

		$invoice=$invoice." and month(invoice.delivery_date)=$month && year(invoice.delivery_date)=$year && DAYOFMONTH(invoice.delivery_date)=$day ";
		$scrap=$scrap." and month(scrap.delivery_date)=$month && year(scrap.delivery_date)=$year && DAYOFMONTH(scrap.delivery_date)=$day ";
	}*/
	
 
 
	$invoice=$invoice." union ".$scrap;
	
	 
	$invoiceresult = $db->query($invoice);
	

	$i=0;
		while($row=$invoiceresult->fetchRow(DB_FETCHMODE_ASSOC)){
			 
	   $partno=$row['goods_partno'];
	   $invoiceItem[$j][$i]['goods_partno']=$partno;
	   
	   
	   //echo "<p>".$j."-".$partno."<p>";
	   $tmp=findBalFromPartNo($partno,$j,$year,$month,$day,$dsn);
	   //print_r($tmp);
	   //echo "<p>";
	   
	   // $invoiceItem[$j][$i]['qty']=$row['qty'];
	  
	  
	  $invoiceItem[$j][$i]['out']=$tmp['invoiceQty'];
	  
	  if ($tmp['invoiceQty']==0){
			  //find invoice qty
			  //$invoiceSql="select  ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where  deductstock='Y' and i.invoice_no=gi.invoice_no and goods_partno ='".$partno."' and i.delivery_timeslot=$j  ";
			 $invoiceSql="select  ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where  deductstock='Y' and i.invoice_no=gi.invoice_no and goods_partno ='".$partno."'   and delivery!='W' ";
			  $invoiceSql=add_del_time_SQL_by($invoiceSql,$j,$year,$month,$day);
			 //echo $invoiceSql;  
			 
			 $result2 = $db->query($invoiceSql);
			 while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC)){
				$invoiceItem[$j][$i]['out']=$row2['qty'];
			 }
	  }
			
			
			/*
			//find scrap qty
			 $invoiceSql="select  ifnull(sum(qty),0) as qty from scrap i , goods_scrap gi where   i.invoice_no=gi.invoice_no and goods_partno ='".$partno."'   ";
			 
			 //add time control for scrap 20160117
			 $invoiceSql=add_del_time_SQL_by($invoiceSql,$j,$year,$month,$day);
			  
			  
			  //echo "<p>".$invoiceSql;
			  
			$result2 = $db->query($invoiceSql);
			 while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC)){
				$invoiceItem[$j][$i]['scrap']=$row2['qty'];
			 }
			*/
			$invoiceItem[$j][$i]['scrap']=$tmp['scrapQty'];
				
			/*	
			//find inshop qty
			  //find invoice qty
			 $inshopSql="select  ifnull(sum(qty),0) as qty from inshop i , goods_inshop gi where deductstock='Y' and i.inshop_no=gi.inshop_no and goods_partno ='".$partno."'";
			  
			 $result2 = $db->query($inshopSql);
			 while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC)){
			 $invoiceItem[$j][$i]['in']=$row2['qty'];
			 }
			*/
			 $invoiceItem[$j][$i]['in']=$tmp['inshopQty'];
			
			//find quota
			$sumgoodSql="select ifnull(inshop_quota,0) as quota ,inshop_box as box ,model,goods_detail from sumgoods i  where  goods_partno ='".$partno."'";
			$result2 = $db->query($sumgoodSql);
			while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC)){
				$invoiceItem[$j][$i]['quota']=$row2['quota'];
				$invoiceItem[$j][$i]['box']=$row2['box'];
			    $invoiceItem[$j][$i]['model']=$row2['model'];
				 $invoiceItem[$j][$i]['goods_detail']=$row2['goods_detail'];
				 
				 
				 
				 //find today out_qty
					$goodsPartnoSql="select sum(qty) as totalqty from goods_invoice i ,invoice where invoice.invoice_no=i.invoice_no and i.goods_partno ='".$invoiceItem[$j][$i]['goods_partno']."' and date(invoice_date)=CURDATE()";
					$todayOutresults = $db->query($goodsPartnoSql);
					$todayOutRow = $todayOutresults->fetchRow(DB_FETCHMODE_ASSOC);
					$invoiceItem[$j][$i]['todayPartNoOutTotal']=$todayOutRow['totalqty'];
			}
				 
			
			
			
			
				 
		   $i++;
		}
    
	 }
	 
	  
	 return $invoiceItem;
}
?>