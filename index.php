<?php
 //or, if you DO want a file to cache, use:
session_cache_limiter('private_no_expire:');
session_start();

 global $UNAME;
 global $USER;
 global $UROLE;
 global $PC;
 global $AREA;
 define("ADMIN_ROLE", 1); 
  $UNAME=$_SESSION['username'];
	$UROLE=$_SESSION['userrole'];
	$USER=$_SESSION['name'];
	$AREA=$_SESSION['area'];
	$PC=$_SESSION['pc'];
	
	
 include_once('./include/db.class.php');
 include_once('./include/function.php');
 include_once('./include/config2.php');
 include_once('./include/user.class.php');
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<title>
<?php 
if ($page=='invoice' && substr($subpage,0,4)=='inde')
echo '出貨單';
if ($page=='invoice' && substr($subpage,0,10)=='invoice_ed')
echo '更改出貨單';
if ($page=='invoice' && $subpage=='invoicelist.php')
echo '所有出貨單';
if ($page=='invoice' && $subpage=='invoicelist_amend.php')
echo '所有更改出貨單';
if ($page=='invoice_void' )
echo '取消出貨單';
if ($page=='invoice_risk' )
echo '出貨單<高風險>';
if ($page=='ingood' )
echo '入貨名';
if ($page=='instock' )
echo '入倉單';
if ($page=='inshop' )
echo '入舖單';
if ($page=='invoice_scrap' )
echo '木板碎料出貨單';
if ($page=='scrap' )
echo '碎料出貨單';
if ($page=='statistic' )
echo '存貨查詢';
if ($page=='member' )
echo '會員登記表';
if ($page=='invoice_door' &&  substr($subpage,0,4)=='inde')
echo '方邊門出貨單';



if ($pos!='')
	echo "[".$pos."]";
?>
[<?echo $UNAME;?>,<?echo $AREA;?>,<?echo $PC;?>]
</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 
<?php
 $User2 = new User($db);
 if ($_SESSION['username']==''){
 $uname=$_REQUEST['username'];
 $pass=$_REQUEST['password'];
 
 }else{
	$UNAME=$_SESSION['username'];
	$UROLE=$_SESSION['userrole'];
	$USER=$_SESSION['name'];
	$AREA=$_SESSION['area'];
	$PC=$_SESSION['pc'];
 }
	  	 
	// "UNAME_SESSION".$_SESSION['username'];
	 //"UROLE_SESSION".$_SESSION['userrole'];
	 
	 
if ($_SESSION['username']=="" && $uname!="" && $User2->checkPassword($uname,$pass)){
	
	
    $_SESSION['username']=$User2->getUsername();
	$_SESSION['ltd']="YRT";
	$_SESSION['userrole']=$User2->getUserrole(0);
	$_SESSION['area']=$User2->getUserarea();
	$_SESSION['pc']=$User2->getUserpc();
	$_SESSION['name']=$User2->getName();
	
	$AREA=$_SESSION['area'];
	$PC=$_SESSION['pc'];
	$USER=$_SESSION['name'];
	$UNAME=$_SESSION['username'];
	$UROLE=$_SESSION['userrole'];
	?><body style="margin-top:  0px;margin-left:  0px;"><?php 	  
}else if ($_SESSION['username']=="" && $uname!="" && $User2->checkPassword($UNAME,$pass)==false){
	 ?> <script>
 alert('打錯密碼');
 window.location.href = "index.php";
 </script>
 <?php } else if ($_SESSION['username']=="" && $UNAME=="") { 

include_once("header_empty.php");?>
<script>
$(document).ready(function(){
	$("#username").focus();
});
</script>
</head>
<div class="container">
<div class="row" style="margin-top:60px">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    	<form role="form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			<fieldset>
				<h2>請登入</h2>
				<hr class="colorgraph">
				<div class="form-group">
                    <input type="name" name="username" id="username" class="form-control input-lg" placeholder="StaffID">
				</div>
				<div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
				</div>
				 
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
                     
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						   <input type="submit" class="btn btn-lg btn-success btn-block" value="登入">
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
</div>  
 
<?php }


 if($UNAME!='' & $UROLE!='') {
	 
	 //check login time 20180501
	//if normal user 7.45 > < 18.15
	 
		include_once("header.php");	
		 	
		if (checkLoginDateTime()){
	?>
	<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
 
	<?php
	//print_r($_SESSION);
	   if($_REQUEST['page']!='' && $_REQUEST['subpage']!='')
		  include_once('./'.$_REQUEST['page'].'/'.$_REQUEST['subpage']);
		else
			include_once('./main.php');
 }else{
	 echo "收工啦 入黎做乜";
 } 
 }  
 
?>
 
</body>
</html> 
 
 
 
 
