<?php 
  
  require_once("./include/config.php");
  $outstockRecord=18;


	
// Sql Connection
	$connection = DB::connect($dsn);
	if (DB::isError($connection))
		die($connection->getMessage());
		
//get Supplier name
	$sql="SELECT * FROM supplier";
	$result = $connection->query("SET NAMES 'UTF8'");
	$supplierResult = $connection->query($sql);

//get Staff name

	$sql="SELECT * FROM staff";
	$staffResult = $connection->query($sql);
	
//get outstock

	$sql="SELECT * FROM outstock where outstock_no=$outstock_no";
	$outstockresult = $connection->query($sql);
	$outstockrow = $outstockresult->fetchRow(DB_FETCHMODE_ASSOC);

//get outstock_goods

	$sql="SELECT * FROM goods_outstock where outstock_no=$outstock_no order by id ";
	$outstockresult = $connection->query($sql);


	?> 
<link href="./include/outstock.css" rel="stylesheet" type="text/css">
 <style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/outstock.js"></script>
<script>
function check_del(aa)
{
 alert('刪除'+ aa);
     document.outstock_del_form.submit();
}
</script>
</head>
<form action="/?page=outstock&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="940" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CCCC">

  <tr>
    <td height="360">&nbsp;</td>
    <td align="center" valign="top">
	<table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006666"><span class="style6">修改提倉單</span></td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%"></td>
        <td colspan="2" width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="5"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006666">
            <td height="21"><label><span class="style6">提倉單編號 :</span> </label></td>
            <td colspan="2"><label><span class="style6"><?php echo $outstockrow['outstock_no']; ?></span><input type="hidden" name="outstock_no" value="<?=$outstockrow['outstock_no'];?>"> </label></td>
            <td width="29%">&nbsp;</td>
          </tr>
          <tr bgcolor="#006666">
            <td width="14%" height="21">
                <span class="style6"> <span class="style5">發票</span>日期 ：</span></td>
            <td width="40%"><input name="outstock_date" type="text" id="outstock_date" value="<? echo $outstockrow['outstock_date']; ?>">
              <input name="cal" id="calendar" value=".." type="button" /></td>
            <td width="17%"><span class="style6">職員 : <?=$outstockrow['staff_name']?>*</span></td>
            <td ><select name="staff_name" id="staff_name">
              <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
			  
			  	if ($row['name']==$outstockrow['staff_name'])
				echo "<option value=\"".$row['name']."\" selected>".$row['name']."</option>";
				else
                echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
				}?>
            </select></td>
          </tr>
          
        </table></td>
      </tr>
	  <tr bgcolor="#006666" >
            <td width="20%" height="21">
                <span class="style6"> 軍地倉去：</span></td>
            <td width="28%" > 
			<select name="to_shop" id="to_shop"><option value="自提" <?php if ($outstockrow['to_shop']=='自提') { echo "selected";}?>>自提</option>  
            <option value="Y鋪" <?php if ($outstockrow['to_shop']=='Y鋪') { echo "selected";}?>>Y鋪</option>  
			<option value="大海" <?php if ($outstockrow['to_shop']=='大海') { echo "selected";}?>>大海</option>  
            </select></td>
            <td width="17%" ><span class="style6">運送方法 : </span></td>
            <td colspan="2" width="35%" ><select name="delivery_method" id="delivery_method">
              <option value="9456" <?php if ($outstockrow['delivery_method']=='9456') { echo "selected";}?>>9456</option>  
			<option value="3819" <?php if ($outstockrow['delivery_method']=='3819') { echo "selected";}?>>3819</option>  
			<option value="6586" <?php if ($outstockrow['delivery_method']=='6586') { echo "selected";}?>>6586</option>  
			<option value="897" <?php if ($outstockrow['delivery_method']=='897') { echo "selected";}?>>897</option>  
		  
            </select></td>
          </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="5">
		<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#006666">
        
            <td width="6%"><span class="style6">行數</span></td>
            <td width="24%"><span class="style6">貨品編號</span></td>
			<td width="11%" class="style6">儲放位置</td>
            <td width="7%"><span class="style6">箱數量</span></td>
			<td width="7%"><span class="style6">裝數量</span></td>
            <td width="30%"><span class="style6">貨品描述</span></td>
            
            
          </tr>
          
