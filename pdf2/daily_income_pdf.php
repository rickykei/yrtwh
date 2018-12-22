<?php
define('FPDF_FONTPATH','./font/');
 
require('chinese.php');

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
   include("../include/config.php");
 
   

 $this->SetY(-3);
   //$this->Ln(95);
  // $this->Ln(85);
   $this->SetTextColor(0,0,0);
   $this->SetFont('Big5','',16);
  // $this->SetDrawColor(255,255,255);
  $border=1;
  $border0=0;
  
 
	 
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS","收支日報表 "),$border0,0,'R',0);
	$this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",""),$border0,0,'C',0);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border0,1,'C',0);
	  $this->SetFont('Big5','',10);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",$_POST["invoice_date"]),$border0,0,'R',0);
  $this->Cell(125,8,iconv("UTF-8", "BIG5-HKSCS",$AREA."店總數: $".$_POST["shopTotal"]),$border0,0,'R',0);
  $this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",""),$border0,1,'C',0);
    
    $this->Ln(10);
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),"",0,'C',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS","行數"),$border,0,'C',0);
 	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","什項支出"),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","金額 $"),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","銀行"),$border,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","支票NO"),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","金額 $"),$border,1,'C',0);
	
	 $spending=$_POST["spending"];
	$spend_amt=$_POST["spend_amt"];
	$bank=$_POST["bank"];
	$chequeno=$_POST["chequeno"];
	$cheque_amt=$_POST["cheque_amt"];
	 
	for($i=0;$i<17;$i++){
	
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),"",0,'C',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",$i+1),$border,0,'C',0);
 	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$spending[$i]),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$spend_amt[$i]),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$bank[$i]),$border,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$chequeno[$i]),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$cheque_amt[$i]),$border,1,'C',0);
	}
 
		$this->Ln(3);
$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),"",0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","總支出"),$border,0,'C',0);
 	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","支票"),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","VISA"),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","EPS"),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","現金券"),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","入數"),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","是日存柜"),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","昨日存柜"),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS","差額"),$border,1,'C',0);
	
	$this->Cell(5,8,iconv("UTF-8", "BIG5-HKSCS",""),"",0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$_POST["total_expend"]),$border,0,'C',0);
 	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$_POST["total_cheque"]),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$_POST["visa"]),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$_POST["eps"]),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$_POST["cashcoupon"]),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$_POST["total_cheque"]),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$_POST["today"]),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$_POST["yestarday"]),$border,0,'C',0);
	$this->Cell(20,8,iconv("UTF-8", "BIG5-HKSCS",$_POST["different"]),$border,1,'C',0);
 	
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
	$this->Ln(10);
	$this->SetLineWidth(0);
	
 
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

 $filepath='../daily_income_report/pdf/'.$invoice_no.'.pdf';
 
$pdf->Output($filepath,'F');
header('Location: '.$filepath);
?>
