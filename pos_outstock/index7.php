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
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600');");
}
</script>
<?
$ok=0;
$totalcounter=0;
//count input
 

//get name
include("./include/config.php");
 
    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result))
      die ($result->getMessage());



 

  //insert invoice
  $query="insert into invoice (lastname,creation_date,created_by,invoice_no,invoice_date,delivery_date,delivery_timeslot,sales_name,customer_name,customer_tel,customer_detail,member_id,branchID,delivery,man_power_price,discount_percent,discount_deduct,special_man_power_percent,total_price,settle,deposit,deposit_method,credit_card_rate,settledate,receiver) ";
  $query.=" values ('$lastname',SYSDATE(),'$browseryrt','',now(),'$delivery_date',$delivery_timeslot,'$sales','$mem_name','$mem_tel','$mem_add','$mem_id','$AREA','$delivery','$man_power_price','$subdiscount','$subdeduct','$special_man_power_percent','$subsubtotal','$status','$deposit','$deposit_method','$creditcardrate','$settledate','$receiver')";

  
 
 
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  
  $query="SELECT LAST_INSERT_ID();";
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
 
  $row=$result->fetchRow();
  //echo "invoice no=".$row[0];
  $invoice_no=$row[0];

 
  for ($i=0;$i<16;$i++)
  {
	if($goods_partno[$i]!=""){
		 
   $query="insert into goods_invoice (invoice_no,goods_partno,qty,discountrate,marketprice,status,subtotal,manpower,goods_detail,deductstock,cutting,delivered) ";
   $query.=" values ('$invoice_no','$goods_partno[$i]',$qty[$i],$discount[$i],$market_price[$i],'A',$subtotal[$i],'$manpower[$i]','$goods_detail[$i]','$deductStock[$i]','$cutting[$i]','$delivered[$i]') ";
   $result=$connection->query($query);
   
    
  	if (DB::isError($result))
  	{
      die ($result->getMessage());
      
      $ok=0;
      }
      else
      {
      	$ok=1;
      }
      
	}
  }
  echo "CMP3";
  if ($ok==1)
   {
  	include_once("./pdf2/pdf.php");
 
?><SCRIPT LANGUAGE="JavaScript">
popUp("/invoice/pdf/<?=$invoice_no?>.pdf");
window.location="/?page=posv2&subpage=index.php&pos=<?=$pos?>"; 
</script><?
  
}
       
?> 
