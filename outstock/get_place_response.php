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
		$where .=" group by place ";
		
	//get instock record 
	$sqlIn = "SELECT sum(qty) as qty, sum(box) as box, place  FROM goods_instock ".$where ;
	$sqlTotIn .= $sqlIn;
	$sqlRecIn .= $sqlIn;
	
	//get outstock record
	$sqlOut = "SELECT IFNULL(sum(qty),0) as qty, IFNULL(sum(box),0) as box , place FROM goods_outstock ".$where ;
	$sqlTotOut .= $sqlOut;
	$sqlRecOut .= $sqlOut;
	
	//call bal
	//echo $sqlRecIn;
	//echo $sqlRecOut;
  
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
	}	
	
	while( $rowOut = mysqli_fetch_row($queryRecordsOut) ) { 
		$dataOut[$rowOut[2]]['qty'] = $rowOut[0];
		$dataOut[$rowOut[2]]['box'] = $rowOut[1];
	}	
//	print_r($dataIn);
//	print_r($dataOut);
	
	foreach ($dataIn as $key => $value) {
    // $arr[3] will be updated with each value from $arr...
    //echo "{$key} => {$value} ";
    if ($dataIn[$key]['qty']>$dataOut[$key]['qty'])
	//	$dataBal[$key]=$dataIn[$key]['qty']-$dataOut[$key]['qty'];
		$dataBal[]= array('ID'=>$key,'Name'=>$key);
	}

	
//print_r($dataBal);
	
	
	
	$json_data =   $dataBal   // total data array
			;

	echo json_encode($json_data);  // send data as json format
?>
	