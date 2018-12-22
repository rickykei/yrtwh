<?php 
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
	
//get Staff name
	  require_once("../include/config.php");
  
		 
	// initilize all variable
	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;

	//define index of column
	$columns = array( 
		0 =>'id',
		1 =>'instock_no'
		 
	);

	$where = $sqlTot = $sqlRec = "";

	// check search value exist
	    
		$where .=" WHERE ";
		$where .="  goods_partno = '".urldecode($_REQUEST['goods_partno'])."' ";    
		$where .="  ";
		
	//get instock record 
	$sqlIn = "SELECT  qty_per_unit ,goods_detail FROM sumgoods ".$where ;
	$sqlTotIn .= $sqlIn;
	$sqlRecIn .= $sqlIn;
	
 
	 // echo $sqlIn;
	//call bal
	//echo $sqlRecIn;
	//echo $sqlRecOut;
  $result = mysqli_query($conn,"SET NAMES 'UTF8'");
	$queryTotIn = mysqli_query($conn, $sqlTotIn) or die("database error:". mysqli_error($conn));
	 
	$totalRecordsIn = mysqli_num_rows($queryTotIn);
	 
	 
	$queryRecordsIn = mysqli_query($conn, $sqlRecIn) or die("error to fetch box qty data");
	 

	//iterate on results row and create new index array of data
	while( $rowIn = mysqli_fetch_row($queryRecordsIn) ) { 
		$dataIn = $rowIn;
	}	
	
	 
	//print_r($dataIn);
	//print_r($dataOut);
	
	$dataBal['qty_per_unit']=$dataIn[0]*$_REQUEST['box'];
	$dataBal['goods_detail']=$dataIn[1];
	 
 

	
	$json_data = array(
			"draw"            => intval( $params['draw'] ),   
			"recordsTotal"    => intval($dataBal ),  
			"recordsFiltered" => intval($dataBal),
			"data"            => $dataBal   // total data array
			);

	echo json_encode($json_data);  // send data as json format
?>
	