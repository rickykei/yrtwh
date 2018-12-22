 
<?
 include_once("./include/config.php");
    $connection = DB::connect($dsn);
echo $outstock_no;
$query="delete from outstock where outstock_no=\"$outstock_no\"";
if (!mysql_query($query))
die(mysql_error());
else{
		$query="delete from goods_outstock where outstock_no=\"$outstock_no\"";
			if (!mysql_query($query))
			die(mysql_error());
			else
			echo "貨單已被刪除";
}

?>

<SCRIPT LANGUAGE="JavaScript">
window.location="/?page=outstock&subpage=outstocklist.php";
</script>
 
