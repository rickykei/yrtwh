<?php // error_reporting( E_ALL ); ?>
<script type="text/javascript" src="./js/js.storage.min.js"></script> 
<script language="javascript">
 $(function() {
	 var pos='<?php echo $pos;?>';
	 ls=Storages.localStorage;
	ls.remove(pos+'_myItems');
	ls.remove(pos+'_memadd');
	ls.remove(pos+'_memid');
	 	ls.remove(pos+'_receiver');
 });
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=1,width=800,height=600');");
}
</script><?
$ok=0;
$totalcounter=0;

$invoice_no=$id;
//count input
for ($i=0;$i<count($goods_partno);$i++)
{
	if ($goods_partno[$i]!="")
	$totalcounter++;
//echo $goods_partno[$i]."@".$goods_detail[$i]."@".$qty[$i]."@".$discount[$i]."<br>";
 
}

//get name
include_once("./include/config.php");
include_once("./include/functions.php");
   $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);
   
   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result))
      die ($result->getMessage());



   
	

  //backup old invoice  20130717
  
   $query="select * from invoice where invoice_no='".$id."'";
   $oldInvoiceResult = $connection->query($query);
   $oldInvoiceRow = $oldInvoiceResult->fetchRow(DB_FETCHMODE_ASSOC);
   
   
   //20181110 remove <low price backup , request by alvin  backup all modified invoice now
 //if ($oldInvoiceRow['total_price']>$subsubtotal){
  //backup old invoice item  20130717
  // insert amend log if the subtotal amount is changed 20170115
  
  $query="insert into invoice_amend (lastname,amend_invoice_id,amend_sales_name,amend_by,amend_date,creation_date,created_by,invoice_no,invoice_date,delivery_date,delivery_timeslot,sales_name,customer_name,customer_tel,customer_detail,member_id,branchID,delivery,man_power_price,discount_percent,discount_deduct,special_man_power_percent,total_price,settle,deposit,deposit_method,credit_card_rate,settledate,receiver) ";
  $query.=" values ('$lastname','','$sales','$browseryrt',SYSDATE(),'".$oldInvoiceRow['creation_date']."','".$oldInvoiceRow['created_by']."',".$oldInvoiceRow['invoice_no'].",'".$oldInvoiceRow['invoice_date']."','".$oldInvoiceRow['delivery_date']."','".$oldInvoiceRow['delivery_timeslot']."','".$oldInvoiceRow['sales_name']."','".$oldInvoiceRow['customer_name']."','".$oldInvoiceRow['customer_tel']."','".$oldInvoiceRow['customer_detail']."',".$oldInvoiceRow['member_id'].",'".$oldInvoiceRow['branchID']."','".$oldInvoiceRow['delivery']."',".$oldInvoiceRow['man_power_price'].",".$oldInvoiceRow['discount_percent'].",".$oldInvoiceRow['discount_deduct'].",".$oldInvoiceRow['special_man_power_percent'].",".$oldInvoiceRow['total_price'].",'".$oldInvoiceRow['settle']."',".$oldInvoiceRow['deposit'].",'".$oldInvoiceRow['deposit_method']."',".$oldInvoiceRow['credit_card_rate'].",'".$oldInvoiceRow['settledate']."','".$oldInvoiceRow['receiver']."')";
  $result=$connection->query($query);
	   
	 
  $query="SELECT LAST_INSERT_ID();";
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  $row=$result->fetchRow();
  $amend_invoice_id=$row[0];
  
 
 

  $query="select * from goods_invoice where invoice_no='".$id."'";
   $oldGoodInvoiceResult = $connection->query($query);
   while($oldGoodInvoiceRow = $oldGoodInvoiceResult->fetchRow(DB_FETCHMODE_ASSOC))
   {
       $query="insert into goods_invoice_amend (id,amend_invoice_id,amend_id,amend_date,invoice_no,goods_partno,qty,discountrate,marketprice,status,subtotal,manpower,goods_detail,deductstock,cutting,delivered) ";
       $query.=" values(".$oldGoodInvoiceRow['id'].",".$amend_invoice_id.",'',sysdate(),".$oldGoodInvoiceRow['invoice_no'].",'".$oldGoodInvoiceRow['goods_partno']."',".$oldGoodInvoiceRow['qty'].",".$oldGoodInvoiceRow['discountrate'].",".$oldGoodInvoiceRow['marketprice'].",'".$oldGoodInvoiceRow['status']."',".$oldGoodInvoiceRow['subtotal'].",'".$oldGoodInvoiceRow['manpower']."','".$oldGoodInvoiceRow['goods_detail']."','".$oldGoodInvoiceRow['deductstock']."','".$oldGoodInvoiceRow['cutting']."','".$oldGoodInvoiceRow['delivered']."')";
	
       $result=$connection->query($query);
	    if (DB::isError($result)) die ($result->getMessage());
   
   }
 //}
  //backup old invoice item  20130717
  
  if(!isset($void))
	  $void='A';
  //insert invoice
  $query="update invoice set void='$void',lastname='$lastname',last_update_date=SYSDATE(),call_count=call_count+1,last_update_by='$browseryrt',invoice_date ='$invoice_date' , delivery_date = '$delivery_date' , sales_name= '$sales' ,customer_name = '$mem_name' ,customer_tel = '$mem_tel' ,customer_detail = '$mem_add' ,member_id ='$mem_id',settle='$status',branchID='$AREA', delivery = '$delivery' ,man_power_price= '$man_power_price' ,discount_percent = '$subdiscount', discount_deduct= '$subdeduct',  special_man_power_percent='$special_man_power_percent',total_price='$subsubtotal',deposit='$deposit',deposit_method='$deposit_method',credit_card_rate='$creditcardrate' ,settledate = '$settledate' ,receiver = '$receiver' ,delivery_timeslot ='$delivery_timeslot' where invoice_no='".$id."'";
  
 // $query.=" values ('',now(),'$delivery_date','$sales','$mem_name','$mem_tel','$mem_add','$mem_id','A','$AREA','$delivery','$man_power_price','$discount_percent','$discount_deduct')";
 
