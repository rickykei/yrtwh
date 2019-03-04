
	<?
include("./include/config.php");
	$query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

	if (DB::isError($connection))
		die($connection->getMessage());
  
				//get instock record 
				$sqlIn = "SELECT goods_partno,IFNULL(sum(qty),0) as qty, IFNULL(sum(box),0) as box ,place FROM goods_instock group by goods_partno,place order by place ";
			 
				//get outstock record
				
				 
				//echo $sqlIn;
				//echo $sqlOut;
				 
		 
				  $queryRecordsIn=$connection->query($sqlIn);
				   
				 $i=0;
				//iterate on results row and create new index array of data
				while( $rowIn = $queryRecordsIn->fetchRow(DB_FETCHMODE_ASSOC) ) { 
					if($rowIn!=null){
						
					$dataIn = $rowIn;
					$dataBal[$i]['qty']=$dataIn['qty'];
					$dataBal[$i]['box']=$dataIn['box'];
					$dataBal[$i]['goods_partno']=$dataIn['goods_partno'];
					$dataBal[$i]['place']=$dataIn['place'];
					
					$sqlOut = "SELECT IFNULL(sum(qty),0) as qty, IFNULL(sum(box),0) as box,place FROM goods_outstock 
					where place='".$dataIn['place']."' 
					and goods_partno='".$dataIn['goods_partno']."'
					group by goods_partno,place " ;
					
					//if ($dataIn['goods_partno']=='C6AO' && $dataIn['place']=='D')
					//echo $sqlOut;
					$queryRecordsOut=$connection->query($sqlOut);
						while( $rowOut = $queryRecordsOut->fetchRow(DB_FETCHMODE_ASSOC) ) { 
							if($rowOut!=null){
								
							$dataOut = $rowOut;
							
							//if ($dataIn['goods_partno']=='C6AO' && $dataIn['place']=='D'){
								//print_r($dataIn);
								//print_r($dataOut);
							//	}
						//	if ($dataIn['qty']-$dataOut['qty']>0 ){
							$dataBal[$i]['qty']=$dataIn['qty']-$dataOut['qty'];
							$dataBal[$i]['box']=$dataIn['box']-$dataOut['box'];
							$dataBal[$i]['goods_partno']=$dataIn['goods_partno'];
							$dataBal[$i]['place']=$dataIn['place'];
							
							//}
							}
						}	
					}
					$i++;
				}	
				
				//print_r($dataBal); 
		 
 ?>
	
	   

		 
    <table id="example" class="display" style="width:100%">              
		<thead>
		<tr valign="top">
			
			<th  >儲放位置</th>
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
			<td ><?=$dataBal[$i]['place']?></td>
            <td ><?=$dataBal[$i]['goods_partno']?></td>
			<td ><?=$dataBal[$i]['box']?></td>
			<td ><?=$dataBal[$i]['qty']?></td>
			
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