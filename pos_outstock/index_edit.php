<?php 
include_once("./include/config.php");
$connection = DB::connect($dsn);
  if (DB::isError($connection)){
      die($connection->getMessage());
  }
	$result = $connection->query("SET NAMES 'UTF8'");

	$type00Result = $connection->query("SELECT * FROM type where level='0'");
    if (DB::isError($type00Result))
      die ($type00Result->getMessage());
   include_once("index_edit_js.php");
  ?>
 
<script type="text/javascript">
     
  $(function() {    
	
	  $('#qty').numpad();
	  ls=Storages.localStorage;
	  ls.set('curr_page','model1');
	//  alert(ls.get('curr_page'));
	 	var items = new Array();
		var item = new Array();
		var invoice_header = new Array();
		
	  //20180801 insert items to localStorage if action = edit
	  <?php if($_REQUEST['action']=='edit'){
		$outstock_no=$_REQUEST['outstock_no'];
		 $sql="Select * from outstock where outstock_no = ".$outstock_no;
		$invoiceResult = $connection->query($sql);
		$invoicerow = $invoiceResult->fetchRow();
	
				$js_array = json_encode($invoicerow);
				echo " invoice_header = ". $js_array . ";\n";	
	
		$sql="select a.*, a.qty as qty,b.qty_per_unit as qty_per_unit, b.weight as weight from goods_outstock a,sumgoods b where outstock_no=".$outstock_no." and a.goods_partno=b.goods_partno order by a.id asc";
			$goods_invoiceResult = $connection->query($sql);
			$i=0;
			while($goods_invoicerow = $goods_invoiceResult->fetchRow(DB_FETCHMODE_ASSOC))
			{
				
					 
				$goods_invoice[$i][0]=$goods_invoicerow['goods_partno'];
				$goods_invoice[$i][1]=$goods_invoicerow['goods_partno'];
				$goods_invoice[$i][2]=$goods_invoicerow['goods_detail'];
				$goods_invoice[$i][3]=$goods_invoicerow['box'];
				$goods_invoice[$i][4]=$goods_invoicerow['qty'];
				$goods_invoice[$i][5]=$goods_invoicerow['place'];
				$goods_invoice[$i][6]=$goods_invoicerow['qty_per_unit'];
				$goods_invoice[$i][7]=$goods_invoicerow['weight'];
				
				$i++;
			}
			
				$js_array = json_encode($goods_invoice);
				echo " item = ". $js_array . ";\n";	
	  ?>
			   
				 
						console.log('item'+item);
	
	
						//item[0] = $('#qty'+i).val();
						//item[1] = $('#goods_partno'+i).val();
						//item[2] = $('#goods_detail'+i).val();
						//item[3] = $('#market_price'+i).val();
						 //items.push(item);
						 localStorage.setItem(pos+'_myOutstock','['+JSON.stringify(invoice_header)+']');
						 localStorage.setItem(pos+'_myItems',JSON.stringify(item));
						 item=[];
					refresh(); 	
	
	   <?php } ?>
	 
  });
  
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
	
	 include_once('./pos_outstock/menu_edit.php');?>
	  
	 <?php 
	 
	  include_once('./pos_outstock/footage.php');?>
	
		<div id="model"> 
		<table border="0">
		<?php 
		$i=0; 
		  while ($typerow = $type00Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
			 if ($i==0){
				 echo "<tr>";
				 $i=0;
			 }
			 
			?>
			 <td><a class="ui-button ui-widget ui-corner-all" href="/?id=<?php echo $id;?>&outstock_no=<?php echo $outstock_no;?>&pos=<?php echo $pos;?>&page=pos_outstock&subpage=index2_edit.php&parent1_name=<?php echo stripslashes($typerow['typeName']);?>&parent_id=<?php echo stripslashes($typerow['id']);?>"  rel="external" ><?php echo stripslashes($typerow['typeName']);?></a></td>
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