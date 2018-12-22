<?php
 
function n_f($no){
 return number_format($no,2,'.','');
}
function sub_remark($remark){
	if(strlen($remark)>20)
	echo substr($remark,0,20)."...";
	else
	echo $remark;
	
}
function fin_year($db){
	
	$sql="select year from fin_year where sts='A' ";
	if ($rows=$db->fetch_all_array($sql)){
		
	}
	return $rows[0]['year'];
	
}
function fin_year_admin($db){
	
	$sql="select year from admin_year ";
	if ($rows=$db->fetch_all_array($sql)){
		
	}
	return $rows[0]['year'];
	
}

function checkLoginDateTime(){
	
 global $UNAME;
 global $UROLE;
 global $PC;
 global $AREA;
	//check login time 20180501
	//if normal user 7.45 > < 18.15
   	$ThatTime ="07:45:00";
   	$EndTime = "18:15:00";
	
	if (time() >= strtotime($ThatTime)&&time() <= strtotime($EndTime)){
					
			
	}else{
		if ($PC!='99'){
			$UROLE="";		
			$UNAME="";
		}
	}
	
	if ($UROLE==''){
		$_SESSION='';
		return false;
	}else{
		return true;
	}
	
		
}

function calInstockBoxNum($goods_partno,$box,$instock_no,$conn){
	  
	 
	 
	//find the start sequence for the goods_partno;
	 $query="SELECT box_label_start_num from sumgoods where goods_partno='$goods_partno'";
	 $res=$conn->query($query);
	 $row = $res->fetchRow( DB_FETCHMODE_ASSOC );
	  
	 //echo "instockNO".$instock_no."instockNO";
	  
	 $startNum=$row['box_label_start_num'];
	  //echo $startNum;
	  
	 // cal the position under goods_instock record;
     $query2=" select sum(box) as box from goods_instock where goods_partno='$goods_partno' and instock_no <'$instock_no'";
	 $res=$conn->query($query2);
	 $row = $res->fetchRow( DB_FETCHMODE_ASSOC );
	 
	 if ($row['box']!='')
	 $instock_position=$row['box'];else $instock_position=0;
	// echo "instockPos".$instock_position."instockPos";
	 $startPos=$instock_position+$startNum;
	 $endPos=$startPos+$box-1;
	 //$endPos=$startPos+$box;
	 
	$str=$startPos;
	 
	 if($box>1){
	 $str.= "-";
	 $str.=$endPos;
	 }
	 return $str;
	 
}

function calOutstockBoxNum($goods_partno,$box,$outstock_no,$conn){
	  
	 
	 
	//find the start sequence for the goods_partno;
	 $query="SELECT box_label_start_num from sumgoods where goods_partno='$goods_partno'";
	 $res=$conn->query($query);
	 $row = $res->fetchRow( DB_FETCHMODE_ASSOC );
	  
	 //echo "outstockNO".$outstock_no."outstockNO";
	  
	 $startNum=$row['box_label_start_num'];
	  //echo $startNum;
	  
	 // cal the position under goods_instock record;
     $query2=" select sum(box) as box from goods_outstock where goods_partno='$goods_partno' and outstock_no <'$outstock_no'";
	 $res=$conn->query($query2);
	 $row = $res->fetchRow( DB_FETCHMODE_ASSOC );
	 
	 if ($row['box']!='')
	 $outstock_position=$row['box'];else $outstock_position=0;
	// echo "outstockPos".$outstock_position."outstockPos";
	 $startPos=$outstock_position+$startNum;
	 $endPos=$startPos+$box-1;
	 //$endPos=$startPos+$box;
	 
	 $str=$startPos;
	 
	 if($box>1){
	 $str.= "-";
	 $str.=$endPos;
	 }
	 return $str;
}

function getPartNoWeight($goods_partno,$conn){
	 $query="SELECT weight from sumgoods where goods_partno='$goods_partno'";
	 $res=$conn->query($query);
	 $row = $res->fetchRow( DB_FETCHMODE_ASSOC );
	  
	 return $row['weight'];
}


?>
