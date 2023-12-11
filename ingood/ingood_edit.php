<?
   include_once("./include/config.php");
    $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
   $query="SET NAMES 'UTF8'";
 $result1=mysql_query($query);

if ($update==1)
  {
   $goods_detail=addslashes($goods_detail);
   
    
   $query="update sumgoods set inshop_quota='$inshop_quota', box_label_start_num='$box_label_start_num',status='Y', goods_detail='$goods_detail',  unitid='$unitid', qty_per_unit=$qty_per_unit,weight=$weight,pos_label='$pos_label' ,model='$model',model2='$model2',model3='$model3' ,model3_x='$model3_x' ,model3_y='$model3_y' where goods_partno='$goods_partno'";
	 
	  
	 
   if (mysql_query($query))
   $string="資料已經更生";
   else
   $string="Too Bad!";
   $update=0;
   
	  

   } 
    else
   {
   
   $query="select * from sumgoods where id='$id'";
 
 
   
   $result=mysql_query($query);
   $result2=mysql_query($query2);
   $result3=mysql_query($query3);
   $result4=mysql_query($query4);
   if (!empty($result))
   $row= mysql_fetch_array ($result);
   if (!empty($result2))
   $row2=mysql_fetch_array ($result2);
   if (!empty($result3))
   $row3=mysql_fetch_array ($result3);
	if (!empty($result4))
   $row4=mysql_fetch_array ($result4);
   
  
   

	}
   $unitResult = $connection->query("SELECT id,unit_name_chi ,unit_cd FROM unit");
   
   if (DB::isError($unitResult))
     die ($unitResult->getMessage());
  
  $i=0;
  	while ($unitrow = $unitResult->fetchRow(DB_FETCHMODE_ASSOC))
	{
		$unit_arr[$i]['id']=$unitrow['id'];
		$unit_arr[$i]['chi_name']=$unitrow['unit_name_chi'] ;
		$unit_arr[$i]['unit_cd']=$unitrow['unit_cd'] ;
		 
		$i++;
    }
  
  
		 $type0Result = $connection->query("SELECT * FROM type where level='0'");
      if (DB::isError($type0Result))
      die ($type0Result->getMessage());
  
   $type1Result = $connection->query("SELECT * FROM type where level='1'");
    if (DB::isError($type1Result))
      die ($type1Result->getMessage());
  
   $type2Result = $connection->query("SELECT * FROM type where level='2'");
    if (DB::isError($type2Result))
      die ($type2Result->getMessage());
  
?> 
 
<link href="./include/invoice.css" rel="stylesheet" type="text/css">
 
<script language="JavaScript">
function checkform()
{
	if(document.ingoodnameform.goods_detail.value == "")
	{
	alert ("請輸入貨品編號.");
	document.ingoodnameform.goods_detail.focus();
	}else
	{
        document.ingoodnameform.submit();
        }

}

function check_del(aa)
{
 alert('刪除2 '+ aa);
     document.ingood_del_form.submit();
}

</script>
 
