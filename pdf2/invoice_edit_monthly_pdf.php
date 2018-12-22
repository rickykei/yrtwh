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
function Body($invoice_no,$branchID)
{
   include("./include/config.php");

    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());
   $result = $connection->query("SET NAMES 'UTF8'"); echo "b";
   
   $year=split("-",$invoice_no);
   
   $sql="SELECT *  from invoice_amend as a where year(a.amend_date)='".$year[0]."' and month(a.amend_date)='".$year[1]."' and day(a.amend_date)='".$year[2]."' and branchID='".$branchID."'";
   
   $result = $connection->query($sql);

    if (DB::isError($result))
    die ($result->getMessage());
 
	

   $this->SetY(-3);
   //$this->Ln(95);
  // $this->Ln(85);
   $this->SetTextColor(0,0,0);
   $this->SetFont('Big5','',26);
  // $this->SetDrawColor(255,255,255);
  $border=1;
  
  //20170709 disable shopname
  //$printShopName=$shopAddress[array_search($branchid,$shop_array)];
  //$printShopDetail=$shopDetail[array_search($branchid,$shop_array)];
  
   
	  $this->SetFont('Big5','',9);

 

	$this->Cell(40,7,iconv("UTF-8", "BIG5-HKSCS","更改出貨單"),$border,0,'R',0);
	$this->Cell(125,7,iconv("UTF-8", "BIG5-HKSCS","".$invoice_no."-".$branchID),$border,0,'C',0);
	$this->Cell(40,7,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);

 	$this->Ln(1);
	
	$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","更改編號"),$border,0,'R',0);
	$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","更改員工"),$border,0,'C',0);
	$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","更改員工電腦"),$border,0,'C',0);
	$this->Cell(25,7,iconv("UTF-8", "BIG5-HKSCS","更改時間"),$border,0,'C',0);
	$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","發票編號"),$border,0,'C',0);
	$this->Cell(25,7,iconv("UTF-8", "BIG5-HKSCS","發票日期"),$border,0,'C',0);
	$this->Cell(25,7,iconv("UTF-8", "BIG5-HKSCS","送貨日期 "),$border,0,'C',0);
	$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","客戶名稱"),$border,0,'C',0);
	$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","會員編號"),$border,0,'C',0);
	$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","分店"),$border,0,'C',0);
	$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","送貨"),$border,0,'C',0);

	$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","售貨員"),$border,0,'C',0);
		$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","單總"),$border,0,'C',0);
	$this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS","機號"),$border,1,'C',0);
 
 
	while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC))
   {
      $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",$row['amend_invoice_id']),$border,0,'R',0); 
	  $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",$row['amend_sales_name']),$border,0,'R',0); 
      $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",substr($row['amend_by'],0,10)),$border,0,'R',0); 
	  $this->Cell(25,7,iconv("UTF-8", "BIG5-HKSCS",substr($row['amend_date'],0,16)),$border,0,'R',0); 
       $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",$row['invoice_no']),$border,0,'R',0); 
       $this->Cell(25,7,iconv("UTF-8", "BIG5-HKSCS",substr($row['invoice_date'],0,16)),$border,0,'R',0); 
      $this->Cell(25,7,iconv("UTF-8", "BIG5-HKSCS",substr($row['delivery_date'],0,16)),$border,0,'R',0); 
     $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",$row['customer_name']),$border,0,'R',0); 
   $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",$row['member_id']),$border,0,'R',0); 
   $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",$row['branchID']),$border,0,'R',0); 
   $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",$row['delivery']),$border,0,'R',0); 
   $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",$row['sales_name']),$border,0,'R',0); 
    $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",$row['total_price']),$border,0,'R',0); 
    $this->Cell(20,7,iconv("UTF-8", "BIG5-HKSCS",substr($row['created_by'],0,10)."/".substr($row['last_update_by'],0,10)),$border,1,'C',0);
	  
   }
 	
}


function Header()
{
	//Page header
	global $title;
	global $header_title;
	global $invoice_no;
	
	
	$w=$this->GetStringWidth($title)+6;
	$this->SetX(2);
	$this->SetDrawColor(255,255,255);
	$this->SetFillColor(233,233,233);
	$this->SetTextColor(0,0,0);
	//20060621$this->Ln(35);
	//$this->Ln(19);
	$this->SetLineWidth(0);
	

 
	 
  
 
  
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
$pdf=new pdf('L','mm','A4');
$pdf->SetAutoPageBreak(true,2);
$pdf->SetTopMargin(1);
$pdf->SetLeftMargin(0);
$pdf->AddBig5Font();
$title='發票';
$header_title=array();
 
$pdf->Body($date,$branchID);
$pdf->SetAuthor('YRT Company Limited');

$filepath='./invoice/pdf_edit/'.$date.'.pdf';
 
$pdf->Output($filepath,'F');
   echo "c";
?>
