<?php 
 include_once("./include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    $result = $connection->query("SET NAMES 'UTF8'");

		$parent_id=$_GET['parent_id'];
	 $type1Result = $connection->query("SELECT * FROM type where level='2' and parent_id=".$parent_id);
	 $model1=$_GET['model1'];
	  $model3=$_GET['model2'];
	 $sql="SELECT * FROM sumgoods where model='".$model1."' and model2='".$model2."' and status='Y'";
	  $type1Result = $connection->query($sql);
	 
	 
      if (DB::isError($type1Result))
      die ($type1Result->getMessage());
    while ($typerow = $type1Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
			 $inputname[$typerow['model3_x']][$typerow['model3_y']]['partno']=$typerow['goods_partno'];
			 $inputname[$typerow['model3_x']][$typerow['model3_y']]['market_price']=$typerow['market_price'];
			 $inputname[$typerow['model3_x']][$typerow['model3_y']]['pos_label']=$typerow['pos_label'];
			 $inputname[$typerow['model3_x']][$typerow['model3_y']]['goods_detail']=$typerow['goods_detail'];
		 }
     include_once("index_edit_js.php");

  ?>
 
  
  <script  type="text/javascript">
  $( function() {
    $( document ).tooltip();

	
  } );
  
  $(function() {
	  
 
	$('#qty').numpad();
	ls=Storages.localStorage;
	
	ls.set('curr_page','model3');
	//alert(ls.get('selected_model1'));
	aa=$('#page_footage').text();
	$('#page_footage').text(ls.get('selected_model1')+aa+ls.get('selected_model2'));
 
	$('#product a[href]').click(function(){
		//alert($(this).text());
		//	ls.set('partno.1.id',$(this).text());
		//$.jStorage.set('partno_1', $(this).text());
	 	//ls.set('partno.1.qty',$('#qty').val());
		$('#action').val('');
		$('#partno').val($(this).attr('partno'));
		$('#desc').val($(this).attr('desc'));
		$('#price').val($(this).attr('price'));
        $('#qty').click();
	});
	
 
	  
	 
		
  });
   
   $.fn.numpad.defaults.onKeypadOpen= function(){
	$(this).find('.nmpd-display').val(0);
	} 
  $.fn.numpad.defaults.onKeypadCreate = function(){$(this).enhanceWithin();};
  $.fn.numpad.defaults.onKeypadClose = function(){
	  
	   if($(this).find('.nmpd-display').val()!="" && $(this).find('.nmpd-display').val()!=0 && $('#desc').val()!=""){
		storeItem();
		$('#quickinput').val('');
		//$('#quickinput').focus();
	  } 
				
  };
  

			
  </script>
    <style>
  label {
    display: inline-block;
    width: 5em;
  }
  </style>
</head>
<body>
<div > 
	<div id="controlpanel">
		 <?php include_once('./posv2/menu.php');?>
	 
	 <div class="ui-grid-d" id="page_footage_div">

	 	
	</div>
 <?php include_once('./posv2/footage.php');?>
	 
	 
	<div id="product">
		<table border="0">
		<?php 
		  for ($y=0;$y<5;$y++){
			
			?><tr><?php
			echo "<td>y".($y)."</td>";
		for ($i=0;$i<5;$i++){
			
		?><td> <a  href="#" class="ui-button ui-widget ui-corner-all" partno="<?php echo stripslashes($inputname[$i][$y]['partno']);?>" desc="<?php echo stripslashes($inputname[$i][$y]['goods_detail']);?>" price="<?php echo stripslashes($inputname[$i][$y]['market_price']);?>"><?php if($inputname[$i][$y]['pos_label']!=""){echo $inputname[$i][$y]['pos_label'];}else{echo stripslashes($inputname[$i][$y]['goods_detail']);}?></a></td>
		 <?php
		}
		?></tr><?php
		}
		?>
			
	  </table>
	</div>
	</div>
	<div style="position: fixed; right: 0;top :0;" id="list-items">

<table id="rightlistheader"  border="1" width="100%" bgcolor="#eff9f9" cellspacing="2"><tr><td><div id="page_footage"> ->	</div></td><td><a href="/?pos=<?php echo $pos;?>&page=ipadpos&subpage=index3_admin.php&model1=<?php echo $model1;?>&model2=<?php echo $model2;?>&model3=<?php echo $model3;?>&parent_id=<?php echo $parent_id;?>" data-ajax="false">Admin</a></td></tr></table>
	 <table id="rightlist" border="1" bgcolor="#eff9f9" cellspacing="2"></table>

	<input type="hidden" name="qty" id="qty" value="">
	<input type="hidden" name="partno" id="partno" value="">
	<input type="hidden" name="desc" id="desc" value="">
	<input type="hidden" name="price" id="price" value="">
	<input type="hidden" name="action" id="action" value="">
	</div>
</div>
 
 

  