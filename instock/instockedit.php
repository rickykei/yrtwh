<?php 
 
  require_once("./include/config.php");
 
  $instockRecord=18;


	
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
	
//get instock

	$sql="SELECT * FROM instock where instock_no=$instock_no";
	$instockresult = $connection->query($sql);
	$instockrow = $instockresult->fetchRow(DB_FETCHMODE_ASSOC);

//get instock_goods

	$sql="SELECT * FROM goods_instock where instock_no=$instock_no";
	$instockresult = $connection->query($sql);


	?> 
<link href="./include/instock.css" rel="stylesheet" type="text/css">
 <style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/instock.js"></script>
<script>
function check_del(aa)
{
 alert('刪除2 '+ aa);
     document.instock_del_form.submit();
}
</script>
</head>
<form action="/?page=instock&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="940" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CCCC">

  <tr>
    <td height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006666"><span class="style6">修改入倉單</span></td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%"></td>
        <td width="">&nbsp;</td>
        <td></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="5"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006666">
            <td height="21"><label><span class="style6">入倉單編號 :</span> </label></td>
            <td colspan="2"><label><span class="style6"><?php echo $instockrow['instock_no']; ?></span><input type="hidden" name="instock_no" value="<?=$instockrow['instock_no'];?>"> </label></td>
            <td width="29%">&nbsp;</td>
          </tr>
          <tr bgcolor="#006666">
            <td width="14%" height="21">
                <span class="style6"> <span class="style5">發票</span>日期 ：</span></td>
            <td width="40%"><input name="instock_date" type="text" id="instock_date" value="<? echo $instockrow['instock_date']; ?>">
              <input name="cal" id="calendar" value=".." type="button" /></td>
            <td width="17%"><span class="style6">職員 : <?=$instockrow['staff_name']?>*</span></td>
            <td><select name="staff_name" id="staff_name">
              <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
			  
			  	if ($row['name']==$instockrow['staff_name'])
				echo "<option value=\"".$row['name']."\" selected>".$row['name']."</option>";
				else
                echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
				}?>
            </select></td>
          </tr>
          
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="5"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#006666">
        
            <td width="6%"><span class="style6">行數</span></td>
            <td width="24%"><span class="style6">貨品編號</span></td>
            <td width="7%"><span class="style6">箱數量</span></td>
			<td width="7%"><span class="style6">裝數量</span></td>
            <td width="30%"><span class="style6">貨品描述</span></td>
            <td width="11%" class="style6">儲放位置</td>
            
          </tr>
          
<?$elements_counter=4;
$i=0;
$tab=0;
$bgcolor="#CCCCCC";
while($goods_instockrow = $instockresult->fetchRow(DB_FETCHMODE_ASSOC))          
	{
	//20090409
    //add goods_partno searching caiteria
    if ( ( preg_match("/".$goods_detail."/", $goods_instockrow['goods_detail'], $matches) && $goods_detail!="" ) || $goods_partno==$goods_instockrow['goods_partno'] || (preg_match("/".$goods_partno2."/", $goods_instockrow['goods_partno'], $matches)  && $goods_partno2!="") || $market_price == $goods_instockrow['market_price'])
    {
      $bgcolor="#CCFF##";
    } else {
    	$bgcolor="#CCCCCC";
    }   
	?>
          <tr bgcolor="<?=$bgcolor?>">
            <td><div align="center"><?=$i+1?></div></td>
            <td><input  name="goods_partno[]" type="text" id="goods_partno<?echo $i;?>" value="<? echo $goods_instockrow['goods_partno']; ?>" tabindex="<?$tab++;echo $tab?>" size="15" maxlength="30"  />
            <input type=button name="search" value=".." onClick="javascript:AddrWindow(<?echo $elements_counter;$elements_counter=$elements_counter+7;?>)" >
            <input name="action<?=$i?>" type="button" id="action<?=$i?>"  value="?" /></td>
			<td><div align="center">
			   <input name="box[]" type="text" id="box<?echo $i;?>" tabindex="<?$tab++;echo $tab?>" class="box" value="<? echo $goods_instockrow['box']; ?>" size="6" maxlength="6" >
			 </div></td>
			 
            <td><input name="qty[]" type="text" id="qty<?echo $i;?>"  onfocus="checkQtyPerBox(<?=$i?>)" tabindex="<?$tab++;echo $tab?>"  value="<? echo $goods_instockrow['qty']; ?>" size="7" maxlength="7"></td>
                       
			 
			 <td><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<?echo $i;?>" value="<? echo htmlspecialchars($goods_instockrow['goods_detail']); ?>" size="35" maxlength="40">
            </div></td>
            <td><input name="place[]" type="text" id="place<?echo $i;?>" tabindex="<?$tab++;echo $tab?>" value="<? echo $goods_instockrow['place']; ?>"  size="3" maxlength="3" /></td>
            
          </tr>
		   
<?
$i++;
}
for ($y=$i;$y<$instockRecord;$y++)
{
?>
    <tr bgcolor="#CCCCCC">
            <td><div align="center"><?=$y+1?></div></td>
            <td><input  name="goods_partno[]" type="text" id="goods_partno<?echo $y;?>" value="<? echo $goods_instockrow['goods_partno']; ?>" tabindex="<?$tab++;echo $tab?>" size="15" maxlength="30"  />
            <input type=button name="search" value=".." onClick="javascript:AddrWindow(<?echo $elements_counter;$elements_counter=$elements_counter+7;?>)" >
            <input name="action<?=$i?>2" type="button" id="action<?=$y?>"  value="?" /></td>
            <td><div align="center">
			   <input name="box[]" type="text" id="box<?echo $y;?>" tabindex="<?$tab++;echo $tab?>" class="box" value="0" size="6" maxlength="6" onFocus="javascript:document.getElementById('action<?=$y?>').click();">
			 </div></td>
			<td><input  name="qty[]" type="text" id="qty<?echo $y;?>" onfocus="checkQtyPerBox(<?=$i?>)" tabindex="<?$tab++;echo $tab?>"  value="0" size="7" maxlength="7"></td>
              <td><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<?echo $y;?>" value="" size="35" maxlength="40">
            </div></td>
			 
            
            <td><input name="place[]" type="text" id="place<?echo $y;?>" tabindex="<?$tab++;echo $tab?>"   value="0"  size="3" maxlength="3" /></td>
            
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
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height=""><input type="hidden" name="update" value="3" /><input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" /></td>
        <td><input name="clear" type="reset" id="clear" value="清除">
          <input name="submitb" type="submit" id="submitb" value="更新記錄" >
		  </form></td>
<td>
          <form name="instock_del_form" method="POST" action="/?page=instock&subpage=instock_del.php">
		<input type="hidden" name="instock_no" value="<?echo $instock_no;?>" >
        <input type="submit" name="Submit" value="刪除此項貨品名" onClick="javascript:check_del('<?echo $instock_no;?>')">
        </form> </td>
		   
		
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
      inputField  : "instock_date",         // ID of the input field
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
