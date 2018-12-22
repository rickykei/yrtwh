<?php
  include_once("./include/config.php");

if ( isset($_GET['pagenum']) )
{
   $pagenum = (int)$_GET['pagenum'];
}
else
{
   $pagenum = 1;
} ?>
 <script language="javascript">

function typeSelectSubmit()

{

	document.typeForm.submit();

}

</script>

<?php
 
 
 	$result = $db->query("SET NAMES 'UTF8'");
 
 
 	//get type
 	$sqlType="select * from type";
	$resType=$db->query($sqlType);
	
	
   // (Run the query on the winestore through the connection

   
 if ($goods_partno!="")
	  $sql="select * from sumgoods where goods_partno like '".$goods_partno."' order by id desc";
	  else if ($typeSelect!="")
      $sql="select * from sumgoods where model='".$typeSelect."' order by id desc";
	  else
      $sql="SELECT * FROM sumgoods order by id desc";
   
   
   include_once("./include/Pager.class.php");
   
   $pager_option = array(
       "sql" => $sql,
       "PageSize" => 10,
       "CurrentPageID" => $pagenum
);


if ( isset($_GET['numItems']) )
{
   $pager_option['numItems'] = (int)$_GET['numItems'];
}
$pager = @new Pager($pager_option);
$result = $pager->getPageData();

if ( $pager->isFirstPage )
{
   $turnover = "第一頁|上一頁|";
}
else
{
   $turnover = "<a href='/?page=ingood&subpage=index.php&pagenum=1&typeSelect=".$typeSelect."&numItems=".$pager->numItems."'>首頁</a>|<a href='/?page=ingood&subpage=index.php&pagenum=".$pager->PreviousPageID."&typeSelect=".$typeSelect."&numItems=".$pager->numItems."'> 上一頁</a>|";
}
if ( $pager->isLastPage || $pager->NextPageID=="")
{
   $turnover .= "下一頁|尾頁";
}
else
{
   $turnover .= "<a href='/?page=ingood&subpage=index.php&pagenum=".$pager->NextPageID."&typeSelect=".$typeSelect."&numItems=".$pager->numItems."'> 下一頁</a>|<a href='/?page=ingood&subpage=index.php&pagenum=".$pager->numPages."&typeSelect=".$typeSelect."&numItems=".$pager->numItems."'> 尾頁</a>";
}

?>

<form method="post" name="typeForm" action="/?page=ingood&subpage=index.php">
<?=$turnover?>

<select name="typeSelect" onchange="javascript:typeSelectSubmit()"><option value="">ALL</option><? while($rowType = $resType->fetchRow(DB_FETCHMODE_ASSOC))
{?>
  <option value="<?=$rowType['typeName']?>"  <? if($typeSelect==$rowType['typeName']) {echo "selected";}?>><?=$rowType['typeName']?></option>
<?
}
?>
</select>

<input type="text" name="goods_partno" />
<input type="button" name="button" onclick="javascript:typeSelectSubmit()" />
</form>
  
  
<table width="763" border=1><TR><TD width="45">ID</TD>
<TD width="184">貨品編號</TD>
<TD width="259">貨品名</TD>
<TD width="81">售價</TD>
<TD width="100">種頪</TD>
<TD width="26">EDIT</TD>
<TD width="26">DEL</TD>
</TR>
    <?php 
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
?><tr><td><?=$row['id']?></td><td><?=$row['goods_partno']?></td><td><?=$row['goods_detail']?></td><td><?=$row['market_price']?></td><td><?=$row['model']?></td>
      <TD><a href="/?page=ingood&subpage=ingoodnameedit.php&goods_partno=<?=$row['goods_partno']?>&amp;update=2">EDIT</a></TD>
      <td>DEL</td>
    </tr>
<?
		 }
   ?>
   </table>
<?php echo $turnover;?>
 