//20100112
	sqllog($query);
//20100112

  $result=$connection->query($query);
  if (DB::isError($result))
      die ($result->getMessage());
     // 
      
	  
	  
	//delete all goods_invoice in old invoice first
	$sql="delete from goods_invoice where invoice_no='".$id."'";
//20100112
	sqllog($sql);
//20100112
  $result = $connection->query($sql);
   if (DB::isError($result))
   die ($result->getMessage());
   
   
  for ($i=0;$i<$totalcounter;$i++)
  {
   $query="insert into goods_invoice (invoice_no,goods_partno,qty,discountrate,marketprice,status,subtotal,manpower,goods_detail,deductstock,cutting,delivered) ";
   $query.=" values    ('$id','$goods_partno[$i]','$qty[$i]','$discount[$i]','$market_price[$i]','A','$subtotal[$i]','$manpower[$i]','$goods_detail[$i]','$deductStock[$i]','$cutting[$i]','$delivered[$i]')";
   //20100112
    
	sqllog($query);
//20100112
  $result=$connection->query($query);
  	if (DB::isError($result))
  	{
      die ($result->getMessage());
      
      $status=0;
      }
      else
      {
      	$status=1;
      }
      
   
  }
  
 
  //20170110
  // add high risk invoice audit log  if $oldInvoiceRow['total_price']>$subsubtotal
  if ( ($oldInvoiceRow['total_price']>$subsubtotal && substr($oldInvoiceRow['last_update_date'],0,10)==date("Y-m-d")) or ($oldInvoiceRow['total_price']>$subsubtotal && substr($oldInvoiceRow['creation_date'],0,10)==date("Y-m-d"))){
	  echo "highrisk";
	   $query=" insert into invoice_high_risk (id,invoice_no,from_total,to_total,staffName,amend_by,creation_date,branchID) values ('','$id','".$oldInvoiceRow['total_price']."','$subsubtotal','$sales','$browseryrt','".$oldInvoiceRow['creation_date']."','".$oldInvoiceRow['branchID']."') ";
	  
	  $result=$connection->query($query);
  	if (DB::isError($result))
  	{
      die ($result->getMessage());
	}
	  
  }
  echo "CMP3";
  if ($status==1)
  //echo "invoice insert Success=".$invoice_no;
  {
  	include_once("./pdf2/pdf.php");
?>
<SCRIPT LANGUAGE="JavaScript">
popUp("/invoice/pdf/<?=$id?>.pdf");
window.location="/?page=invoice&subpage=invoicelist.php";
</script><?
}
  /*
	for ($i=0;$i<$totalcounter;$i++)
	{
		$query="select * from sumgoods where goods_id='".$goods_id[$i]."'";
		$result=$connection->query($query);
		if (DB::isError($result)) 
		      die ($result->getMessage());
    $row = $result->fetchRow();
    $goods_name[$i]=$row[3];
    $market_price[$i]=$row[4];
	}*/		      
?>