<link rel="stylesheet" href="./include/staff_style.css" type="text/css">
<script type="text/javascript" src="./include/thickbox.js"></script>
<link rel="stylesheet" href="./include/thickbox.css" type="text/css" media="screen" />

<p>
  <?
  include_once("./include/config.php");

  if (!($AREA=="Y" && $PC=="99") && !($AREA=="Y" && $PC=="1") ){
   $db="";
  }else{
	     
  }
  
  
	$checking=0;
  if ($mem_id=="" && $mem_chi_name=="" && $mem_telno =="")	{
	  		$sql="SELECT * FROM staff ";
	  	    $sqlCount= " Select count(*) as total FROM member  ";
	// $sql="SELECT * FROM invoice order by invoice_no desc";
		}else if ($mem_id!="" && $mem_chi_name=="" && $mem_telno ==""){
			$sql="SELECT * FROM staff order by area";
		}
		
			

		$sql.=" order by area  ";   

	//cal total count first;
	if ($sqlCount!=""){
	 $result = $db->query($sqlCount);
		 while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$countTotal=$row["total"];
		 }
	}
	 
   require_once "./include/Pager.class.php";

   include_once('./staff/Pager_header.php');

 
   ?>
<fieldset> 
<legend><a href="../" >員工設定</a></legend>  
<table  width="100%" bgcolor="#2E2E2E" border="0" cellpadding="1" cellspacing="1">
<TR bgcolor="#5E5E5E" align="center" style="font-weight:bold" >
<TD width="89" height="23" bgcolor="#CC6666">員工ID</TD>
<TD width="121" bgcolor="#CC6666">員工名稱 </TD>
<TD width="326" bgcolor="#CC6666">分店</TD>
<TD width="326" bgcolor="#CC6666">機號</TD>
<TD width="326" bgcolor="#CC6666">電話</TD>
<TD width="326" bgcolor="#CC6666">更改</TD>

</TR>

    <?php 
	
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   ?><tr valign="middle" align="center"   onMouseOut="this.className='normal'"   onMouseOver="this.className='highlight'"  />
   <td class="staff2">
     
     <?=$row['username']?>
    </td>
   <td class="staff2">
   
     <?=$row['name']?>
    </td>
   <td class="staff2">
    
     <?=$row['area']?>
    </td>
   <td class="staff2">
   
     <?=$row['pc']?>
     </td>
    <td class="staff2">
   
     <?=$row['telno']?>
     </td>
   <td class="staff2"><a  href="/?page=staff&subpage=edit.php&id=<?=$row['id']?>"   title="" >Edit</a></td>
		 <? }
   ?> 
</table>

  
<a href="/?page=staff&subpage=edit.php" title=""   />加新員工</a>
</fieldset>
 