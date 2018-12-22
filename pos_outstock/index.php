<?php 

 
 include_once("./include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    $result = $connection->query("SET NAMES 'UTF8'");

	 $type00Result = $connection->query("SELECT * FROM type where level='0'");
      if (DB::isError($type00Result))
      die ($type00Result->getMessage());
   include_once("index_edit_js.php");

  ?>
 
<script type="text/javascript">

  $( function() {
	  
  $('#qty').numpad();
  ls=Storages.localStorage;
  ls.set('curr_page','model1');
	 
	 
  } );
  
   $.fn.numpad.defaults.onKeypadOpen= function(){
		$(this).find('.nmpd-display').val(0);
	} 
	
	
  $.fn.numpad.defaults.onKeypadCreate = function(){$(this).enhanceWithin();};
  $.fn.numpad.defaults.onKeypadClose = function(){
	  //alert(ls.get('partno.1.id'));
	  //alert(ls.get('partno.1.qty'));
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
	<div   id="controlpanel">
	 <?php
	
	 include_once('./pos_outstock/menu.php'); 
	 
	  include_once('./pos_outstock/footage.php');?>
	
		<div id="model">C=皇冠, D=鑽石&德萊板, F=富美家, G=西德板, H=雅美家, P=保麗雅, S=松耐特, T=德利板, V=雅高
		<table border="0">
		<?php 
		$i=0; 
		  while ($typerow = $type00Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
			 if ($i==0){
				 echo "<tr>";
			 
			 }
			 
			?>
			 <td><a class="ui-button ui-widget ui-corner-all" href="/?pos=<?php echo $pos;?>&page=pos_outstock&subpage=index2.php&parent1_name=<?php echo stripslashes($typerow['typeName']);?>&parent_id=<?php echo stripslashes($typerow['id']);?>"  rel="external" ><?php echo stripslashes($typerow['typeName']);?></a></td>
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
		<div    style="position: fixed; right: 0;top :0;" id="list-items">
	<table id="rightlistheader" border="1" bgcolor="#eff9f9" cellspacing="2"></table>
	 <table id="rightlist" border="1" bgcolor="#eff9f9" cellspacing="2"></table>
	<input type="hidden" name="qty" id="qty" value="">
	<input type="hidden" name="partno" id="partno" value="">
	<input type="hidden" name="desc" id="desc" value="">
	<input type="hidden" name="readonly" id="readonly" value="">
	<input type="hidden" name="price" id="price" value="">
	<input type="hidden" name="action" id="action" value="">
	</div>
</div>
 
 

 
 
</body>
</html>