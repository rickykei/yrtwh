<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-TW" lang="zh-TW">
<head>
<link rel="stylesheet" href="../include/member_style.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
<!--
body {
	background-color: #CCCCCC;
}
.style1 {color: #5E5E5E}
-->
</style>

</head>
<body><?php

   include_once("../include/config.php");
   $db = DB::connect($dsn);
    if (DB::isError($connection))
      die($connection->getMessage());
   
   //window connction
   $result = $db->query("SET NAMES 'UTF8'");

  
	$checking=0;
  if ($mem_id=="" && $mem_chi_name=="" && $mem_telno =="")	{
	  		$sql=" SELECT * FROM member a  ";
	  	    $sqlCount= " Select count(*) as total FROM member a ";
	// $sql="SELECT * FROM invoice order by invoice_no desc";
		}else if ($mem_id!="" && $mem_chi_name=="" && $mem_telno ==""){
			$sql=" SELECT * FROM member a where member_id=".$mem_id." ";
		}
		
			

		$sql.=" order by a.id desc ";   

	//cal total count first;
	if ($sqlCount!=""){
	 $result = $db->query($sqlCount);
		 while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$countTotal=$row["total"];
		 }
	}
	//echo $countTotal;
	 
   require "../include/Pager.class.php";

   include('Pager_header.php');

	
 // While there are still rows in the result set, fetch the current
   // row into the array $row
   ?><form name="search" action="memberlist.php" method="POST">
<div><label>客戶ID：</label>
  <input name="mem_id" type="text" class="buttonstyle"  id="mem_id" size="10" maxlength="10" />
</div>
<div><label class="style7">客戶中文名稱：</label>
<input name="mem_chi_name" type="text" class="buttonstyle"  id="mem_chi_name" size="10" maxlength="10" /></div>
<div>
  <label class="style7">客戶電話號碼：</label>
<input name="mem_telno" type="text" class="buttonstyle"  id="mem_telno" size="20" maxlength="20" /></div>



  <input type="submit" name="button" value="查客戶"/></div>

</form><?=$turnover?>
<table  width="100%" bgcolor="#2E2E2E" border="0" cellpadding="1" cellspacing="1">
<TR bgcolor="#5E5E5E" align="center" style="font-weight:bold" >
<TD width="89" height="23" bgcolor="#006633">客戶ID</TD>
<TD width="121" bgcolor="#006633">客戶名稱 </TD>
<TD width="326" bgcolor="#006633">客戶地址 </TD>
<td width="117" bgcolor="#006633">電話號碼 </td>
<TD width="99" bgcolor="#006633">傳真號碼 </TD>
<TD width="66" bgcolor="#006633">貨品種類</TD>
<TD width="60" bgcolor="#006633">級別 </td>
<TD width="241" bgcolor="#006633">備註</TD>
  <TD width="67" bgcolor="#006633">編輯</td>

</TR>

    <?php 
	
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   ?><tr valign="middle" align="center"  <? if($row['creditLevel']=="S"){echo "class='b'\"";echo "onMouseOut=\"this.className='b'\"";}else{ echo "onMouseOut=\"this.className='normal'\"";} ?>   onMouseOver="this.className='highlight'" />
   <td><?=$row['member_id']?></td>
   <td><?=$row['member_name']?></td>
   <td><?=$row['member_add']?></td>
   <td><?=$row['member_tel']?></td>
   <td><?=$row['member_fax']?></td>
   <td><?=$row['member_good_type']?></td>
   <td><?=$row['creditLevel']?></td>
   <td><?=$row['remark']?></td>
   <td><a  href="inmembernameedit.php?member_id=<?=$row['member_id']?>" target="_blank">Edit</a></td>
		 <? }
   ?> 
</table><?php echo $turnover;?>

</body></html>
