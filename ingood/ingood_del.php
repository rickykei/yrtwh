 
<?
 include_once("./include/config.php");
    $connection = DB::connect($dsn);
echo $instock_no;
$query="delete from sumgoods where goods_partno=\"$goods_partno\"";
if (!mysql_query($query))
die(mysql_error());
else
echo "入貨單已被刪除";

?>

<SCRIPT LANGUAGE="JavaScript">
window.location="/?page=ingood&subpage=ingood_list.php";
</script>
 
