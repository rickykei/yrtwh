<?php 
 include_once("./include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    $result = $connection->query("SET NAMES 'UTF8'");

		$parent_id=$_GET['parent_id'];
	 $type1Result = $connection->query("SELECT * FROM type where level='1' and parent_id=".$parent_id);
      if (DB::isError($type1Result))
      die ($type1Result->getMessage());
  
  $model1=$_GET['parent1_name'];
  
  //if ($PC=='99')
  //$index3_page="index3_admin";
//	else
  $index3_page="index3";
    include_once("index_edit_js.php");

  ?> 
 
<script type="text/javascript">

  $(function() {
	   
	 
	  $('#qty').numpad();
 
	ls.set('curr_page','model2');
	//alert(ls.get('selected_model1'));
	aa=$('#page_footage').text();
	$('#page_footage').text(ls.get('selected_model1')+aa);
	 
	
  } );
  
   $.fn.numpad.defaults.onKeypadOpen= function(){
	$(this).find('.nmpd-display').val(0);
	} 
  $.fn.numpad.defaults.onKeypadCreate = function(){$(this).enhanceWithin();};
  $.fn.numpad.defaults.onKeypadClose = function(){
	 
	    if($(this).find('.nmpd-display').val()!="" && $(this).find('.nmpd-display').val()!=0 && $('#desc').val()!=""){
		storeItem();
		$('#quickinput').val('');
		$('#quickinput').focus();
	  }
				
  };
  </script>
</head>
<body>
<div style=""> 
	<div id="controlpanel"  >
		 <?php include_once('./posv2/menu.php');?>
	 
		 <?php include_once('./posv2/footage.php');?>
	 
		<div id="model">
		<table border="0">
		<?php 
		$i=0;
		  while ($typerow = $type1Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
			  if ($i==0){
				 echo "<tr>";
				 
			 }
			
			?>
			<td><a class="ui-button ui-widget ui-corner-all" href="/?id=<?php echo $id;?>&pos=<?php echo $pos;?>&page=posv2&subpage=<?php echo $index3_page;?>.php&model1=<?php echo $model1;?>&model2=<?php echo stripslashes($typerow['typeName']);?>&parent_id=<?php echo stripslashes($typerow['id']);?>" rel="external"><?php echo stripslashes($typerow['typeName']);?></a></td>
			 <?php
			  $i++;
			  
			  if ($i==5){
				 echo "</tr>";
				 $i=0;
			 }
			 
		}
		?>
			</table>
	 
		</div>
	</div>
	<div    style="position: fixed; right: 0;top :0;" id="list-items">	<div id="page_footage"> ->	</div>
	 <ul ></ul>
	<input type="hidden" name="qty" id="qty" value="">
	<input type="hidden" name="partno" id="partno" value="">
	<input type="hidden" name="desc" id="desc" value="">
	<input type="hidden" name="price" id="price" value="">
	<input type="hidden" name="action" id="action" value="">
	</div>
</div>
 
 

 
 
</body>
</html>