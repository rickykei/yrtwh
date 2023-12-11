<?php
 include_once("./include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    $result = $connection->query("SET NAMES 'UTF8'");

	 $type0Result = $connection->query("SELECT * FROM type where level='0' and sts='A'");
      if (DB::isError($type0Result))
      die ($type0Result->getMessage());
  
  ?>
  <div class="widget">
		 <a class="ui-button ui-widget ui-corner-all" href="index.php" rel="external">主頁</a>
		 
		 <a class="ui-button ui-widget ui-corner-all" href="#" id="backlink">上一頁</a>
		 <a class="ui-button ui-widget ui-corner-all" href="#" id="nextlink">下一頁</a>
		  
		 <a class="ui-button ui-widget ui-corner-all" href="/?pos=<?php echo $pos;?>&page=pos_outstock&subpage=index5_edit.php&outstock_no=<?php echo $outstock_no;?>" rel="external" id="ino">改出貨單</a>
		
	
		 <br>
		 <div id="modelmenu">
		 <?php
		  while ($typerow = $type0Result->fetchRow(DB_FETCHMODE_ASSOC))
		 { 
			 ?>
			<a class="ui-button ui-widget ui-corner-all" href="/?id=<?php echo $id;?>&pos=<?php echo $pos;?>&page=pos_outstock&subpage=index2_edit.php&parent1_name=<?php echo stripslashes($typerow['typeName']);?>&parent_id=<?php echo stripslashes($typerow['id']);?>"  rel="external" ><?php echo stripslashes($typerow['typeName']);?></a> 
			  <?php
		}?>
		
		
		</div>
 </div>