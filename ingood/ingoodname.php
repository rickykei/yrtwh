<? 

 include_once("./include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    $result = $connection->query("SET NAMES 'UTF8'");

if ($add==1) //after submit
  {
   $flag=0;
  
      
   $query="select * from sumgoods where goods_partno='$goods_partno'";
   $result=mysql_query($query);
   $row= mysql_fetch_array ($result);
   if ($row["goods_partno"]!=null)
   $flag=1;
   
   
   
   if ($flag==1)
   {
    $message="此項partno已於早前被輸入資料庫";
   }
   else
   {
 
    $query="insert into sumgoods (box_label_start_num,weight, qty_per_unit,goods_partno,     goods_detail, market_price,allstock,status,admin_view,remark,model,model2,model3,model3_x,model3_y,unitid,inshop_quota,inshop_box,sell_out_qty,sell_out_unit,thereafter_price,thereafter_qty,market_price_door,buy_in_unit,pos_label) values 
								($box_label_start_num,$weight,$qty_per_unit,'$goods_partno','$goods_detail',0          ,0       ,'Y'   ,'N','$remark','$model','$model2','$model3','$model3_x','$model3_y','$unitid','$inshop_quota','$inshop_box','$sell_out_qty','$sell_out_unit','$thereafter_price','$thereafter_qty','$market_price_door','$buy_in_unit','$pos_label')";
	 

	 
      if (mysql_query($query)){
		   $message="Success!";  
		   if ($partno_sub!=""){
			
			 
			$partno_sub_arr = explode(",", $partno_sub);
			$partno_sub_qty_arr = explode(",", $partno_sub_qty);
		 
		 
			//delete from master code on mix table
			 $query="delete from sumgoods_mix where partno_src='$goods_partno'";
			  if (mysql_query($query))
				    $message=="資料已經更生";
		
			//insert mix table
			for ($i=0;$i<count($partno_sub_arr);$i++){
			$query="insert into sumgoods_mix (partno_src,partno_sub,qty,sts) values ('$goods_partno','".$partno_sub_arr[$i]."','".$partno_sub_qty_arr[$i]."','Y')";
			 mysql_query($query);
			 
			 
			 //update sumgood subcode to slave
			 $query="update sumgoods set mix='S' where goods_partno='".$partno_sub_arr[$i]."'";	  
			 
			  mysql_query($query);
			}
			
			
	   }
	  }else {
		    $message="Too Bad!".mysql_error() ;
	  }
     
   }

}else
{
 
}
    //find out model type

   $unitResult = $connection->query("SELECT id,unit_name_chi FROM unit");
   
   if (DB::isError($unitResult))
     die ($unitResult->getMessage());
  
  $i=0;
  	while ($unitrow = $unitResult->fetchRow(DB_FETCHMODE_ASSOC))
	{
		$unit_arr[$i]['id']=$unitrow['id'];
		$unit_arr[$i]['chi_name']=$unitrow['unit_name_chi'] ;
		
		 
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
 
 
<LINK REL=stylesheet HREF="../ingood/english.css" TYPE="text/css">
<STYLE TYPE="text/css">
h1 {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"}
h2 {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"}
li { line-height: 14pt }
input, textarea,select {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 12px}

.login       { background-color: #CCCCCC; color: #000000; font-size: 9pt; border-style: solid; 
               border-width: 1px }
small {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt; line-height: 14pt}
p { font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt ;font-color: #FFFFFF}
.style3 {font-size: 9pt; border-style: solid; border-width: 1px; background-color: #CCCCCC;}
.style6 {color: #FFFFFF}
.style8 {color: #FFFFFF; font-size: 14px; }
</STYLE>

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
</script><link href="./include/invoice.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style11 {font-size: xx-small}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body >

<table width="900"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CC99">
  <tr>
    <td width="4" height="">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006633"><span class="style6">入貨名</span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%"><span class="style2"><? echo "$message"?></span></td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="">
        <td height="24" colspan="4">
<form name="ingoodnameform" method="post" action="/?page=ingood&subpage=ingoodname.php">

  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor=""> 
      <input type="hidden" name="add" value=1 class="login">
      <td width="15%" bgcolor="#669933"><font size="3" face="新細明體" class="style8">貨品編號：</font></td>
      <td width="85%" bgcolor="#669933" withd="86%"> 
        <input name="goods_partno" type="text">
        </td>
    </tr>
    <tr bgcolor=""> 
      <td width="15%" bgcolor="#669933"><font size="3" face="新細明體" class="style8">貨品描述：</font></td>
      <td width="85%" bgcolor="#669933"> 
        <textarea name="goods_detail" cols="50" rows="4" ></textarea>
      </td>
    </tr>
    <tr bgcolor="#666666"> 
      <td width="15%" bgcolor="#669933"><font size="3" face="新細明體" class="style8">裝數：</font></td>
      <td width="85%" bgcolor="#669933"> 
        <input type="text" id="qty_per_unit" name="qty_per_unit" value="" >
      </td>
    </tr>
    <tr  bgcolor="#669933"> 
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
      </td>
   
     </tr>
       
	   <tr bgcolor="#666666"> 
        <td width="113" bgcolor="#669933"><font  size="2" face="新細明體" class="style6">重量:</font></td>
        <td width="275" bgcolor="#669933"> 
        <input type="text" name="weight" maxlength="9"   value="<?=$row["weight"];?>"/>
         </td>
        <td width="142" bgcolor="#669933">&nbsp;</td>
        <td width="346" >&nbsp;</td>
      </tr>
	<tr bgcolor="#666666"> 
        <td width="113" bgcolor="#669933"><font  size="2" face="新細明體" class="style6">箱數起始號:</font></td>
        <td width="275" bgcolor="#669933"> 
        <input type="text" name="box_label_start_num" maxlength="9"   value="<?=$row["box_label_start_num"];?>"/>
         </td>
        <td width="142" bgcolor="#669933">&nbsp;</td>
        <td width="346" >&nbsp;</td>
      </tr>
	     <tr bgcolor="#666666"> 
      <td width="15%" bgcolor="#669933" ><font face="新細明體" size="3"  class="style8">種類1：</font></span></td>
      <td width="85%" bgcolor="#669933"> 
        <select name="model" id="model">
		<option> </option>
		<? while ($typerow = $type0Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		 
	echo "<option value=\"".$typerow['typeName']."\">".$typerow['typeName']."</option>";
    }?>
        </select>
      </td>
    </tr>
        <tr bgcolor="#666666"> 
      <td width="15%" bgcolor="#669933" ><font face="新細明體" size="3"  class="style8">種類2：</font></span></td>
      <td width="85%" bgcolor="#669933"> 
        <select name="model2" id="model2">
		<option> </option>
		<? while ($typerow1 = $type1Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		 
	echo "<option value=\"".$typerow1['typeName']."\">".$typerow1['typeName']."</option>";
    }?>
        </select>
      </td>
    </tr>
	  <tr bgcolor="#666666"> 
      <td width="15%" bgcolor="#669933" ><font face="新細明體" size="3"  class="style8">種類3：</font></span></td>
      <td width="85%" bgcolor="#669933"> 
        <select name="model3" id="model3">
		<? while ($typerow2 = $type2Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
		 
	echo "<option value=\"".$typerow2['typeName']."\">".$typerow2['typeName']."</option>";
    }?>
        </select>
      </td>
    </tr>
		 <tr bgcolor="#666666"> 
      <td width="15%" bgcolor="#669933" ><font face="新細明體" size="3"  class="style8">種類3 x：</font></span></td>
      <td width="85%" bgcolor="#669933"> 
         <input type="text" name="model3_x">
      </td>
    </tr>
	 <tr bgcolor="#666666"> 
      <td width="15%" bgcolor="#669933" ><font face="新細明體" size="3"  class="style8">種類3 y：</font></span></td>
      <td width="85%" bgcolor="#669933"> 
        <input type="text" name="model3_y">
      </td>
    </tr>
	 <tr bgcolor="#666666"> 
      <td width="15%" bgcolor="#669933" ><font face="新細明體" size="3"  class="style8">POS 貨名：</font></span></td>
      <td width="85%" bgcolor="#669933"> 
        <input type="text" name="pos_label">
      </td>
    </tr>
    <tr bgcolor="#006666"> 
      <td width="15%" bgcolor="#669933">&nbsp;</td>
      <td width="85%" bgcolor="#669933"><span class="style6"><input type="submit" name="submit" onclick="JavaScript:checkform();"/> 
      </span></td>
    </tr>
  </table>

</form></td>
      </tr>

    
    </table>     </td>
  </tr>
</table>

