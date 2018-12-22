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
	    
		$where .=" WHERE sts='A'";
		$where .=" and goods_partno = '".urldecode($_REQUEST['goods_partno'])."' ";    
		$where .=" and place = '".$_REQUEST['place']."' ";
	
	//get sumgoods , qty per box and goods detail
	
	$qtySumGoods="select qty_per_unit,goods_detail,weight from sumgoods where goods_partno='".urldecode($_REQUEST['goods_partno'])."'";
	
	
	//get instock record 
	$sqlIn = "SELECT sum(qty) as qty, sum(box) as box ,goods_detail FROM goods_instock ".$where ;
	$sqlTotIn .= $sqlIn;
	$sqlRecIn .= $sqlIn;
	
	//get outstock record
	$sqlOut = "SELECT IFNULL(sum(qty),0) as qty, IFNULL(sum(box),0) as box FROM goods_outstock ".$where ;
	$sqlTotOut .= $sqlOut;
	$sqlRecOut .= $sqlOut;
	
	//call bal
	//echo $sqlRecIn;
	//echo $sqlRecOut;
  $result = mysqli_query($conn,"SET NAMES 'UTF8'");
	$queryTotIn = mysqli_query($conn, $sqlTotIn) or die("database error:". mysqli_error($conn));
	$queryTotOut = mysqli_query($conn, $sqlTotOut) or die("database error:". mysqli_error($conn));
	$queryQtySumGoods = mysqli_query($conn, $qtySumGoods) or die("database error:". mysqli_error($conn));

	$totalRecordsIn = mysqli_num_rows($queryTotIn);
	$totalRecordsOut = mysqli_num_rows($queryTotOut);
	
	$totalRecordsBal = $totalRecordsIn-$totalRecordsOut;
	 
	$queryRecordsIn = mysqli_query($conn, $sqlRecIn) or die("error to fetch instock box qty data");
	$queryRecordsOut = mysqli_query($conn, $sqlRecOut) or die("error to fetch outstock box qty data");
	$queryQtySumGoods = mysqli_query($conn, $qtySumGoods) or die("error to fetch sumgoods box qty data");

	//iterate on results row and create new index array of data
	while( $rowIn = mysqli_fetch_row($queryRecordsIn) ) { 
		$dataIn = $rowIn;
	}	
	
	while( $rowOut = mysqli_fetch_row($queryRecordsOut) ) { 
		$dataOut = $rowOut;
	}	
	
	while( $rowSumGoods = mysqli_fetch_row($queryQtySumGoods) ) { 
		$dataSumGoods = $rowSumGoods;
	}	
	//print_r($dataIn);
	//print_r($dataOut);
	
	$dataBal['qty']=$dataIn[0]-$dataOut[0];
	$dataBal['box']=$dataIn[1]-$dataOut[1];

	$dataBal['qty_per_unit']=$dataSumGoods[0];
	$dataBal['goods_detail']=$dataSumGoods[1];
	$dataBal['weight_per_unit']=$dataSumGoods[2];
	
	$json_data = array(
			"draw"            => intval( $params['draw'] ),   
			"recordsTotal"    => intval($dataBal ),  
			"recordsFiltered" => intval($dataBal),
			"data"            => $dataBal   // total data array
			);

	echo json_encode($json_data);  // send data as json format
?>
	