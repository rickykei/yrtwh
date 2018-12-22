<?php
   include_once("./include/config.php");
?>
<link rel="stylesheet" href="./include/invoice_style.css" type="text/css">
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #5E5E5E}
-->
</style>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script></head>
<body><?php
   
 
   
   //window connction
   $result = $db->query("SET NAMES 'UTF8'");
   
	$checking=0;
   	 
			 
			$sql="SELECT * from sumgoods  ";
			$checking=1;
			 
			if ($goods_partno!=""){
				 
				$sql.=" where goods_partno='".$goods_partno."' ";
				 
			}   
			  
	   
		$sql.=" order by id desc ";   
  
 
 
    $sqlCount= " Select count(*) as total FROM sumgoods  ";
	//cal total count first;
	if ($sqlCount!=""){
	 $result = $db->query($sqlCount);
		 while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$countTotal=$row["total"];
		 }
	}
  
   require_once("./include/Pager.class.php");
   include_once('./ingood/Pager_header.php');
   // print_r($result);

		 
 // While there are still rows in the result set, fetch the current
   // row into the array $row
   ?>
   
<form name="search" action="<?php echo $_SERVER['REQUEST_URI'];?>" method="POST">
 
<div><label class="style7">貨品編號：</label>
<input name="goods_partno" type="text" class="buttonstyle"  id="goods_partno" size="20" maxlength="20" /></div>
<input type="submit" name="button" value="查入貨名"/>
</form>
<hr/>
<a href="../">回主頁</a>
<?php if ($deposit_method!=""){ ?>
   <hr/>
<font color="red"> 
會員賑戶存入: <?php echo $sum_dep_amt;?><br><br>
會員賑戶扣數: <?php echo $sum_inv_dep_amt; ?><br><br>
戶口結餘: <?php echo $sum_dep_amt-$sum_inv_dep_amt;?>

</font>
<?php } ?>
   <hr/>
<?=$turnover?>
<table  width="100%" bgcolor="#2E2E2E" border="0" cellpadding="1" cellspacing="1">
<TR bgcolor="#5E5E5E" align="center" style="font-weight:bold" >
	<TD width="50" height="23" bgcolor="#006633"> 貨id</TD>
	<TD width="107" bgcolor="#006633"> 貨品編號</TD>
	<TD width="107" bgcolor="#006633">貨品描述</TD>
	<td width="78" bgcolor="#006633">裝數</td>
	<TD width="94" bgcolor="#006633">單位</TD>
	<TD width="67" bgcolor="#006633">重量</TD>
	<TD width="32" bgcolor="#006633">編輯</td>
 
</TR>

    <?php 
	 
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   ?><tr valign="middle" align="center"  <? 
if($row['settle']=="S" || $row['settle']=="") {echo "class='b'\"";echo " onMouseOut=\"this.className='b'\"";echo " onMouseOver=\"this.className='normal'\"";}
else if ($row['settle']=="A") { echo " onMouseOut=\"this.className='normal'\"";echo " onMouseOver=\"this.className='highlight'\"";}
 else if ($row['settle']=="D") { echo "class='deposit'\""; echo " onMouseOut=\"this.className='deposit'\"";echo " onMouseOver=\"this.className='highlight'\"";}
?>   />
   <td><? if ($row['call_count']>0) echo "*" ; ?><?=$row['id']?></td>
   <td><?=$row['goods_partno']?></td>
   <td><?=$row['goods_detail']?></td>
   <td><?=$row['qty_per_unit']?></td>
   <td><?=$row['unitid']?></td>
   <td><?=$row['weight']?></td>
   <td>[<a  href="/?page=ingood&subpage=ingood_edit.php&id=<?=$row['id']?>">Edit</a>]
    
		 <? }
   ?>
</table><?php echo $turnover;?>
 
