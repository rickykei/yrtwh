<?php
   require_once("./include/config.php");
   $id=$_GET["id"];

  if ($id !="")	{
			$sql="SELECT * FROM staff where id=".$id;
			$result=$db->query($sql);
			if (DB::isError($result))
	    	  die ($result->getMessage());
			else	  
			$row = $result->fetchRow(DB_FETCHMODE_ASSOC) ;
			 
 }
?>
 
<style type="text/css">
@import url("./staff/styles.css");
</style>
<div id="carbonForm">
	<h1>員工設定 <? echo "[".$AREA."鋪,第".$PC."機]";?></h1>
    <form action="/?page=staff&subpage=edit2.php" method="post" id="staffform">
    <div class="fieldContainer">
	<div class="formRow">
            <div class="label">
                <label for="name">員工名稱:</label>
    </div>
            <div class="field">
                <input type="text" name="name" id="name"  maxlength="20" value="<?php echo $row["name"];?>" />
             
            </div>
           
        </div><div class="formRow">
            <div class="label">
                <label for="name">username:</label>
    </div>
            <div class="field">
                <input type="text" name="username" id="username"  maxlength="20" value="<?php echo $row["username"];?>" />
             
            </div>
           
        </div>
<div class="formRow">
            <div class="label">
                <label for="area">分店 : </label>
            </div>
            
            <div class="field">
                <input type="text" name="area" id="area" size="1" value="<?php echo $row["area"];?>"/>
            </div>
          
        </div>
        
       <div class="formRow">
            <div class="label">
                <label for="pc">機號  : </label>
            </div>
            
            <div class="field">
            	<input type="text" name="pc" id="pc" size="3" maxlength="3" value="<?php echo $row["pc"];?>"/>
            </div>
        </div>
        <div class="formRow">
            <div class="label">
                <label for="telno">電話  : </label>
            </div>
            
            <div class="field">
            	<input type="text" name="telno" id="telno" size="20" maxlength="20" value="<?php echo $row["telno"];?>"/>
            </div>
        </div>
		
		<div class="formRow">
            <div class="label">
                <label for="Password">Password  : </label>
            </div>
            
            <div class="field">
            	<input type="password" name="password" id="password" size="50" maxlength="50" value="<?php echo $row["password"];?>"/>
            </div>
        </div>

        

    </div> 
    <input type="hidden" name="role" value="1" />
    <div class="signupButton">
    <?php if ($id!=""){ ?>
    	<input type="hidden" name="action" value="update" />
            	<input type="hidden" name="id" value="<?php echo $id;?>" />
    <?php }else{ ?>        
       	<input type="hidden" name="action" value="insert" />
    <?php } ?>    
        <input type="submit" name="submit" id="submit" />
    </div>
    
    </form>
        
</div>
 