<?php
include_once('./include/config.php');
$redirectURL = '/?page=staff&subpage=index.php';
$errors = array();
 if ($_POST['action']=="update"){
	 
	 	$sql="Update staff set role='".$_POST['role']."' ,password='".$_POST['password']."' ,username='".$_POST['username']."' ,name='".$_POST['name']."' ,telno='".$_POST['telno']."', area='".$_POST['area']."' , pc='".$_POST['pc']."' where id=".$_POST['id'];
			$result=$db->query($sql);
			if (DB::isError($result))
	    	  die ($result->getMessage());
 }else if ($_POST['action']=="insert"){
	 if ($_POST['name']!=""){
 	 	$sql=" insert into staff (id,username,name,area,pc,telno,password,role) values ('','".$_POST['username']."','".$_POST['name']."','".$_POST['area']."' ,'".$_POST['pc']."','".$_POST['telno']."','".$_POST['password']."',1) ";
		$result=$db->query($sql);
		if (DB::isError($result))
	      die ($result->getMessage());
	 }
 }
if(count($errors))
{
	echo '<h2>'.join('<br /><br />',$errors).'</h2>';
	exit;
}
 
?><script>
location.href = "<?php echo $redirectURL;?>"; 
</script>