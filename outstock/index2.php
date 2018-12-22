<script language="javascript">

 $(function() {
	 ls=Storages.localStorage;
	ls.remove('myItems');
 });
 
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=800,height=600');");
}
</script><?
$outstockRecord=18;		//全張表共有十行記錄
$totalcounter=0;		//預設
//測試己用多少記錄
for ($i=0;$i<$outstockRecord;$i++)
{
	if ($goods_partno[$i]!="")
	$totalcounter++;
}

//連線mysql
	include("./include/config.php");
	$query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

	if (DB::isError($connection))
		die($connection->getMessage());

//解決mysql中文連線
	$result = $connection->query("SET NAMES 'UTF8'");
		if (DB::isError($result))
      		die ($result->getMessage());
		
		 
if ($update==3)
{//edit
  $query="update outstock set outstock_date='$outstock_date', staff_name='$staff_name',to_shop='$to_shop',delivery_method='$delivery_method'  where outstock_no= '$outstock_no'";
    $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  //del goods_stock
   
  $query="delete from goods_outstock where outstock_no =$outstock_no";
    $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  //add goods_stock

    for ($i=0;$i<$totalcounter;$i++)
  {
	$goods_detail_enc[$i]= addslashes($goods_detail[$i]);
   $query="insert into goods_outstock (outstock_no,goods_partno,goods_detail,qty,box,place) ";
   $query.=" values ('$outstock_no','$goods_partno[$i]','$goods_detail_enc[$i]','$qty[$i]','$box[$i]','$place[$i]') ";
   
  
  $result=$connection->query($query);
  	if (DB::isError($result))
  	{
      die ($result->getMessage("OO"));
	  $success=1;
   	}
	}
}
else{
//add

  $query="insert into outstock (outstock_no,outstock_date,entry_date,staff_name,to_shop,delivery_method) ";
  $query.=" values ('$outstock_no','$outstock_date',now(),'$staff_name','$to_shop','$delivery_method')";

  
 
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());

//查詢入貨單編號
  $query="SELECT LAST_INSERT_ID();";
  $result=$connection->query($query);
  if (DB::isError($result)) die ($result->getMessage());
  $row=$result->fetchRow();
  $outstock_no=$row[0];
 
  for ($i=0;$i<$totalcounter;$i++)
  {
   $query="insert into goods_outstock (outstock_no,goods_partno,goods_detail,qty,box,place) ";
   $query.=" values ('$outstock_no','$goods_partno[$i]','$goods_detail[$i]','$qty[$i]','$box[$i]','$place[$i]')";
 
  $result=$connection->query($query);
  	if (DB::isError($result))
  	{
      die ($result->getMessage());
	  $success=1;
   	}
	
  	
  }
   
 
}

 if ($success==0)
	  include_once("./pdf2/pdf_outstock.php");
  
  
?> <SCRIPT LANGUAGE="JavaScript">
popUp("/outstock/pdf/<?=$outstock_no?>.pdf");
//window.location="/?page=outstock&subpage=index.php"; 
</script>
<link href="./include/outstock.css" rel="stylesheet" type="text/css">
 
<table width="880"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CCCC">

  <tr>
    <td>&nbsp;</td>
    <td width="870" align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006666" class="style6">入倉單</td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%"></td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006666">
            <td width="20%" height="21"><span class="style6"> 發票日期 ：</span></td>
            <td width="29%"><span class="style6"><? echo $outstock_date; ?></span></td>
            <td><span class="style6">職員 :</span></td>
            <td><span class="style6"><? echo $staff_name; ?></span></td>
          </tr>
          
        </table></td>
      </tr>
	  <tr bgcolor="#006666" >
            <td width="20%" height="21">
                <span class="style6"> 軍地倉去：</span></td>
            <td width="28%" > 
			<span class="style6"><?php echo $to_shop;?></span>
             </td>
            <td width="17%" ><span class="style6">運送方法 : </span></td>
            <td width="35%" ><span class="style6"><?php echo $delivery_method;?></span></td>
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
			<td width="30%"><span class="style6">箱編號</span></td>
            
          </tr>
<?$elements_counter=4;
for ($i=0;$i<$totalcounter;$i++)          
{
	?>
     <tr bgcolor="#CCCCCC"> 
            <td><div align="center"><? echo $i+1; ?></div></td>
            <td><? echo $goods_partno[$i]; ?></td>
 <td><div align="center"><? echo $box[$i]; ?></div></td>
            <td><? echo $qty[$i]; ?></td>
                     
			
              <td><div align="center"><? echo htmlspecialchars($goods_detail[$i]); ?></div></td>
            <td><? echo $place[$i]; ?></td>
            <td><? echo calOutstockBoxNum($goods_partno[$i],$box[$i],$outstock_no,$connection); ?></td>
     </tr>
<?}?>      </table>          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
                    </td>
      </tr>
      <tr>
        <td height=""><?if ($update!=3){
echo "<a href=\"/?page=outstock&subpage=index.php\">回提貨單頁</a>";
echo "</br>";}
?></td>
        <td height=""><?
		if ($update==3){
echo "<a href=\"/?page=outstock&subpage=outstocklist.php\">回所有提貨單</a>";
echo "</br>";}
?></td>
        <td height=""><input type="hidden" name="AREA" value="<? echo $AREA; ?>" /><input type="hidden" name="PC" value="<? echo $PC; ?>" /></td>
        <td>&nbsp;</td>
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
</form></body>
</html>