<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?".">"; ?><?php
define('FPDF_FONTPATH','./font/');
 
require_once('./pdf2/chinese.php');

//require('../fpdf.php');

//class PDF extends FPDF
class PDF extends PDF_Chinese
{
//Current column
var $col=0;
//Ordinate of column start
var $y0;
var $header_title=array();

function Set_header_title($header_title)
{
	$this->header_title=$header_title;
}
function Body($invoice_no)
{
   include("./include/config.php");

    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());
   $result = $connection->query("SET NAMES 'UTF8'");
   $result = $connection->query("SELECT * FROM member_deposit where mem_dep_id=".$invoice_no);

			
  
      if (DB::isError($result))
      die ($result->getMessage());
	while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC))
   {
	    
     // Print out each element in $row, that is, print the values of
      // the attributes
	$resultCust= $connection->query(" Select * from member where member_id like ".$row['mem_id']);
	 
    $rowCust=$resultCust->fetchRow(DB_FETCHMODE_ASSOC);
	$invoice_no1=iconv("UTF-8", "BIG5-HKSCS",$row['invoice_no']);
	$deposit_date=iconv("UTF-8", "BIG5-HKSCS",$row['deposit_date']);
	$entry_date=iconv("UTF-8", "BIG5-HKSCS",$row['entry_date']);
	$sales_name=$row['sales_name'];
	$deposit_amt=$row['deposit_amt'];
	$sql=" Select * from staff where name = '".$sales_name."'";
	$resultStaff= $connection->query($sql);
	$rowStaff=$resultStaff->fetchRow(DB_FETCHMODE_ASSOC);
	$staffTel=$rowStaff['telno'];
	
	$customer_name=iconv("UTF-8", "BIG5-HKSCS",$rowCust['member_name']."    ".$rowCust["creditLevel"]);
	$customer_tel =iconv("UTF-8", "BIG5-HKSCS",$row['mem_id']);
	$customer_detail= iconv("UTF-8", "BIG5-HKSCS",$row['customer_detail']);
 
	$creditLevel= $rowCust['creditLevel'];
	 
	$branchid=$row['branchID'];
 
   }

			// sum of dep amt
				$sum_dep_amt_sql="SELECT sum( deposit_amt ) as sum FROM member_deposit WHERE mem_id ='".$customer_tel."' ";
				
				$sum_dep_amt_result = $db->query($sum_dep_amt_sql);
				while ( $sum_dep_amt_result_row = $sum_dep_amt_result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$sum_dep_amt=$sum_dep_amt_result_row["sum"];
				//echo $sum_dep_amt;
				}
				
				// sum of invoice amt for member used deposit saving
				$sum_inv_dep_amt_sql="SELECT sum( total_price ) as sum FROM invoice WHERE member_id ='".$customer_tel."' and deposit_method='D' ";
				$sum_inv_dep_amt_result = $db->query($sum_inv_dep_amt_sql);
				while ( $sum_inv_dep_amt_result_row = $sum_inv_dep_amt_result->fetchRow(DB_FETCHMODE_ASSOC) ){
				$sum_inv_dep_amt=$sum_inv_dep_amt_result_row["sum"];
				//echo $sum_inv_dep_amt;
				}
				
				
    $this->SetY(-3);
   //$this->Ln(95);
  // $this->Ln(85);
   $this->SetTextColor(0,0,0);
   $this->SetFont('Big5','',16);
  // $this->SetDrawColor(255,255,255);
    $border=0;
  
  
    $printShopName=$shopAddress[array_search($branchid,$shop_array)];
    $printShopDetail=$shopDetail[array_search($branchid,$shop_array)];
 
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$printShopName),$border,0,'C',0);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",$rightLabel1),"TRL",1,'C',0);
	 
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'C',0);
	$this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$printShopDetail),$border,0,'C',0);
    $this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",$rightLabel2),"BRL",1,'C',0);
   

   
	$this->SetFont('Big5','',16);
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(105,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'L',0);
	$this->SetFont('Big5','',14);
	
	$this->Cell(35,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(50,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);
	
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(15,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(70,8,$customer_name,$border,0,'L',0);
	$this->Cell(55,8,iconv("UTF-8", "BIG5-HKSCS",$sales_name),$border,0,'C',0);
	$this->Cell(50,8,$branchid.$row["mem_dep_id"],$border,1,'C',0);

	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(15,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(60,8,$customer_tel,$border,0,'L',0);
 
	$this->Cell(65,8,iconv("UTF-8", "BIG5-HKSCS",$staffTel),$border,0,'C',0);
	$this->Cell(60,8,iconv("UTF-8", "BIG5-HKSCS",$entry_date),$border,1,'R',0);
	
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(15,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(90,8,$customer_detail,$border,0,'L',0);
	$this->Cell(35,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(60,8,iconv("UTF-8", "BIG5-HKSCS","存款").$deposit_date,$border,1,'R',0);
  
  
    $this->Cell(22,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);
  
	$this->Ln(3);
	$this->Cell(5,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);			
	$this->Cell(10,6,iconv("UTF-8", "BIG5-HKSCS","1"),$border,0,'L',0);
	$this->Cell(30,6,iconv("UTF-8", "BIG5-HKSCS","會員存款"),$border,0,'L',0);
	$this->Cell(10,6,iconv("UTF-8","BIG5-HKSCS",""),$border,0,'L',0);
	$this->Cell(65,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'L',0);
    $this->Cell(18,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(9,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(22,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
 
	$this->Cell(25,6,iconv("UTF-8", "BIG5-HKSCS",number_format($deposit_amt, 2, '.', ',')),$border,0,'R',0);
	
	$this->Ln(50);
	$this->Cell(5,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);			
	$this->Cell(10,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'L',0);
	$this->Cell(30,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'L',0);
	$this->Cell(10,6,iconv("UTF-8","BIG5-HKSCS",""),$border,0,'L',0);
	$this->Cell(65,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'L',0);
    $this->Cell(18,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(9,6,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(22,6,iconv("UTF-8", "BIG5-HKSCS","會員總存款"),$border,0,'R',0);
 
	$this->Cell(25,6,iconv("UTF-8", "BIG5-HKSCS",number_format(($sum_dep_amt-$sum_inv_dep_amt), 2, '.', ',')),$border,0,'R',0);
	
	
 	$result->free ();
	$resultStaff->free();
}
function Header()
{
	//Page header
	global $title;
	global $header_title;
	
	
	$w=$this->GetStringWidth($title)+6;
	$this->SetX(2);
	$this->SetDrawColor(255,255,255);
	$this->SetFillColor(233,233,233);
	$this->SetTextColor(0,0,0);
	//20060621$this->Ln(35);
	$this->Ln(19);
	$this->SetLineWidth(0);
	
//      $abc=iconv("UTF-8", "iso-8859-2", "黃河木行有限公司");
	/*$this->SetFont('Big5','B',30);
	$companyName=iconv("UTF-8", "BIG5-HKSCS", "黃河木行有限公司");
	$companyAddress=iconv("UTF-8", "BIG5-HKSCS", "旺角新填地街609-613號地下");
	$companyTel=iconv("UTF-8", "BIG5-HKSCS", "電話:241-22-241  241-22-335  傳真:241-33-373");
	$INVOICE=iconv("UTF-8", "BIG5-HKSCS", "發票");
	$this->Cell(190,14,$companyName,2,1,'C',0);
	$this->SetFont('Big5','',15);
	$this->Cell(190,5,$companyAddress,1,1,'C',0);
	$this->Cell(190,5,$companyTel,1,1,'C',0);
	$this->SetFont('Big5','B',25);
	$this->Cell(190,12,$INVOICE,1,1,'C',0);
	$this->Ln(8);*/
	//Save ordinate
    $this->y0=$this->GetY();
}

function Footer()
{
	//Page footer
	//$this->SetY(-5);
	//$this->SetFont('Big5','',9);
	//$this->SetTextColor(128);
	//$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
}






}





//$pdf=new pdf('P','mm',array(216,217));
$pdf=new pdf('P','mm',array(216,217));
$pdf->SetAutoPageBreak(true,2);
$pdf->SetTopMargin(1);
$pdf->SetLeftMargin(0);
$pdf->AddBig5Font();
$title='出貨單';
$header_title=array();
$pdf->Body($invoice_no);
$pdf->SetAuthor('YRT Company Limited');

$filepath='./member_deposit/pdf/'.$invoice_no.'.pdf';
if (file_exists($filepath)) {
	//move to backup
	$file_timestamp=date("Ymd_His") ;
	$filepathnew='./member_deposit/backuppdf/'.$invoice_no.'_'.$file_timestamp.'.pdf';
	copy($filepath, $filepathnew);
}
$pdf->Output($filepath,'F');
?>
