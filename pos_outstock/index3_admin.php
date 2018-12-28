 
<?php 


function getBaseUrl() 
{
    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF']; 

    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
    $pathInfo = pathinfo($currentPath); 

    // output: localhost
    $hostName = $_SERVER['HTTP_HOST']; 

    // output: http://
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';

    // return: http://localhost/myproject/
    return $protocol.$hostName.$pathInfo['dirname']."/";
}


 include_once("./include/config.php");
 $connection = DB::connect($dsn);
   if (DB::isError($connection))
   {
      die($connection->getMessage());
	}

	$result = $connection->query("SET NAMES 'UTF8'");
	 
	$parent_id=$_GET['parent_id'];
	if($parent_id=="")
			$parent_id=$_POST['parent_id'];
	//20170314
	if ($_POST["action"]=="save"){
	  
		//find non empty input box from 10x5 
		 
		for ($y=0;$y<7;$y++){
				 
		for ($x=0;$x<8;$x++){
			if ($_POST["input"][$y][$x]!=""){
				//update db
				$sqlu="update sumgoods set model3_x='$x', model3_y='$y' where goods_partno='".$_POST["input"][$y][$x]."'";
				 
				$result= $connection->query($sqlu);
			} 
		}
		
		}
		
	}
	
	
 	 $type1Result = $connection->query("SELECT * FROM type where level='2' and parent_id=".$parent_id);
 
	 if ($_GET['model2']!="")
	  $model3=$_GET['model2'];
	if ($_GET['model2']!="")
	  $model2=$_GET['model2'];
	if ($_GET['model1']!="")
	  $model1=$_GET['model1'];
	 $sql="SELECT * FROM sumgoods where model='".$model1."' and model2='".$model2."'";
	 
	  $type1Result = $connection->query($sql);
	 
	 
      if (DB::isError($type1Result))
      die ($type1Result->getMessage());
  while ($typerow = $type1Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
			 $inputname[$typerow['model3_x']][$typerow['model3_y']]=$typerow['goods_partno'];
		 }
 
 
  ?> 
  <meta name="viewport" content="width=device-width, initial-scale=1">
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquerymobile/1.4.5/jquery.mobile.min.js"></script>
<script type="text/javascript" src="./js/js.storage.min.js"></script> 
<script src="./pos_outstock/<?php echo $pos;?>.js"></script>
 <script type="text/javascript" src="/js/jquery.numpad.js"></script>
 <link rel="stylesheet" href="./js/jquery.numpad.css">
   <link rel="stylesheet" href="./pos_outstock/styles.css">
  <script  type="text/javascript">
  var pos='<?php echo $pos;?>';
 
  $(function() {

	$('#qty').numpad();
		ls=Storages.localStorage;
	
 
	$('#product a[href]').click(function(){
		//alert($(this).text());
		//	ls.set('partno.1.id',$(this).text());
		//$.jStorage.set('partno_1', $(this).text());
	 	//ls.set('partno.1.qty',$('#qty').val());
		$('#partno').val($(this).attr('partno'));
		$('#desc').val($(this).attr('desc'));
		$('#price').val($(this).attr('price'));
        $('#qty').click();
	});
	  
	   $("#form1").validate();
            $.mobile.ajaxFormsEnabled = false;
			
			
			$("#backlink").click(function(event) {
		 
		event.preventDefault();
		history.back(1);
	});
	$("#nextlink").click(function(event) {
		 
		event.preventDefault();
		history.go(1);
	});
	
		
  });
   
  
  $.fn.numpad.defaults.onKeypadCreate = function(){$(this).enhanceWithin();};
  $.fn.numpad.defaults.onKeypadClose = function(){
	  //alert(ls.get('partno.1.id'));
	  //alert(ls.get('partno.1.qty'));
	  storeItem();
				
  };
  
		/*
		function storeItem() {
	 
			var item=[];
			var items = localStorage.getItem(pos+'_myItems');
			 
			item[0] = $('#qty').val();
			item[1] =$('#partno').val();
			item[2] = $('#desc').val();
			item[3] = $('#price').val();
					
				 
			if (items != null) {
				items = JSON.parse(items);
			} else {
				items = new Array();
			}
			
		 
			items.push(item);
			localStorage.setItem('pos',JSON.stringify(items));
			refresh();
			}
			*/
  </script>
 
<div style=""> 
	<div id="controlpanel">
		 <?php include_once('./pos_outstock/menu.php');?>
	<hr>
	
		
	<hr>
		<div id="product">
		<form name="form1" action="/?page=pos_outstock&subpage=index3_admin.php&pos=<?php echo $pos;?>" method="post" data-ajax="false" >
		<input type="hidden" name="model1" value="<?php echo $model1;?>">
		<input type="hidden" name="model2" value="<?php echo $model2;?>">
		<input type="hidden" name="parent_id" value="<?php echo $parent_id;?>">
		
		<input type="hidden" value="save" name="action">
		<table border="1">
		<?php 
		  /*
		 while ($typerow = $type1Result->fetchRow(DB_FETCHMODE_ASSOC))
		 {
			?>
			 <a class="ui-button ui-widget ui-corner-all" href="" partno="<?php echo stripslashes($typerow['goods_partno']);?>" desc="<?php echo stripslashes($typerow['goods_detail']);?>" price="<?php echo stripslashes($typerow['market_price']);?>"><?php echo stripslashes($typerow['goods_detail']);?></a>
			 <?php
		}
		*/
		$y=0;
		echo "<td></td><td>x0</td><td>x1</td><td>x2</td><td>x3</td><td>x4</td><td>x5</td><td>x6</td><td>x7</td>";
		for ($y=0;$y<7;$y++){
			
			?><tr><?php
			echo "<td>y".($y)."</td>";
		for ($i=0;$i<8;$i++){
			
		?> <td><input type="text" value="<?php echo $inputname[$i][$y];?>" size="20" name="<?php echo "input[".$y."][".$i."]";?>"/></td>
		 <?php
		}
		?></tr><?php
		}
		?>
			 <tr><td colspan="11">  <input type="submit" value="Submit"></td></tr>
			 </table>
		</form>
		</div>
	</div>
	<div style="position: fixed; right: 0;top :0;" id="list-items">
	<a href="/?pos=<?php echo $pos;?>&page=pos_outstock&subpage=index3.php&model1=<?php echo $model1;?>&model2=<?php echo $model2;?>&model3=<?php echo $model3;?>&parent_id=<?php echo $parent_id;?>" data-ajax="false">唯讀</a>
 
	<div id="page_footage">
	
			<?php echo $model1;?> ->	 <?php echo $model2;?> 
			 
		</div>
	 <ul ></ul>
	<input type="hidden" name="qty" id="qty" value="">
	<input type="hidden" name="partno" id="partno" value="">
	<input type="hidden" name="desc" id="desc" value="">
	<input type="hidden" name="price" id="price" value="">
	</div>
</div>
 
  