<div align="center">
<table width="900"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CC99">
  <tr>
    <td width="4" height="">&nbsp;</td>
    <td align="center" valign="top">
    <table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006633"><span class="style6"><a href="/?page=ingood&subpage=ingood_list.php">更改入貨名</a></span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">  <span class="style2"><? echo "$string"?></span></td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#669933">
        <td height="24" colspan="4">
  <table width="100%"  border="0" align="center" cellpadding="2" cellspacing="0" bgcolor="">
    
   
    <form name="ingoodnameform" method="post" action="/?page=ingood&subpage=ingood_edit.php">
      <tr bgcolor="#999999"> 
        <td width="113" align="left"> 
          <font face="新細明體" color="#FFFFFF" size="2"> 
            <input type="hidden" name="update" value=1 >
            <span class="style6">貨品編號:</span></font>         </td>
        <td width="275"> 
          <span class="style6"><? echo $row["goods_partno"];?> </span>  <input type="hidden" name="goods_partno" value="<? echo $row["goods_partno"];?>">     </td>
        <td width="142"> 
          <div align="right"></div>        </td>
        <td width="346">&nbsp;        </td>
      </tr>
      <tr bgcolor="#999999"> 
        <td width="113"> 
        <div class="style6"><font face="新細明體" color="#FFFFFF" size="2">貨品描述:</font></div>        </td>
        <td colspan="3"> 
        <textarea name="goods_detail" cols="50" rows="8" class="login"><? $goods_detail=stripslashes($row["goods_detail"]); echo $goods_detail;?></textarea>        </td>
      </tr>
     
       
       <tr  bgcolor="#999999"> 
      <td  ><font size="3" face="新細明體" class="style6">單位：</font></td>
      <td  > 
        <select name="unitid" id="unitid">
		<? for ($i=0;$i<count($unit_arr);$i++)
		 {
		 
	echo "<option value=\"".$unit_arr[$i]['id']."\"";
	$unitid=stripslashes($row["unitid"]); 
	if ($unitid==$unit_arr[$i]['id'])
	echo " selected ";
	echo ">".$unit_arr[$i]['chi_name']."</option>";
    }?>
        </select>
      </td><td></td><td></td>
    </tr>
       
	  
	  
	 
	     <tr bgcolor="#999999"> <td color="#FFFFFF" size="2" class="style6"> 1單幾件:</td><td colspan="3"><input class="login" type="text" name="qty_per_unit" value="<?=$row["qty_per_unit"];?>"/>
	  </td></tr>
	  	   
	 
	     <tr bgcolor="#999999">
		 <td color="#FFFFFF" size="2" class="style6"> 重量:</td><td colspan="3"><input class="login" type="text" name="weight" value="<?=$row["weight"];?>"/>
	  </td></tr>
	  
	  <tr bgcolor="#999999"> 
        <td width="113"  color="#FFFFFF">
		<font  size="2" class="style6">箱數起始號:</font></td>
        <td width="275"   color="#FFFFFF"> 
        <input type="text" name="box_label_start_num" maxlength="9"   value="<?=$row["box_label_start_num"];?>"/>
         </td>
        <td width="142"  >&nbsp;</td>
        <td width="346"   >&nbsp;</td>
      </tr>
	    
	   <tr bgcolor="#999999"> 
        <td width="113"> 
        <div align="left" class="style6">種類:</div>        </td>
        <td width="275">   <select name="model" id="model">
		<? 

	  while ($type0row = $type0Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		 
	echo "<option value=\"".$type0row['typeName']."\"";
	$model=stripslashes($row["model"]); 
	if ($model==$type0row['typeName'])
	echo " selected ";
	echo ">".$type0row['typeName']."</option>";
    }?>
        </select>                </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>   
	  
  <tr bgcolor="#999999"> 
        <td width="113"> 
        <div align="left" class="style6">種類2:</div>        </td>
        <td width="275">   <select name="model2" id="model2">
		<? 

	  while ($type1row = $type1Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		 
	echo "<option value=\"".$type1row['typeName']."\"";
	$model2=stripslashes($row["model2"]); 
	if ($model2==$type1row['typeName'])
	echo " selected ";
	echo ">".$type1row['typeName']."</option>";
    }?>
        </select>                </td>
        <td width="142"></td>
        <td width="346">&nbsp;</td>
      </tr>  
  <tr bgcolor="#999999"> 
        <td width="113"> 
        <div align="left" class="style6">種類3:</div>        </td>
        <td width="275">   <select name="model3" id="model3">
		<? 

	  while ($type2row = $type2Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		 
	echo "<option value=\"".$type2row['typeName']."\"";
	$model3=stripslashes($row["model3"]); 
	if ($model3==$type2row['typeName'])
	echo " selected ";
	echo ">".$type2row['typeName']."</option>";
    }?>
        </select>                </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>  

	  
	  <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">種類3 x:</font></td>
        <td width="275"> 
        <input type="text" name="model3_x" maxlength="9" class="login" value="<?=$row["model3_x"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	  
	  <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">種類3 y:</font></td>
        <td width="275"> 
        <input type="text" name="model3_y" maxlength="9" class="login" value="<?=$row["model3_y"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	   <tr bgcolor="#999999"> 
        <td width="113"><font color="#FFFFFF" size="2" face="新細明體" class="style6">POS 貨名:</font></td>
        <td width="275"> 
        <input type="text" name="pos_label" maxlength="10" class="login" value="<?=$row["pos_label"];?>"/>
              </td>
        <td width="142">&nbsp;</td>
        <td width="346">&nbsp;</td>
      </tr>
	  
	    <tr bgcolor="#999999"> <td  color="#FFFFFF" size="2" class="style6"> 入舖備用量</td><td colspan="3" ><input class="login" type="text" name="inshop_quota" value="<?=$row["inshop_quota"];?>"/>
	  </td></tr>
	  
	  <tr> 
        <td width="113">&nbsp;</td>
        <td width="275" height="20" align="left" valign="middle"> 
		<input type="hidden" name="goods_partno"   value="<?echo $row["goods_partno"];?>" >
          <input type="submit" name="Submit3" value="更新記錄" onClick="javascript:checkform();">
        <input type="reset" name="Submit2" value="清除" ></td>
      
        <td width="142"></td>
        <td width="346">&nbsp;</td>
      </tr>
	  
	 
	  
	  </form> 
      <tr> 
        <td width="113"></td>
        <td valign="bottom" width="275">&nbsp;        </td>
        <td width="142">
		<form name="ingood_del_form" method="POST" action="/?page=ingood&subpage=ingood_del.php">
		<input type="hidden" name="goods_partno" value="<?echo $row["goods_partno"];?>" >
        <input type="submit" name="Submit" value="刪除此項貨品名" onClick="javascript:check_del('<?echo $goods_partno;?>')">
        </form></td>
        <td width="346">&nbsp;</td>
      </tr>
  </table></td>
      </tr>
</table>     </td>
  </tr>
</table>
  <strong><font face="新細明體" color=#FFFFFF size="3"> </font> </font> </strong> 
</div>

  <p>&nbsp; </p>
  <p>&nbsp;</p>
  <p>&nbsp; </p>
  <p>&nbsp;</p>
  

  
  
 
