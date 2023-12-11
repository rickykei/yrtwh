
	<?
include("./include/config.php");
	$query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

	if (DB::isError($connection))
		die($connection->getMessage());
	
 	$prod_id = $_REQUEST['action'];
	$prod_id = $_REQUEST['prod_id'];
	$product_make=$_REQUEST['product_make'];
	$product_model=$_REQUEST['product_model'];
 
	$total_unit = 0;
	$total_price = 0;
 
	$sql="select * from sumgoods ";
	
	 
if($prod_id!=''){
$sql=$sql." and product_id = '$prod_id' ";
}
if($product_made!=''){
$sql=$sql." and product_made = '$product_made' ";
}
if($product_model!=''){
$sql=$sql." and product_model = '$product_model' ";
}

//echo $sql;	
//echo $sql2;

	  
  $result=$connection->query($sql);
  if (DB::isError($result)) die ($result->getMessage());
    
	$i=0;
		 while ( $row = $result->fetchRow(DB_FETCHMODE_ASSOC) ){	
				 
 
			$sprod_id[$i]=$row["goods_partno"];
			
					 
					 //get instock record 
				$sqlIn = "SELECT IFNULL(sum(qty),0) as qty, IFNULL(sum(box),0) as box  FROM goods_instock where goods_partno='".$sprod_id[$i]."'" ;
			 
				//get outstock record
				$sqlOut = "SELECT IFNULL(sum(qty),0) as qty, IFNULL(sum(box),0) as box FROM goods_outstock where goods_partno='".$sprod_id[$i]."'" ;
				 
				//echo $sqlIn;
				//echo $sqlOut;
				 
		 
				  $queryRecordsIn=$connection->query($sqlIn);
				   $queryRecordsOut=$connection->query($sqlOut);
				 
				//iterate on results row and create new index array of data
				while( $rowIn = $queryRecordsIn->fetchRow(DB_FETCHMODE_ASSOC) ) { 
					if($rowIn!=null)
					$dataIn = $rowIn;
				}	
				
				while( $rowOut = $queryRecordsOut->fetchRow(DB_FETCHMODE_ASSOC) ) { 
					if($rowOut!=null)
					$dataOut = $rowOut;
				}	
				//print_r($dataIn);
				//print_r($dataOut);
				if ($dataIn['box']-$dataOut['box']<$row['inshop_quota']){
					$dataBal[$i]['goods_partno']=$sprod_id[$i];
					$dataBal[$i]['qty']=$dataIn['qty']-$dataOut['qty'];
					$dataBal[$i]['box']=$dataIn['box']-$dataOut['box'];
					$dataBal[$i]['goods_detail']=$row["goods_detail"];
					$i++;
				}
				//print_r($dataBal[$i]);
		 
		 
		
		}
 ?>
	
	   

		 
    <table id="example" class="display" style="width:100%">              
		<thead>
		<tr valign="top">
			<th >id</th>
			<th  >貨品編號</th>
			 <th  >箱數</th>
			 <th  >裝數</th>
			
		</tr>
		</thead>
	  <tbody>
		<?

		$j=0;
		for ($i = 0; $i < count($dataBal); $i++) {

		 
		?>
        <tr valign="top">
			<td ><?=$j+1?></td>
            <td ><?=$dataBal[$i]['goods_partno']?></td>
			
			<td ><?=$dataBal[$i]['box']?></td><td ><?=$dataBal[$i]['qty']?></td>
        </tr>
        <?$j++;
		}
		
		 ?>
		</tbody>
    </table>
	
	
	<script>
	$(document).ready(function() {
    $('#example').DataTable( {
		columnDefs: [{"className": "dt-center", "targets": "_all"}],
		paging:   false,
        dom: 'Bfrtip',
        buttons: [
          'copy',  'csv','pdf', 'excel', 'print'
        ]
    } );
} );
	</script>


</td></tr></table>
</td>