 <?php
  
  require_once("./include/config.php");
 
  $instockRecord=18;
 
 
//get Staff name
	$connection = DB::connect($dsn);
	if (DB::isError($connection))
		die($connection->getMessage());
		 $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
	$sql="SELECT * FROM staff";
	$staffResult = $connection->query($sql);
	
?>
  
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/outstock.js"></script>
<link href="./include/outstock.css" rel="stylesheet" type="text/css">
 
 
<form action="/?page=outstock&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="900" height="412" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CCCC">

  <tr>
    <td height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006666" ><span class="style6">提貨單</span></td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006666" >
            <td width="20%" height="21">
                <span class="style6"> <span class="style5">提貨單</span>日期 ：</span></td>
            <td width="28%" ><input name="outstock_date" type="text" id="outstock_date" value=""><input name="cal" id="calendar" value=".." type="button"></td>
            <td width="17%" ><span class="style6">職員 : </span></td>
            <td width="35%" ><select name="staff_name" id="staff_name">
             <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
                echo "<option value=\"".$row['name'];
                echo "\"";
                if ($USER==$row['name'])
           			echo " SELECTED";
                echo ">".$row['name']."</option>";
				}?>
            </select></td>
          </tr>
         <tr bgcolor="#006666" >
            <td width="20%" height="21">
                <span class="style6"> 軍地倉去：</span></td>
            <td width="28%" > 
			<select name="to_shop" id="to_shop">
<option value="自提">自提</option>
            <option value="Y鋪">Y鋪</option>  
			<option value="大海">大海</option>  
            </select></td>
            <td width="17%" ><span class="style6">運送方法 : </span></td>
            <td width="35%" ><select name="delivery_method" id="delivery_method">
              <option value="9456">9456</option>  
			<option value="3819">3819</option>  
			 <option value="6586">6586</option>  
			<option value="897">897</option>  
	 
            </select></td>
          </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#006666">
            <td width="6%"><span class="style6">行數</span></td>
            <td width="20%"><span class="style6">貨品編號</span></td>
			<td width="10%"><span class="style6">儲放位置</span></td>
            <td width="7%"><span class="style6">箱數量</span></td>
			<td width="7%"><span class="style6">裝數量</span></td>
            <td width="30%"><span class="style6">貨品描述</span></td>
            
            
          </tr>
<?$elements_counter=4;

        
for ($i=0;$i<18;$i++)          
{
	?>
          <tr bgcolor="#CCCCCC">
            <td><div align="center"><?= $i+1; ?></div></td>
            <td><input name="goods_partno[]" type="text" xx="<? echo $i; ?>" id="goods_partno<? echo $i; ?>" size="15" maxlength="30" tabindex="<?$tab++;echo $tab?>"  onChange="findPartNoAjax('<?=$i?>')" />
            <input type=button name="search" value=".." onclick="javascript:AddrWindow('<?=$i; ?>')" >
            <input name="action<?=$i?>" type="button" id="action<?=$i?>"  value="?"></td>
			<td>
			<select name="place[]" id="place<? echo $i; ?>" tabindex="<?$tab++;echo $tab?>">
			
			</select>
			</td>
			
			
            <td><div align="center">
			   <input name="box[]" type="text" tabindex="<?$tab++;echo $tab?>" class="box" id="box<? echo $i; ?>" value="0" size="7" maxlength="7" onFocus="checkStock(<?=$i?>)">
			 </div><div id="box<? echo $i; ?>_response"></div></td>
			<td>
			<input type="hidden" id="qty_per_unit<? echo $i; ?>" value="0"/>
			<input type="hidden" id="weight_per_unit<? echo $i; ?>" value="0"/>
			<input type="hidden" id="weight_per_row<? echo $i; ?>" value="0"/>
			<input name="qty[]" type="text" id="qty<? echo $i; ?>"   value="1" size="7" maxlength="7" tabindex="<?$tab++;echo $tab?>" onFocus="checkInputQty(<?=$i?>)" onKeyPress="next_text_box(event,'goods_partno<?=$i+1;?>');">
			
			<div id="qty<? echo $i; ?>_response"></div>
			</td>
            <td><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<? echo $i; ?>" size="35" maxlength="40">
            </div></td>
			 
            
            
            
          </tr>
        
<?}?>
          
        
            
        </table>
          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="5">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#006666">
            <tr>
              <td class="style6"></td>
              <td ><label>
                
              </label></td>
              <td>&nbsp;</td>
              <td></td>
            </tr>
           
             
          </table>        
		  </td>
      </tr>
      <tr>
        <td height="">總重量</td>
        <td height=""><input type="text" id="total_weight" value="0"/></td>
        <td height=""><input type="hidden" name="AREA" value="<? echo $AREA; ?>" /><input type="hidden" name="PC" value="<? echo $PC; ?>" /></td>
        <td><input name="clear" type="reset" id="clear" value="清除">
         <input name="submitb" type="button" id="submitb" value="送出" onClick="checkform()"></td>
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
</form>
 

 
<script type="text/javascript">

Calendar.setup(
    {
      inputField  : "outstock_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
 
 

</script>
 