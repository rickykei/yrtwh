<?php
if ( isset($_REQUEST['pagenum'] ) )
{
   $pagenum = (int)$_REQUEST['pagenum'];
}
else
{
   $pagenum = 1;
}
 
 
$pager_option = array(
       "sql" => $sql,
       "PageSize" => 10,
       "CurrentPageID" => $pagenum
);


if ( isset($_REQUEST['numItems']) ){
   $pager_option['numItems'] = (int)$_REQUEST['numItems'];
}else{
	$pager_option['numItems'] =$countTotal;
}

 
$pager = @new Pager($pager_option);
 
$result = $pager->getPageData();


if ( $pager->isFirstPage ){
   $turnover = "<span class=\"style7\">第一頁|上一頁|</span>";
}else{
$turnover = "<a  href='".$_SERVER['REQUEST_URI']."&receiver=$receiver&deposit_method=$deposit_method&total_price=$total_price&status=$status&sales=$sales&created_by=$created_by&invoice_date_end=$invoice_date_end&invoice_date_start=$invoice_date_start&invoice_status=$invoice_status&customer_detail=$customer_detail&invoice_no=$invoice_no&goods_partno=$goods_partno&mem_id=$mem_id&pagenum=1&numItems=".$pager->numItems."'>首頁</a>|<a href='".$_SERVER['REQUEST_URI']."&sales=$sales&created_by=$created_by&invoice_date_end=$invoice_date_end&invoice_date_start=$invoice_date_start&invoice_status=$invoice_status&customer_detail=$customer_detail&invoice_no=$invoice_no&goods_partno=$goods_partno&mem_id=$mem_id&pagenum=".$pager->PreviousPageID."&numItems=".$pager->numItems."'> 上一頁</a>|";
}
if ( $pager->isLastPage ){
   $turnover .= "<span class=\"style7\">下一頁|尾頁</span>";
}else{
$turnover .= "<a class=style1 href='".$_SERVER['REQUEST_URI']."&receiver=$receiver&deposit_method=$deposit_method&total_price=$total_price&status=$status&sales=$sales&created_by=$created_by&invoice_date_end=$invoice_date_end&invoice_date_start=$invoice_date_start&invoice_status=$invoice_status&customer_detail=$customer_detail&invoice_no=$invoice_no&goods_partno=$goods_partno&mem_id=$mem_id&pagenum=".$pager->NextPageID."&numItems=".$pager->numItems."'> 下一頁</a>|<a href='".$_SERVER['REQUEST_URI']."&sales=$sales&created_by=$created_by&invoice_date_end=$invoice_date_end&invoice_date_start=$invoice_date_start&invoice_status=$invoice_status&customer_detail=$customer_detail&invoice_no=$invoice_no&goods_partno=$goods_partno&mem_id=$mem_id&pagenum=".$pager->numPages."&numItems=".$pager->numItems."'> 尾頁</a>";
}
?>