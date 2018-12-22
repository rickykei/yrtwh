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
		$datestr=date('Y-m-d 12:00',strtotime(date("Y-m-d") . "+1 days"));
	
	$invoicesql=$invoicesql." and delivery_date <='$datestr'";
	return $invoicesql;
}

function add_del_time_SQL_by($invoicesql,$s,$year,$month,$day){
	$datestr=$year."-".$month."-".$day;
 
	if ($s==1)
		$datestr= Date("Y-m-d 11:00",strtotime($datestr));
	else if ($s==2)
		$datestr=date("Y-m-d 14:00",strtotime($datestr));
	else if ($s==3)
		$datestr=Date("Y-m-d 18:00",strtotime($datestr));
	 
	
	$invoicesql=$invoicesql." and delivery_date <='$datestr'";
	return $invoicesql;
}

function sqllog($sql)
{
	include("../include/config.php");
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


function findBalFromPartNo($goods_partno,$isPredict)
{
	
	include("../include/config.php");
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
	if ($row['mix']=='N'){
		//search stock bal  signle item Logic 2016
		 $invoiceSql="select ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where deductstock='Y' and  i.invoice_no=gi.invoice_no and goods_partno = '$goods_partno' ";
		 $invoiceSql=add_del_time_SQL($invoiceSql);
		 
		 $inshopSql="select ifnull(sum(qty),0) as qty from inshop i , goods_inshop gi where deductstock='Y' and i.inshop_no=gi.inshop_no and goods_partno = '$goods_partno'";
		 
		 $scrapSql= "select ifnull(sum(qty),0) as qty from goods_scrap gs where goods_partno = '$goods_partno'";
		 
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
		 
	}else if ($row['mix']=='S'){
		//items code = slave
		
		 //search stock bal  single item Logic 2016
		 
		 //--find out qty
		 $invoiceSql="select ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where deductstock='Y' and  i.invoice_no=gi.invoice_no and goods_partno = '$goods_partno' ";
		 $invoiceSql=add_del_time_SQL($invoiceSql);
		 
		 //--find in qty
		 $inshopSql="select ifnull(sum(qty),0) as qty from inshop i , goods_inshop gi where deductstock='Y' and i.inshop_no=gi.inshop_no and goods_partno = '$goods_partno'";
		 
		 //-find out qty
		 $scrapSql= "select ifnull(sum(qty),0) as qty from goods_scrap gs where goods_partno = '$goods_partno'";
		 
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
		 
		
		 
		
		 //find parent product codes  104000 ->find 234-24, 234-26 , 234-28
		$findMasterSql="select partno_src,qty from sumgoods_mix where partno_sub='$goods_partno' and sts='Y'";
		$resultFindMasterSql =$db->query($findMasterSql ) or die (mysql_error()."Couldn't execute query: $findMasterSql");
		$num_resultFindMasterSql=$resultFindMasterSql->numRows();
		for ($i=0;$i<$num_resultFindMasterSql;$i++)
		{
			$row_resultFindMasterSql = $resultFindMasterSql->fetchRow(DB_FETCHMODE_ASSOC);
			//multi qty for bundle item 20160404
			$masterItem[$i]['partno']=$row_resultFindMasterSql['partno_src'];
			$masterItem[$i]['qty']=$row_resultFindMasterSql['qty'];
			///
			//$masterItemStr.=",'".$row_resultFindMasterSql['partno_src']."'";
		}
		//$masterItemStr=substr($masterItemStr, 1);
		
		 
		 //find parent out x qty bundle
		 $masterInvoiceQty=0;
		 
		 for($i=0;$i<count($masterItem);$i++){
			 
		 
				 $invoiceSql="select goods_partno, ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where deductstock='Y' and  i.invoice_no=gi.invoice_no and goods_partno = '".$masterItem[$i]['partno']."'";
				 $invoiceSql=add_del_time_SQL($invoiceSql);
				 $invoiceSql.=" group by goods_partno ";
				 
				 
				 $resultInvoiceSql =$db->query($invoiceSql ) or die (mysql_error()."Couldn't execute query: $invoiceSql");
				 while($row2 = $resultInvoiceSql->fetchRow(DB_FETCHMODE_ASSOC))
				 {
				 $masterInvoiceQty=$masterInvoiceQty+$row2['qty']*$masterItem[$i]['qty'];
				 }
			  
	  
		}
		 $invoiceQty=$invoiceQty+$masterInvoiceQty;
		 
		 $stockbal=$inshopQty-$invoiceQty-$scrapQty;

	
	}else if ($row['mix']=='Y'){
		//items code = Master
		//search stock bal for bundle item 20160315
		
		//find slave product codes   234-24 ->find 104000,104024
		$findSlaveSql="select partno_sub,qty from sumgoods_mix where partno_src='$goods_partno'";
		$resultFindSlaveSql =$db->query($findSlaveSql ) or die (mysql_error()."Couldn't execute query: $findSlaveSql");
		$num_resultFindSlaveSql=$resultFindSlaveSql->numRows();
		
		for ($i=0;$i<$num_resultFindSlaveSql;$i++)
		{
			$row_resultFindSlaveSql = $resultFindSlaveSql->fetchRow(DB_FETCHMODE_ASSOC);
			$slaveItem[$i]['partno']=$row_resultFindSlaveSql['partno_sub'];
			$slaveItem[$i]['qty']=$row_resultFindSlaveSql['qty'];
			$slaveItemStr.=",'".$row_resultFindSlaveSql['partno_sub']."'";
		}
		$slaveItemStr=substr($slaveItemStr, 1);
		  
		 
	  
		//find master qty which used same child    234-24 -> 104000 -> 234-26
		$j=0;
		for ($i=0;$i<count($slaveItem);$i++)
		{
			$findMasterCodeWhichContainSameChildSql="select * from sumgoods_mix where partno_sub='".$slaveItem[$i]['partno']."' ";
			 $findMasterCodeWhichContainSameChildSql =$db->query($findMasterCodeWhichContainSameChildSql ) or die (mysql_error()."Couldn't execute query: $findMasterCodeWhichContainSameChildSql");
			 
			 while ($row_resultFindMasterCodeWhichContainSameChildSql = $findMasterCodeWhichContainSameChildSql->fetchRow(DB_FETCHMODE_ASSOC))
			 {
				$sameChildItem[$j]['partno_src']=$row_resultFindMasterCodeWhichContainSameChildSql['partno_src'];
				$sameChildItem[$j]['partno_sub']=$row_resultFindMasterCodeWhichContainSameChildSql['partno_sub'];
				$sameChildItem[$j]['qty']=$row_resultFindMasterCodeWhichContainSameChildSql['qty'];
				$j++;
			 }
		}
	
		 
		for ($i=0;$i<count($sameChildItem);$i++)
		{
			//find same child master code invoice bal  
			$invoiceSql="select ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where deductstock='Y' and  i.invoice_no=gi.invoice_no and goods_partno = '".$sameChildItem[$i]['partno_src']."' ";
			$invoiceSql=add_del_time_SQL($invoiceSql);
			$result2 = $db->query($invoiceSql);
			while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
			{
			  $sameChildItem[$i]['out_qty']=$row2['qty'];
			  $sameChildItem[$i]['out_qty_for_samechild']=$sameChildItem[$i]['qty']* $sameChildItem[$i]['out_qty'];
			  $totalMasterQTYforChild[$sameChildItem[$i]['partno_sub']]=$totalMasterQTYforChild[$sameChildItem[$i]['partno_sub']]+ $sameChildItem[$i]['out_qty_for_samechild'];
			}
			
		}
		 
			// print_r($sameChildItem);
		
		//find bundle slave qty 20160404
		for ($i=0;$i<count($slaveItem[$i]);$i++){
			 
		//find slave invoice bal , 
		$invoiceSlaveSql="select goods_partno,ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where deductstock='Y' and  i.invoice_no=gi.invoice_no and goods_partno ='".$slaveItem[$i]['partno']."' ";
		$invoiceSlaveSql=add_del_time_SQL($invoiceSlaveSql);
		//$invoiceSlaveSql.=" group by goods_partno ";
	 
			$result2 = $db->query($invoiceSlaveSql);
			while(  $row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
			{
				if ($row2['goods_partno']!=""){
			  $tmp_partno=$row2['goods_partno'];
			  $invoiceSlaveQty[$tmp_partno]=$row2['qty'];
				}
			}
		}
		
		
		 
		
		// find master inshop bal
		 $inshopSql="select ifnull(sum(qty),0) as qty from inshop i , goods_inshop gi where deductstock='Y' and i.inshop_no=gi.inshop_no and goods_partno = '$goods_partno'";
		  $result2 = $db->query($inshopSql);
		 while(  $row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		  $inshopQty=$row2['qty'];
		 }
		 
		 //find slave inshop bal
		  $inshopSlaveSql="select  goods_partno, ifnull(sum(qty),0) as qty from inshop i , goods_inshop gi where deductstock='Y' and i.inshop_no=gi.inshop_no and goods_partno in ($slaveItemStr)";
		  $inshopSlaveSql.=" group by goods_partno ";
		  $result2 = $db->query($inshopSlaveSql);
		while(  $row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
		{
		  $tmp_partno=$row2['goods_partno'];
		  $inshopSlaveQty[$tmp_partno]=$row2['qty'];
		}
		
		 // find master scrap bal
		  $scrapSql= "select ifnull(sum(qty),0) as qty from goods_scrap gs where goods_partno = '$goods_partno'";
		  $result2 = $db->query($scrapSql);
		 while(  $row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		  $scrapQty=$row2['qty'];
		 }
		  // find slave scrap bal
		 $scrapSlaveSql= "select goods_partno, ifnull(sum(qty),0) as qty from goods_scrap gs where goods_partno in ($slaveItemStr)";
		 $scrapSlaveSql.=" group by goods_partno ";
		 $result2 = $db->query($scrapSlaveSql);
		 while(  $row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		  $tmp_partno=$row2['goods_partno'];
		  $scrapSlaveQty[$tmp_partno]=$row2['qty']*$slaveItem[$i]['qty'];
		 }
		 
		 // $stockbal=$inshopQty-$invoiceQty-$scrapQty;
		 //cal inshopQty for slave 
		 //
		 
		 
		 
		 
		 for ($i=0;$i<$num_resultFindSlaveSql;$i++)
		{
			$tmp_partno=$slaveItem[$i]['partno'];
			$stockSlaveBal[$tmp_partno]=$inshopSlaveQty[$tmp_partno]-$invoiceSlaveQty[$tmp_partno]-$scrapSlaveQty[$tmp_partno];
			
			//deduct qty from same child master
			$stockSlaveBal[$tmp_partno]=$stockSlaveBal[$tmp_partno]-$totalMasterQTYforChild[$tmp_partno];
			
			
			//transit by master ratio qty
			//echo $stockSlaveBal[$tmp_partno];
			
		 
			$stockSlaveBal[$tmp_partno]=$stockSlaveBal[$tmp_partno]/$slaveItem[$i]['qty'];
			// echo 	$stockSlaveBal[$tmp_partno];
			$stockSlaveBal[$tmp_partno]=floor($stockSlaveBal[$tmp_partno]);
			//echo 	$stockSlaveBal[$tmp_partno];
//			print_r($totalMasterQTYforChild);
		}
		
		 
		$lowerestBalSlaveArr=array_keys($stockSlaveBal, min($stockSlaveBal));
		$lowerestBalSlave=$lowerestBalSlaveArr[0];
		 
		//  echo $lowerestBalSlave;
		$slaveBalQty=$stockSlaveBal[$lowerestBalSlave]-$invoiceQty;
		// echo $slaveBalQty;
		$stockbal=$scrapQty+$slaveBalQty;
		 
	}
	//echo $stockbal;
	$prodresult['stockbal']=$stockbal;
	$prodresult['scrapQty']=$scrapQty;
	$prodresult['invoiceQty']=$invoiceQty;
	$prodresult['inshopQty']=$inshopQty;
	$prodresult['slaveBalQty']=$slaveBalQty;
	return $prodresult;
}


function predictSpecifyDate($day,$month,$year,$modelSelectR){
	include("../include/config.php");
	 $db = DB::connect($dsn);
   if (DB::isError($db))
      die($db->getMessage());
	   $query="SET NAMES 'UTF8'";
    if (DB::isError($db)) die($db->getMessage());
	
	
	for ($j=1;$j<4;$j++){
	//search tomorrow invoice items
	if ($modelSelectR=="NULL"){
		$invoice="select distinct goods_partno from invoice, goods_invoice where deductstock='Y' and invoice.invoice_no=goods_invoice.invoice_no and invoice.delivery_timeslot=$j ";
		$scrap="select distinct goods_partno from scrap, goods_scrap where deductstock='Y' and scrap.invoice_no=goods_scrap.invoice_no and scrap.delivery_timeslot=$j ";
	}
	else{
		
		$invoice="select distinct sumgoods.goods_partno from invoice, goods_invoice,sumgoods where deductstock='Y' and invoice.invoice_no=goods_invoice.invoice_no and invoice.delivery_timeslot=$j and sumgoods.goods_partno=goods_invoice.goods_partno and sumgoods.model='$modelSelectR' "; 
		$scrap="select distinct sumgoods.goods_partno from scrap, goods_scrap,sumgoods where deductstock='Y' and scrap.invoice_no=goods_scrap.invoice_no and scrap.delivery_timeslot=$j and sumgoods.goods_partno=goods_scrap.goods_partno and sumgoods.model='$modelSelectR' "; 
	}
	
	
	if ($j==1){
		
		$invoice=$invoice." and month(invoice.delivery_date)=$month && year(invoice.delivery_date)=$year && DAYOFMONTH(invoice.delivery_date)=$day ";
		$scrap=$scrap." and month(scrap.delivery_date)=$month && year(scrap.delivery_date)=$year && DAYOFMONTH(scrap.delivery_date)=$day ";
	}else if ($j==2){

		$invoice=$invoice." and month(invoice.delivery_date)=$month && year(invoice.delivery_date)=$year && DAYOFMONTH(invoice.delivery_date)=$day ";
		$scrap=$scrap." and month(scrap.delivery_date)=$month && year(scrap.delivery_date)=$year && DAYOFMONTH(scrap.delivery_date)=$day ";
	}elseif ($j==3){

		$invoice=$invoice." and month(invoice.delivery_date)=$month && year(invoice.delivery_date)=$year && DAYOFMONTH(invoice.delivery_date)=$day ";
		$scrap=$scrap." and month(scrap.delivery_date)=$month && year(scrap.delivery_date)=$year && DAYOFMONTH(scrap.delivery_date)=$day ";
	}
	
 
 
	$invoice=$invoice." union ".$scrap;
	
	 
	$invoiceresult = $db->query($invoice);
	

	$i=0;
		while($row=$invoiceresult->fetchRow(DB_FETCHMODE_ASSOC)){
			 
	   $partno=$row['goods_partno'];
	   $invoiceItem[$j][$i]['goods_partno']=$partno;
	   
	   echo $j."-".$partno."<p>";
	   //$invoiceItem[$j][$i]['qty']=$row['qty'];
	  
			  //find invoice qty
			// $invoiceSql="select  ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where  deductstock='Y' and i.invoice_no=gi.invoice_no and goods_partno ='".$partno."' and i.delivery_timeslot=$j  ";
			 $invoiceSql="select  ifnull(sum(qty),0) as qty from invoice i , goods_invoice gi where  deductstock='Y' and i.invoice_no=gi.invoice_no and goods_partno ='".$partno."'   ";
			   
			  //add time control
			  if ($j==1){
				  
				  $invoiceSql=add_del_time_SQL_by($invoiceSql,$j,$year,$month,$day);
			  }else if ($j==2){
				   $invoiceSql=add_del_time_SQL_by($invoiceSql,$j,$year,$month,$day);
				  
			  }else if ($j==3){
				    $invoiceSql=add_del_time_SQL_by($invoiceSql,$j,$year,$month,$day);
				  
			  }
				  
			 
			 $result2 = $db->query($invoiceSql);
			 while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC)){
				$invoiceItem[$j][$i]['out']=$row2['qty'];
			 }
			
			//find scrap qty
			 $invoiceSql="select  ifnull(sum(qty),0) as qty from scrap i , goods_scrap gi where   i.invoice_no=gi.invoice_no and goods_partno ='".$partno."'   ";
			 
			 //add time control for scrap 20160117
			 $invoiceSql=add_del_time_SQL_by($invoiceSql,$j,$year,$month,$day);
			  
			$result2 = $db->query($invoiceSql);
			 while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC)){
				$invoiceItem[$j][$i]['scrap']=$row2['qty'];
			 }
			
			//find inshop qty
			  //find invoice qty
			 $inshopSql="select  ifnull(sum(qty),0) as qty from inshop i , goods_inshop gi where deductstock='Y' and i.inshop_no=gi.inshop_no and goods_partno ='".$partno."'";
			  
			 $result2 = $db->query($inshopSql);
			 while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC)){
			 $invoiceItem[$j][$i]['in']=$row2['qty'];
			 }
			
			//find quota
			$sumgoodSql="select ifnull(inshop_quota,0) as quota ,inshop_box as box ,model,goods_detail from sumgoods i  where  goods_partno ='".$partno."'";
			 $result2 = $db->query($sumgoodSql);
			 while($row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC)){
				$invoiceItem[$j][$i]['quota']=$row2['quota'];
				$invoiceItem[$j][$i]['box']=$row2['box'];
			    $invoiceItem[$j][$i]['model']=$row2['model'];
				 $invoiceItem[$j][$i]['goods_detail']=$row2['goods_detail'];
				 }
		   $i++;
		}
    
	 }
	 
	  
	 return $invoiceItem;
}
?>