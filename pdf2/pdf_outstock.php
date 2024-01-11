<?php echo "<?xml version=\"1.0\" encoding=\"utf-8\"?".">"; ?><?php
define('FPDF_FONTPATH','./font/');
 
require('./pdf2/chinese.php');

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
   $sql = "SELECT * FROM outstock where outstock_no=".$invoice_no;
  
   $result = $connection->query($sql);

      if (DB::isError($result))
      die ($result->getMessage());
	while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC))
   {
     // Print out each element in $row, that is, print the values of
      // the attributes
	
     
	$outstock_no=iconv("UTF-8", "BIG5-HKSCS",$row['outstock_no']);
	$outstock_date=iconv("UTF-8", "BIG5-HKSCS",$row['outstock_date']);
	$sales_name=$row['staff_name'];
	$to_shop=$row['to_shop'];
	$delivery_method=$row['delivery_method'];
		
	$sql=" Select * from staff where name = '".$sales_name."'";
	$resultStaff= $connection->query($sql);
	$rowStaff=$resultStaff->fetchRow(DB_FETCHMODE_ASSOC);
	$staffTel=$rowStaff['telno'];
 
	
 
	  
   }

	$this->SetY(-3);
  $this->SetTextColor(0,0,0);
   	$this->SetFont('Big5','',10);
   
  $border=0;
   $header_height=5;
	$body_height=8;
 
	$this->Cell(30,$header_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(82,$header_height,iconv("UTF-8", "BIG5-HKSCS",'亞馬遜貿易有限公司'),$border,0,'C',0);
	$this->Cell(30,$header_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);

	$this->Cell(30,$header_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(82,$header_height,iconv("UTF-8", "BIG5-HKSCS",'Amazon  Trading Co., Ltd'),$border,0,'C',0);
    $this->Cell(30,$header_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,1,'C',0);
	
	$this->Cell(30,$header_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(82,$header_height,iconv("UTF-8", "BIG5-HKSCS",'香港九龍旺角塘尾道85-95號長豐大廈A-M座地下'),$border,0,'L',0);
	$this->Cell(30,$header_height,iconv("UTF-8", "BIG5-HKSCS",$delLabel),$border,1,'C',0);
	
	$this->Cell(36,$header_height,iconv("UTF-8", "BIG5-HKSCS","Tel："),$border,0,'R',0);
	$this->Cell(35,$header_height,iconv("UTF-8", "BIG5-HKSCS","(852)2787-3378"),$border,0,'L',0);
	$this->Cell(35,$header_height,iconv("UTF-8", "BIG5-HKSCS","FAX："),$border,0,'R',0);
	$this->Cell(36,$header_height,iconv("UTF-8", "BIG5-HKSCS","(852)2412-2661"),$border,1,'L',0);
 

	$this->Cell(36,$header_height,iconv("UTF-8", "BIG5-HKSCS","TO："),$border,0,'R',0);
	$this->Cell(35,$header_height,iconv("UTF-8", "BIG5-HKSCS","屯門倉"),$border,0,'L',0);
	$this->Cell(35,$header_height,iconv("UTF-8", "BIG5-HKSCS","FAX："),$border,0,'R',0);
	$this->Cell(36,$header_height,iconv("UTF-8", "BIG5-HKSCS","2674-1073"),$border,1,'L',0);
	
	 $this->Cell(140,$header_height,iconv("UTF-8", "BIG5-HKSCS","    ** 新界粉嶺軍地北村DD83 Lot No.118"),$border,1,'L',0);
 
	$this->Cell(36,$header_height,iconv("UTF-8", "BIG5-HKSCS","ATTN："),$border,0,'R',0);
	$this->Cell(35,$header_height,iconv("UTF-8", "BIG5-HKSCS","呀安"),$border,0,'L',0);
	$this->Cell(35,$header_height,iconv("UTF-8", "BIG5-HKSCS","提單號碼："),$border,0,'R',0);
	$this->Cell(36,$header_height,iconv("UTF-8", "BIG5-HKSCS","FL-".$outstock_no),$border,1,'L',0);
	
	$this->Cell(36,$header_height,iconv("UTF-8", "BIG5-HKSCS","FROM："),$border,0,'R',0);
	$this->Cell(35,$header_height,iconv("UTF-8", "BIG5-HKSCS","Sandy"),$border,0,'L',0);
	$this->Cell(35,$header_height,iconv("UTF-8", "BIG5-HKSCS","日期："),$border,0,'R',0);
	$this->Cell(36,$header_height,iconv("UTF-8", "BIG5-HKSCS",$outstock_date),$border,1,'L',0);
	
	$this->Ln(4);
	$this->Cell(142,$header_height,iconv("UTF-8", "BIG5-HKSCS",'提貨單'),$border,1,'C',0);
	
	$this->Cell(10,$body_height,iconv("UTF-8", "BIG5-HKSCS","位置".$row2['place']),$border,0,'R',0);
	
	$this->Cell(60,$body_height,iconv("UTF-8", "BIG5-HKSCS","貨品名稱"),$border,0,'R',0);
	$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS","箱數"),$border,0,'C',0);
	$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS","裝數"),$border,0,'R',0);
	$this->Cell(32,$body_height,iconv("UTF-8", "BIG5-HKSCS",'重量 (KG)'),$border,1,'L',0);
	

//print goods_invoice
   $sql="SELECT * FROM goods_outstock a where outstock_no=".$invoice_no." order by a.id asc";
   $result = $connection->query($sql);
  
      if (DB::isError($result))
      die ($result->getMessage());
	  $i=1;
	  $this->SetFont('Big5','',14);
	while ($row2 =& $result->fetchRow(DB_FETCHMODE_ASSOC))
   {
	 
   $weight=getPartNoWeight($row2['goods_partno'],$connection)*$row2['qty'];
   $this->Cell(10,$body_height,iconv("UTF-8", "BIG5-HKSCS","".$row2['place']),$border,0,'R',0);
	
	$this->Cell(60,$body_height,iconv("UTF-8", "BIG5-HKSCS","".$row2['goods_detail']),$border,0,'R',0);
	//remove box num requested by alvin 20190109
	//$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS","".$row2['box']."(".calOutstockBoxNum($row2['goods_partno'],$row2['box'],$invoice_no,$connection).")"),$border,0,'C',0);
	$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS","".$row2['box']),$border,0,'C',0);
	$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS","".$row2['qty']),$border,0,'R',0);
	$this->Cell(32,$body_height,iconv("UTF-8", "BIG5-HKSCS",''.$weight),$border,1,'L',0);
	
	 $totalBox+=$row2['box'];
	$totalWeight+=$weight;
	$i++;
  
   }
   $this->SetFont('Big5','',14);
   $result->free ();
	$this->Ln(10);
	$this->Cell(22,$body_height,iconv("UTF-8", "BIG5-HKSCS","屯門倉去"),$border,0,'R',0);
	$this->Cell(40,$body_height,iconv("UTF-8", "BIG5-HKSCS","".$to_shop),$border,0,'R',0);
	$this->Cell(40,$body_height,iconv("UTF-8", "BIG5-HKSCS","去軍地"),$border,0,'L',0);
	$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS","".$delivery_method),$border,0,'R',0);
	$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS",''),$border,1,'L',0);
	$this->Ln(10);
	$this->Cell(22,$body_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(40,$body_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(40,$body_height,iconv("UTF-8", "BIG5-HKSCS","總共".$totalBox."箱"),$border,0,'C',0);
	$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS",''),$border,1,'L',0);
	$this->Ln(10);	  
	$this->Cell(22,$body_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(40,$body_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(40,$body_height,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'L',0);
	$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS","總重".$totalWeight),$border,0,'R',0);
	$this->Cell(20,$body_height,iconv("UTF-8", "BIG5-HKSCS",''),$border,1,'L',0);

 	
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
$pdf=new pdf('P','mm','A5');;
$pdf->SetAutoPageBreak(true,2);
$pdf->SetTopMargin(3);

$pdf->SetMargins(3,3);
$pdf->AddBig5Font();
$title='提貨單';
$header=array('提貨單');
$header_title=array();

$invoice_no=$outstock_no;
$pdf->Body($invoice_no);
$pdf->SetAuthor('YRT Company Limited');

$filepath='./outstock/pdf/'.$invoice_no.'.pdf';
if (file_exists($filepath)) {
	//move to backup
	$file_timestamp=date("Ymd_His") ;
	$filepathnew='./outstock/backuppdf/'.$invoice_no.'_'.$file_timestamp.'.pdf';
	copy($filepath, $filepathnew);
}
$pdf->Output($filepath,'F');
?>
