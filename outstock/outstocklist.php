<link rel="stylesheet" href="./include/outstock_style.css" type="text/css">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #CCCCCC;
}

-->
</style>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/outstock.js"></script></head>
<?php
  include_once("./include/config.php");
      require "./include/Pager.class.php";
   $query="SET NAMES 'UTF8'";
    $db = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());
 $result = $db->query("SET NAMES 'UTF8'");
 
 $sql_Search_Supplier="select * from supplier ";
 $SupplierResult = $db->query($sql_Search_Supplier);
 
   // (Run the query on the winestore through the connection 
   ?>
<body>
<form id="form1" name="form1" method="post" action="/?page=outstock&subpage=outstocklist.php">
    
   <div><label>提貨單編號：</label>
  <input type="text" name="outstock_no" class="buttonstyle" />
</div>
  <div><label>貨品編號：</label>
  <input name="goods_partno" class="buttonstyle"type="text" id="goods_partno" />
  </div>
    <div><label>貨品編號*：</label>
  <input name="goods_partno2" class="buttonstyle"type="text" id="goods_partno2" />
  </div>
       
  <div><label>貨品名稱：</label>
  <input name="goods_detail" class="buttonstyle"type="text" id="goods_detail" />
  </div>
  
  <div><label>提貨單日期：</label>
<input name="outstock_date_start" id="outstock_date_start" class="buttonstyle" type="text"  size="15"><input name="cal" id="calendar" value=".." type="button">
至
<input name="outstock_date_end" id="outstock_date_end" class="buttonstyle" type="text"  size="15" />
  <input name="cal2" id="calendar2" value=".." type="button" />
  </div> 
  <input type="submit" value="搜尋"/>
 <input type="hidden" name="update" value="2"/>
</form>
<?php

 $checking=0;
     	  if (  $outstock_no!="" && $invoice_no=="" && $goods_partno=="" && $outstock_date_start=="" && $outstock_date_end=="" && $goods_detail=="" && $goods_partno2==""  )
	 	$sql="SELECT * FROM outstock a where a.outstock_no=".$outstock_no;
	 else if ( $goods_partno!="" && $outstock_no=="" && $outstock_date_start=="" && $outstock_date_end=="" && $goods_detail=="" && $goods_partno2==""  )
	 	$sql="select a.outstock_date as outstock_date, a.outstock_no as outstock_no, a.supplier_name as supplier_name,a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name,a.count_price as count_price,a.discount_percent as discount_percent,a.total_price as total_price  ,b.discount good_discount from goods_outstock b ,outstock a where b.outstock_no = a.outstock_no and b.goods_partno like \"".$goods_partno."\" group by a.outstock_no";
	 else if (  $outstock_date_start!="" && $outstock_date_end!="" && $goods_partno=="" && $outstock_no==""   && $goods_detail=="" && $goods_partno2==""  )
	 	$sql="SELECT * from outstock a where a.outstock_date >= '".$outstock_date_start." 00:00:00' and a.outstock_date <='".$outstock_date_end." 23:59:00'";
		  
		  else if (  $outstock_date_start=="" && $outstock_date_end=="" && $goods_partno=="" && $outstock_no=="" && $supplier_invoice_no=="" && $goods_detail!="" && $goods_partno2=="" && $market_price=="")
		 {
		 $sql="SELECT a.outstock_date as outstock_date,a.supplier_name as supplier_name, a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name, a.count_price as count_price, a.discount_percent as discount_percent,a.total_price as total_price,  a.outstock_no as outstock_no from outstock a, goods_outstock b where a.outstock_no=b.outstock_no and b.goods_detail like \"%".$goods_detail."%\"";
		 }
		 else if ( $outstock_date_start=="" && $outstock_date_end=="" && $goods_partno=="" && $outstock_no=="" && $supplier_invoice_no=="" && $goods_detail=="" && $goods_partno2!="" && $market_price=="")
		 {
		$sql="select a.outstock_date as outstock_date, a.outstock_no as outstock_no, a.supplier_name as supplier_name,a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name,a.count_price as count_price,a.discount_percent as discount_percent,a.total_price as total_price ,b.market_price as market_price from goods_outstock b ,outstock a where b.outstock_no = a.outstock_no and b.goods_partno like \"%".$goods_partno2."%\" group by a.outstock_no";
		 }
		  else if (  $outstock_date_start=="" && $outstock_date_end=="" && $goods_partno=="" && $outstock_no=="" && $supplier_invoice_no=="" && $goods_detail=="" && $goods_partno2=="" && $market_price!="")
		 {
		$sql="select a.outstock_date as outstock_date, a.outstock_no as outstock_no, a.supplier_name as supplier_name,a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name,a.count_price as count_price,a.discount_percent as discount_percent,a.total_price as total_price ,b.market_price as market_price from goods_outstock b ,outstock a where b.outstock_no = a.outstock_no and b.market_price = ".$market_price." group by a.outstock_no";
		 }
		 else if (  $outstock_date_start=="" && $outstock_date_end=="" && $goods_partno=="" && $outstock_no=="" && $supplier_invoice_no=="" && $goods_detail=="" && $goods_partno2=="" && $market_price=="")
		$sql="SELECT * FROM outstock a ";
	 else {
	 	if ($goods_partno!=""){
	 		$sql="select a.outstock_date as outstock_date,a.outstock_no as outstock_no, a.supplier_name as supplier_name,a.supplier_invoice_no as supplier_invoice_no,a.staff_name as staff_name,a.count_price as count_price,a.discount_percent as discount_percent,a.total_price as total_price ,b.market_price as market_price from goods_outstock  as b,outstock as a  where b.outstock_no = a.outstock_no and b.goods_partno like \"%".$goods_partno."%\" ";
			$checking=1;
	 	}else{
	 		$sql="select * from outstock as a  where ";
			$checking=0;
		}
		 
		if ($outstock_no!=""){
			if($checking==1) $sql.=" and ";
			$sql.=" a.outstock_no='".$outstock_no."' ";
		}
		if ($outstock_date_start!="" && $outstock_date_end!=""){
			if($checking==1) $sql.=" and ";
			$sql.=" a.outstock_date >= '".$outstock_date_start." 00:00:00' and a.outstock_date <='".$outstock_date_end." 23:59:00' ";
		}
		 
	}

