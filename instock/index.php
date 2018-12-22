 <?php
 
  require_once("./include/config.php");
 
  $instockRecord=18;


	
//get Supplier name
	$connection = DB::connect($dsn);
	if (DB::isError($connection))
		die($connection->getMessage());
	

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
<script type="text/javascript" src="./include/instock.js"></script>
<link href="./include/instock.css" rel="stylesheet" type="text/css">
 
 
<form action="/?page=instock&subpage=index2.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="900" height="412" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CCCC">

  <tr>
    <td height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006666" ><span class="style6"><a href="../">入倉單</a></span></td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006666" >
            <td width="20%" height="21">
                <span class="style6"> <span class="style5">入倉單</span>日期 ：</span></td>
            <td width="28%" ><input name="instock_date" type="text" id="instock_date" value=""><input name="cal" id="calendar" value=".." type="button"></td>
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
         
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#006666">
            <td width="6%"><span class="style6">行數</span></td>
            <td width="24%"><span class="style6">貨品編號</span></td>
            <td width="7%"><span class="style6">箱數量</span></td>
			<td width="7%"><span class="style6">裝數量</span></td>
            <td width="30%"><span class="style6">貨品描述</span></td>
            <td width="11%" class="style6">儲放位置</td>
            
          </tr>
<?
$elements_counter=4;

        
for ($i=0;$i<18;$i++)          
{
	?>
          <tr bgcolor="#CCCCCC">
            <td><div align="center"><?= $i+1; ?></div></td>
            <td><input name="goods_partno[]" type="text" id="goods_partno<? echo $i; ?>" size="15" maxlength="30" tabindex="<?$tab++;echo $tab?>" onKeyPress="next_text_box(event,'qty<?=$i;?>')" />
            <input type="button" name="search" value=".." onclick="javascript:AddrWindow('<?=$i; ?>')" >
            <input name="action<?=$i?>" type="button" id="action<?=$i?>"  value="?"></td>
            <td><div align="center">
			   <input name="box[]" type="text" tabindex="<?$tab++;echo $tab?>" class="box" id="box<? echo $i; ?>" value="0" size="7" maxlength="7" >
			 </div></td>
			<td><input name="qty[]" type="text" id="qty<? echo $i; ?>"   value="1" size="7" maxlength="7" tabindex="<?$tab++;echo $tab?>" onfocus="checkQtyPerBox(<?=$i?>)"></td>
            <td><div align="center">
              <input name="goods_detail[]" type="text" id="goods_detail<? echo $i; ?>" size="35" maxlength="40">
            </div></td>
			 
            <td><input name="place[]" type="text" id="place<? echo $i; ?>" tabindex="<?$tab++;echo $tab?>" value="" size="3" maxlength="3" /></td>
            
            
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
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
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
</table><?
for ($i=0;$i<$instockRecord;$i++)
 {?>

<input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="Y"/>

<? }?>
</form>
 

 
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
 