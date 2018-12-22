<?

$member_id = $_POST['member_id']; // get the username
$member_id = trim(htmlentities($member_id)); // strip some crap out of it

echo check_username($member_id); // call the check_username function and echo the results.

function check_username($member_id){
	
	require_once("../include/config.php"); 
	 $connection = DB::connect($dsn);
   if (DB::isError($connection)) die($connection->getMessage());
   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());

   $query="select count(*) as member_id from member where member_id like '$member_id'";
  
   $result=mysql_query($query);
   $row= mysql_fetch_array ($result);
   if ($row["member_id"] >0 ){
			return '<span style="color:#f00">己有此客戶編號</span>';
   }else{
	
   return '<span style="color:#0c0">OK</span>';
   }
}
?>