$sql.=" order by a.outstock_no desc ";

//echo $sql;
   include('Pager_header.php');
   ?>

<?

echo $turnover;
echo $Pager->numPages;
?>
<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
  <tr bgcolor="#006666">
    <td width="22" height="23" bgcolor="#006666"><div align="center"><strong>提貨單編號</strong></div></td>
    <td width="66" bgcolor="#006666"><div align="center"><strong>提貨單日期</strong></div></td>
	 
    <td width="22" bgcolor="#006666"><div align="center"><strong>職員</strong></div></td>
    <td width="22" bgcolor="#006666"><div align="center"><strong>軍地倉去</strong></div></td>
    <td width="22" bgcolor="#006666"><div align="center"><strong>運送方法</strong></div></td>
    
	 
    <td width="5%" bgcolor="#006666"><div align="center"><strong>修改</strong></div></td>
	<td width="5%" bgcolor="#006666"><div align="center"><strong>PDF</strong></div></td>
  </tr>
  <?php 
	for ($i=0;$i<count($result);$i++)
	{ 
	$row=$result[$i];
	
   ?><tr valign="middle" align="center" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'"><td class="style7">    <?=$row['outstock_no']?>
  </td>
  <td class="style7">    <?=$row['outstock_date']?>  </td>
 
  <td class="style7">    <?=$row['staff_name']?>  </td>
 <td class="style7">    <?=$row['to_shop']?>  </td>
 
   <td class="style7">    <?=$row['delivery_method']?>  </td>
 
   
   
  <td>
  <a href="/?page=outstock&subpage=outstockedit.php&outstock_no=<?=$row['outstock_no']?>&update=2&goods_partno2=<?=$goods_partno2?>&goods_partno=<?=$goods_partno?>&goods_detail=<?=$goods_detail?>&market_price=<?=$market_price?>" class="b">修改</a>
  [<a  href="/?page=pos_outstock&subpage=index_edit.php&pos=pos1_edit&outstock_no=<?=$row['outstock_no']?>&action=edit"  target="_blank">POS</a>]
  
  </td>
  <td><a target="_blank" href="/outstock/pdf/<?=$row['outstock_no']?>.pdf" class="b">PDF</a></td>
  </tr>
<?
		 }
   ?>
</table>
<?php echo $turnover;?>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "outstock_date_start",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  Calendar.setup(
    {
      inputField  : "outstock_date_end",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
</script>
 