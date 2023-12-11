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
	    
		$where .=" WHERE sts='A' and outstock.outstock_no = goods_outstock.outstock_no ";
		$where .=" and goods_partno = '".urldecode($_REQUEST['goods_partno'])."' ";    
		$where .=" and outstock_date >= DATE_SUB(NOW(), INTERVAL 1 MONTH) ";
	 
	//get outstock record
	 
	$sqlOut = "SELECT IFNULL(sum(qty),0) as qty, IFNULL(sum(box),0) as box  FROM goods_outstock , outstock ".$where ;
	
	//echo $sqlOut;
	$sqlTotOut .= $sqlOut;
	$sqlRecOut .= $sqlOut;
	
	$queryTotOut = mysqli_query($conn, $sqlTotOut) or die("database error:". mysqli_error($conn));
 
	$totalRecordsOut = mysqli_num_rows($queryTotOut);
 
	$queryRecordsOut = mysqli_query($conn, $sqlRecOut) or die("error to fetch box qty data");
	
	while( $rowOut = mysqli_fetch_row($queryRecordsOut) ) { 
		$dataOut[0] = $rowOut[0];
		$dataOut[1] = $rowOut[1];
	}	
 
	
	$json_data =   $dataOut   // total data array
			;

	echo json_encode($json_data);  // send data as json format
?>
	