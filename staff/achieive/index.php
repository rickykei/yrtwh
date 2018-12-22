<?php
require "../include/Pager.class.php";
if ( isset($_GET['page']) )
{
   $page = (int)$_GET['page'];
}
else
{
   $page = 1;
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-TW" lang="zh-TW">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body><?php
   include_once("../include/config.php");
   $query="SET NAMES 'UTF8'";
    $db = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());
 $result = $db->query("SET NAMES 'UTF8'");
   // (Run the query on the winestore through the connection
   if ($memberId!="")
   $sql="SELECT * FROM member where member_id=".$memberId." order by member_id";
   else
   $sql="SELECT * FROM member order by member_id";
   $pager_option = array(
       "sql" => $sql,
       "PageSize" => 10,
       "CurrentPageID" => $page
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
   $turnover = "<a href='?page=1&numItems=".$pager->numItems."'>首頁</a>|<a href='?page=".$pager->PreviousPageID."&numItems=".$pager->numItems."'> 上一頁</a>|";
}
if ( $pager->isLastPage )
{
   $turnover .= "下一頁|尾頁";
}
else
{
   $turnover .= "<a href='?page=".$pager->NextPageID."&numItems=".$pager->numItems."'> 下一頁</a>|<a href='?page=".$pager->numPages."&numItems=".$pager->numItems."'> 尾頁</a>";
}?>
 <form id="form1" method="post" action="index.php">  <?
echo $turnover;

   // While there are still rows in the result set, fetch the current
   // row into the array $row
   ?>


     <input type="text" name="memberId" />
  
    <input type="submit" name="Submit" value="Submit" />
  
  </form>
<table width="835" border=1><TR><TD width="23">ID</TD>
<TD width="87">MEMBER ID </TD>
<TD width="66">MEMBER NAME </TD>
<td>MEMBER ADDRESS </td>
<TD width="78">MEMBER TEL </TD>
<TD width="73">MEMBER FAX </TD>
<TD width="62">MEMBER TYPE </TD>
<TD width="58">MEMBER TRANSPORT </TD>
<TD width="44">MEMBER LEVEL </TD>
<TD width="44">Edit</TD>
</TR>
    <?php 
	for ($i=0;$i<count($result);$i++)
	{ $row=$result[$i];
	
   echo "<tr>";
         echo "<td>".$row['id']."</td><td>".$row['member_id']."</td><td>".$row['member_name']."</td><td>".$row['member_add']."</td><td>".$row['member_tel']."</td><td>".$row['member_fax']."</td><td>".$row['member_good_type']."</td><td>".$row['transportLevel']."</td><td>".$row['creditLevel']."</td><td><a href='inmembernameedit.php?member_id=".$row['member_id']."&update=2'>edit </a></td></tr>";

		 }
   ?>
</table>
<?php echo $turnover;?>
</body></html>
