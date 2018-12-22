<link rel="stylesheet" href="./include/instock_style.css" type="text/css">
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
<script type="text/javascript" src="./include/instock.js"></script></head>
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
<form id="form1" name="form1" method="post" action="/?page=instock&subpage=instocklist.php">
    
   <div><label>入倉單編號：</label>
  <input type="text" name="instock_no" class="buttonstyle" />
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
  
  <div><label>儲放位置：</label>
  <input name="place" class="buttonstyle"type="text" id="place" />
  </div>
  
  
  <div><label>入倉單日期：</label>
<input name="instock_date_start" id="instock_date_start" class="buttonstyle" type="text"  size="15"><input name="cal" id="calendar" value=".." type="button">
至
<input name="instock_date_end" id="instock_date_end" class="buttonstyle" type="text"  size="15" />
  <input name="cal2" id="calendar2" value=".." type="button" />
  </div> 
  <input type="submit" value="搜尋"/>
 <input type="hidden" name="update" value="2"/>
</form>

<hr/>
<a href="../">回主頁</a>
<hr/>
<?php

 $checking=1;
     	 
		$sql="select * from goods_instock  as b,instock as a  where b.instock_no = a.instock_no   ";
	 
	 
	 	if ($goods_partno!=""){
			if ($checking==1) $sql.=" and ";
			$sql.=" b.goods_partno='".$goods_partno."' ";
		}
		if ($place!=""){
			if ($checking==1) $sql.=" and ";
			$sql.=" b.place='".$place."' ";
		}
		if ($instock_no!=""){
			if($checking==1) $sql.=" and ";
			$sql.=" a.instock_no='".$instock_no."' ";
		}
		if ($instock_date_start!="" && $instock_date_end!=""){
			if($checking==1) $sql.=" and ";
			$sql.=" a.instock_date >= '".$instock_date_start." 00:00:00' and a.instock_date <='".$instock_date_end." 23:59:00' ";
		}
		if ($suppliername!=""){
		    if($checking==1) $sql.=" and ";
			$sql.=" a.supplier_name='".$suppliername."' ";
		}
 

$sql.=" order by a.instock_no desc ";
//echo $sql;

   include('Pager_header.php');
   ?>

<?

echo $turnover;
echo $Pager->numPages;
?>
<table width="100%" border="0" cellpadding="1" cellspacing="1" bgcolor="#000000">
  <tr bgcolor="#006666">
    <td width="22" height="23" bgcolor="#006666"><div align="center"><strong>入倉單編號</strong></div></td>
    <td width="66" bgcolor="#006666"><div align="center"><strong>入倉單日期</strong></div></td>
	 
    <td width="22" bgcolor="#006666"><div align="center"><strong>職員</strong></div></td>
    
	 
    <td width="5%" bgcolor="#006666"><div align="center"><strong>修改</strong></div></td>
	<td width="5%" bgcolor="#006666"><div align="center"><strong>PDF</strong></div></td>
  </tr>
  <?php 
	for ($i=0;$i<count($result);$i++)
	{ 
	$row=$result[$i];
	
   ?><tr valign="middle" align="center" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'"><td class="style7">    <?=$row['instock_no']?>
  </td>
  <td class="style7">    <?=$row['instock_date']?>  </td>
 
  <td class="style7">    <?=$row['staff_name']?>  </td>
 
   
  <td><a href="/?page=instock&subpage=instockedit.php&instock_no=<?=$row['instock_no']?>&update=2&goods_partno2=<?=$goods_partno2?>&goods_partno=<?=$goods_partno?>&goods_detail=<?=$goods_detail?>&market_price=<?=$market_price?>" class="b">修改</a></td>
  <td><a href="/?page=instock&subpage=instockedit.php&instock_no=<?=$row['instock_no']?>&update=2&goods_partno2=<?=$goods_partno2?>&goods_partno=<?=$goods_partno?>&goods_detail=<?=$goods_detail?>&market_price=<?=$market_price?>" class="b">PDF</a></td>
  </tr>
<?
		 }
   ?>
</table>
<?php echo $turnover;?>
<script type="text/javascript">
  Calendar.setup(
    {
      inputField  : "instock_date_start",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  Calendar.setup(
    {
      inputField  : "instock_date_end",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
</script>
 