<?$elements_counter=4;
$i=0;
$tab=0;
$bgcolor="#CCCCCC";
while($goods_outstockrow = $outstockresult->fetchRow(DB_FETCHMODE_ASSOC))          
	{
	//20090409
    //add goods_partno searching caiteria
    if ( ( preg_match("/".$goods_detail."/", $goods_outstockrow['goods_detail'], $matches) && $goods_detail!="" ) || $goods_partno==$goods_outstockrow['goods_partno'] || (preg_match("/".$goods_partno2."/", $goods_outstockrow['goods_partno'], $matches)  && $goods_partno2!="") || $market_price == $goods_outstockrow['market_price'])
    {
      $bgcolor="#CCFF##";
    } else {
    	$bgcolor="#CCCCCC";
    }   
	?>
          <tr bgcolor="<?=$bgcolor?>">
            <td><div align="center"><?=$i+1?></div></td>
            <td><input  name="goods_partno[]" type="text" id="goods_partno<?echo $i;?>" value="<? echo $goods_outstockrow['goods_partno']; ?>" tabindex="<?$tab++;echo $tab?>" size="15" maxlength="30"  />
            <input type=button name="search" value=".." onClick="javascript:AddrWindow(<?echo $elements_counter;$elements_counter=$elements_counter+7;?>)" >
            <input name="action<?=$i?>" type="button" id="action<?=$i?>"  value="?" /></td>
			<td>
			<select name="place[]" id="place<? echo $i; ?>" tabindex="<?$tab++;echo $tab?>">
			 <option value="<? echo $goods_outstockrow['place']; ?>"><? echo $goods_outstockrow['place']; ?></option>
			</select>
			<? echo $goods_outstockrow['place']; ?>
            
			<td><div align="center">
			   <input name="box[]" type="text" id="box<?echo $i;?>" tabindex="<?$tab++;echo $tab?>" class="box" value="<? echo $goods_outstockrow['box']; ?>" size="6" maxlength="6"  onFocus="checkStock(<?=$i?>)" >
			 </div></td>
			 
            <td>
			<input type="hidden" id="qty_per_unit<? echo $i; ?>" value=""/>
			<input type="hidden" id="weight_per_unit<? echo $i; ?>" value="0"/>
			<input type="hidden" id="weight_per_row<? echo $i; ?>" value="0"/>
			<input name="qty[]" type="text" id="qty<?echo $i;?>"   tabindex="<?$tab++;echo $tab?>"  value="<? echo $goods_outstockrow['qty']; ?>" size="7" maxlength="7" onFocus="checkInputQty(<?=$i?>)"></td>
                       
			 
			 <td  ><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<?echo $i;?>" value="<? echo htmlspecialchars($goods_outstockrow['goods_detail']); ?>" size="35" maxlength="40">
            </div></td>
            
          </tr>
	 
<?
$i++;
}
for ($y=$i;$y<$outstockRecord;$y++)
{
?>
    <tr bgcolor="#CCCCCC">
            <td><div align="center"><?=$y+1?></div></td>
            <td><input  name="goods_partno[]" type="text" id="goods_partno<?echo $y;?>" value="<? echo $goods_outstockrow['goods_partno']; ?>" tabindex="<?$tab++;echo $tab?>" size="15" maxlength="30"  />
            <input type=button name="search" value=".." onClick="javascript:AddrWindow(<?echo $elements_counter;$elements_counter=$elements_counter+7;?>)" >
            <input name="action<?=$i?>2" type="button" id="action<?=$y?>"  value="?" /></td>
			  <td>
			  <select name="place[]" id="place<? echo $y; ?>" tabindex="<?$tab++;echo $tab?>">
			 
			</select>
			 </td>
            <td><div align="center">
			   <input name="box[]" type="text" id="box<?echo $y;?>" tabindex="<?$tab++;echo $tab?>" class="box" value="0" size="6" maxlength="6" onFocus="checkStock(<?=$y?>)">
			 </div></td>
			<td>
			<input type="hidden" id="qty_per_unit<? echo $i; ?>" value=""/>
			<input type="hidden" id="weight_per_unit<? echo $i; ?>" value="0"/>
			<input type="hidden" id="weight_per_row<? echo $i; ?>" value="0"/>
			<input  name="qty[]" type="text" id="qty<?echo $y;?>"  tabindex="<?$tab++;echo $tab?>"  value="0" size="7" maxlength="7"  onFocus="checkInputQty(<?=$i?>)"></td>
              <td  ><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<?echo $y;?>" value="" size="35" maxlength="40">
            </div></td>
			 
            
          
            
    </tr>
	 
<?}
?>
          
        
            
        </table>
          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="5">
             </td>
      </tr>
      <tr>
         <td height="">總重量</td>
         <td height=""><input type="text" id="total_weight" value="0"/></td>
        <td height=""><input type="hidden" name="update" value="3" /><input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" /></td>
        <td><input name="clear" type="reset" id="clear" value="清除">
          <input name="submitb" type="submit" id="submitb" value="更新記錄" >
		  </form></td><td>
          <form name="outstock_del_form" method="POST" action="/?page=outstock&subpage=outstock_del.php">
		<input type="hidden" name="outstock_no" value="<?echo $outstock_no;?>" >
        <input type="submit" name="Submit" value="刪除此項單" onClick="javascript:check_del('<?echo $goods_partno;?>')">
        </form>
		
		</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<script type="text/javascript">
first_text_box_focus();
  Calendar.setup(
    {
      inputField  : "outstock_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
  
  
(function ($) {
   $(".box").blur(
 function(){
	 
	 var thisid=$(this).attr('id');
	 var thisval=$(this).val();
	 var nextid=thisid.substr(3);
	 var nextval=$('#qty'+nextid).val();
    $('#qty'+nextid).val(nextval*thisval);
 }
 );
})(jQuery);
</script> 
