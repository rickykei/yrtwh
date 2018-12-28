<?php 
 include_once("./include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}
	    $result = $connection->query("SET NAMES 'UTF8'");

		//get partno 
		$goods_partno=$_REQUEST['goods_partno'];
		
		
		 
		// check search value exist
	    
		$where .=" WHERE sts='A'";
		$where .=" and goods_partno = '".$goods_partno."' ";    
		$where .=" group by place ";
		
		//get instock record 
		$sqlIn = "SELECT sum(qty) as qty, sum(box) as box, place  FROM goods_instock ".$where ;
		$sqlTotIn .= $sqlIn;
		$sqlRecIn .= $sqlIn;
		
		//get outstock record
		$sqlOut = "SELECT IFNULL(sum(qty),0) as qty, IFNULL(sum(box),0) as box , place FROM goods_outstock ".$where ;
		$sqlTotOut .= $sqlOut;
		$sqlRecOut .= $sqlOut;
		
 
	  
		$queryTotIn = mysqli_query($conn, $sqlTotIn) or die("database error:". mysqli_error($conn));
		$queryTotOut = mysqli_query($conn, $sqlTotOut) or die("database error:". mysqli_error($conn));

		$totalRecordsIn = mysqli_num_rows($queryTotIn);
		$totalRecordsOut = mysqli_num_rows($queryTotOut);
		$totalRecordsBal = $totalRecordsIn-$totalRecordsOut;
		 
		$queryRecordsIn = mysqli_query($conn, $sqlRecIn) or die("error to fetch box qty data");
		$queryRecordsOut = mysqli_query($conn, $sqlRecOut) or die("error to fetch box qty data");

		//iterate on results row and create new index array of data
		while( $rowIn = mysqli_fetch_row($queryRecordsIn) ) { 
			$dataIn[$rowIn[2]]['qty'] = $rowIn[0];
			$dataIn[$rowIn[2]]['box'] = $rowIn[1];
			$dataIn[$rowIn[2]]['place'] = $rowIn[2];
		}	
		
		while( $rowOut = mysqli_fetch_row($queryRecordsOut) ) { 
			$dataOut[$rowOut[2]]['qty'] = $rowOut[0];
			$dataOut[$rowOut[2]]['box'] = $rowOut[1];
			$dataOut[$rowOut[2]]['place'] = $rowOut[2];
		}	
		//print_r($dataIn);
		//print_r($dataOut);
		
		
		$x=0;
		$y=0;
		foreach ($dataIn as $key => $value) {
		// $arr[3] will be updated with each value from $arr...
		//echo "{$key} => {$value} ";
		if ($dataIn[$key]['qty']>$dataOut[$key]['qty']){
			$dataBal[$x][$y]['qty']=$dataIn[$key]['qty']-$dataOut[$key]['qty'];
			$dataBal[$x][$y]['box']=$dataIn[$key]['box']-$dataOut[$key]['box'];
			$dataBal[$x][$y]['place']=$dataIn[$key]['place'];
			 $x++;
			 if ($x==5)
			 {$y++;$x=0;}
			
		}
		//	$dataBal[]= array('ID'=>$key,'Name'=>$key);
		}
		//print_r($dataBal);
		
	 
	 include_once("index_edit_js.php");

  ?>
 
  
  <script  type="text/javascript">
  $( function() {
    $( document ).tooltip();

	
  } );
  
  $(function() {
	  
 
	$('#out_box').numpad();
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
		$('#rest_qty').val($(this).attr('rest_qty'));
		$('#rest_box').val($(this).attr('rest_box'));
		$('#qty_per_unit').val(<?php echo $qty_per_unit;?>);
		$('#place').val($(this).attr('place'));
		
		console.log($('#partno').val());
		console.log($('#rest_qty').val());
		console.log($('#rest_box').val());
		console.log($('#place').val());
		
		
        $('#out_box').click();
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
		 <?php include_once('./pos_outstock/menu.php');?>
	 
	 <div class="ui-grid-d" id="page_footage_div">

	 	
	</div>
 <?php include_once('./pos_outstock/footage.php');?>
	 
	 
	<div id="product">
		<table border="0">
		<?php 
		  for ($y=0;$y<5;$y++){
			
			?><tr><?php
			echo "<td>y".($y)."</td>";
			for ($i=0;$i<5;$i++){
				if ($dataBal[$i][$y]['box']!=""){
			?><td> <a  href="#" class="ui-button ui-widget ui-corner-all"
			partno="<?php echo stripslashes($goods_partno);?>" 
			rest_box="<?php echo stripslashes($dataBal[$i][$y]['box']);?>" 
			rest_qty="<?php echo stripslashes($dataBal[$i][$y]['qty']);?>" 
			place="<?php echo stripslashes($dataBal[$i][$y]['place']);?>"
			>
			<?php 
		 echo stripslashes($dataBal[$i][$y]['place']."<br>[box=".$dataBal[$i][$y]['box']."]"."<br>[qty=".$dataBal[$i][$y]['qty']."]");?></a></td>
		 <?php
				}
			}
		?></tr><?php
		}
		?>
			
	  </table>
	</div>
	</div>
	<div style="position: fixed; right: 0;top :0;" id="list-items">

<table id="rightlistheader"  border="1" width="100%" bgcolor="#eff9f9" cellspacing="2"><tr><td><div id="page_footage"> ->	</div></td><td><a href="/?pos=<?php echo $pos;?>&page=pos_outstock&subpage=index4_admin.php&model1=<?php echo $model1;?>&model2=<?php echo $model2;?>&model3=<?php echo $model3;?>&parent_id=<?php echo $parent_id;?>" data-ajax="false">Admin</a></td></tr></table>
 	 <table id="rightlist" border="1" bgcolor="#eff9f9" cellspacing="2"></table>

	<input type="hidden" name="out_box" id="out_box" value="">
	<input type="hidden" name="rest_qty" id="rest_qty" value="">
	<input type="hidden" name="rest_box" id="rest_box" value="">
	<input type="hidden" name="partno" id="partno" value="<?php echo $goods_partno;?>">
	<input type="hidden" name="detail" id="detail" value="<?php echo $goods_detail;?>">
	<input type="hidden" name="place" id="place" value="">
	<input type="hidden" name="qty_per_unit" id="qty_per_unit" value="<?php echo $qty_per_unit;?>">
	<input type="hidden" name="weight" id="weight" value="<?php echo $weight;?>">
	<input type="hidden" name="action" id="action" value="">
	</div>
</div>
 
 

  