<? 
   $flag=0;
   require_once("../include/config.php");
   
   $connection = DB::connect($dsn);
   if (DB::isError($connection)) die($connection->getMessage());
   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());

   $query="select * from member where member_id='$member_id'";
   $result=mysql_query($query);
   $row= mysql_fetch_array ($result);
   if ($row["member_id"]!=null)
   $flag=1;
   
   
   
   if ($flag==1)
   {
	   
    $errMsg="[此項 客戶編號 已於早前被輸入資料庫]";
   }
   else
   {

  
       
    $query="insert into member (member_id,member_name,member_add,member_tel,member_fax,member_good_type,creditLevel,transportLevel,remark) values ('$member_id','$member_name','$member_add','$member_tel','$member_fax','$member_good_type','$creditLevel','$transportLevel','$remark')";
  
      
      if (mysql_query($query))
	  	$alertMsg= "己經存入";
	  else
       	$errMsg= "不能成功存入資料庫";
      

  }
?>
<script language="javascript">
<? if ($alertMsg!=""){ 	?>
alert('<?=$alertMsg?>');
window.location.href = "inmembername.php"
<? }else{ ?>
alert('<?=$errMsg?>');
history.back();
<? } ?>
</script>