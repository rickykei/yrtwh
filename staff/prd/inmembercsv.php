<?if ($update!="1"){
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="../include/invoice_style.css" type="text/css">
<title>會員excel</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #CCCCCC;
}

-->
</style>
</head>
<body>
<form id="form1" name="form1" method="post" action="inmembercsv.php">
  <input type="submit" value="submit"/>
  <input type="hidden" name="update" value="1"/>

</form>

</html>
<? }else{
header("Content-type:application/vnd.ms-excel");
header("Content-Disposition:filename=test.xls");
//header("Content-type:application/vnd.ms-excel;charset=utf-8");
//header("Content-Disposition:filename=test.xls");
  include_once("../include/config.php");
$db = DB::connect($dsn);
   if (DB::isError($connection))
      die($connection->getMessage());
	$result = $db->query("SET NAMES 'UTF8'");
   // (Run the query on the winestore through the connection
 $sql="select * from member order by id";
	 ?> <table>
<tr><td>id</td><td>member_id</td><td>member_name</td><td>member_add</td><td>member_tel</td><td>member_fax</td><td>member_good_type</td><td>member_transport</td><td>  	member_level</td><td>creditLevel</td><td>transportLevel</td><td>remark</td></tr><?
	 $result = $db->query($sql);
	 while ($row = $result->fetchRow(DB_FETCHMODE_ASSOC))
	 {
	 	echo "<tr><td>".$row["id"]."</td><td>".$row["member_id"]."</td><td>".$row["member_name"]."</td><td>".$row["member_add"]."</td><td>".$row["member_tel"]."</td><td>".$row["member_fax"]."</td><td>".$row["member_good_type"]."</td><td>".$row["member_transport"]."</td><td>".$row["member_level"]."</td><td>".$row["creditLevel"]."</td><td>".$row["transportLevel"]."</td><td>".$row["remark"]."</td></tr>";
		
	 }
	 ?></table><?
}
?>
