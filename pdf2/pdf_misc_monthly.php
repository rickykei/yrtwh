<?php

error_reporting(E_ERROR | E_PARSE);
 echo "<?xml version=\"1.0\" encoding=\"utf-8\"?".">"; ?><?php
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
function Body($month,$year,$shop)
{

   include("./include/config.php");

    $connection = DB::connect($dsn);

   if (DB::isError($connection))
      die($connection->getMessage());
   $result = $connection->query("SET NAMES 'UTF8'");

      if (DB::isError($result))
      die ($result->getMessage());
  

   $miscCnt=0;
   $sql="SELECT * FROM misc where year(invoice_date) ='".$year."' and month(invoice_date)='".$month."' and area='".$shop."' order by invoice_date";
   
    $result = $connection->query($sql);

   if (DB::isError($resultMisc)) die ($resultMisc->getMessage());
   
   $counter=0;
   while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC))
   {
	
    $id[$counter]=$row["id"];
	$daily_revenue[$counter]=$row['daily_revenue'];
	$daily_expend[$counter]=$row['daily_expend'];
	$daily_cheque[$counter]=$row['daily_cheque'];
	$daily_creditcard[$counter]=$row['daily_creditcard'];
	$daily_unionpay[$counter]=$row['daily_unionpay'];
	$daily_eps[$counter]=$row['daily_eps'];
	$daily_cash[$counter]=$row['daily_cash'];
	$daily_income[$counter]=$row['daily_income'];
	$daily_drawer[$counter]=$row['daily_drawer'];
	$past_daily_drawer[$counter]=$row['past_daily_drawer'];
	$drawer_diff[$counter]=$row['drawer_diff'];
	$area[$counter]=$row['area'];
	$invoice_date[$counter]=$row['invoice_date'];
	
	
	//cal misc total
	
	 
   $resultMisc= $connection->query(" Select sum(misc_amt) as sum from misc_misc where misc_id =". $id[$counter]);
    if (DB::isError($resultMisc))
      die ($resultMisc->getMessage());
   while ($row =& $resultMisc->fetchRow(DB_FETCHMODE_ASSOC))
   {
	$daily_misc_total[$counter]=$row["sum"];
	}
	
	//cal chq total
	
   $resultMisc= $connection->query(" Select sum(cheque_amt) as sum from misc_chq where misc_id =". $id[$counter]);
    if (DB::isError($resultMisc))
      die ($resultMisc->getMessage());
   while ($row =& $resultMisc->fetchRow(DB_FETCHMODE_ASSOC))
   {
	$daily_chq_total[$counter]=$row["sum"];
	}
	
	//cal chq total
	
   $resultMisc= $connection->query(" Select sum(cash_amt) as sum from misc_cash where misc_id =". $id[$counter]);
    if (DB::isError($resultMisc))
      die ($resultMisc->getMessage());
   while ($row =& $resultMisc->fetchRow(DB_FETCHMODE_ASSOC))
   {
	$daily_cash_total[$counter]=$row["sum"];
	}
	
	$counter++;
   }
  
    
  

 
     
   
 $this->SetY(-8);
   //$this->Ln(95);
  // $this->Ln(85);
   $this->SetTextColor(0,0,0);
   $this->SetFont('Big5','',16);
  // $this->SetDrawColor(255,255,255);
  $border=1;
  
  $this->Cell(310,8,iconv("UTF-8", "BIG5-HKSCS",$year."年".$month."月".$shop."鋪"),$border,1,'C',0);
  $this->SetFont('Big5','',12);
  
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","日期"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","現金收入"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","現金支出"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","支票"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","信用卡"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","EPS"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","銀聯"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","收入總額"),$border,1,'R',0);
	
	//$this->Cell(50,8,iconv("UTF-8", "BIG5-HKSCS","備註"),$border,1,'R',0);
	 
	$this->SetFont('Big5','',12);
		 
	
	for ($i=0;$i<$counter;$i++)
	{
  
	$this->Cell(30,7,iconv("UTF-8", "BIG5-HKSCS",$invoice_date[$i]),$border,0,'R',0);
	
	$this->Cell(30,7,iconv("UTF-8", "BIG5-HKSCS",$daily_income[$i]),$border,0,'R',0);
	$a+=$daily_income[$i];
	$this->Cell(30,7,iconv("UTF-8", "BIG5-HKSCS",$daily_expend[$i]),$border,0,'R',0);
	$b+=$daily_expend[$i];
	$this->Cell(30,7,iconv("UTF-8", "BIG5-HKSCS",$daily_chq_total[$i]),$border,0,'R',0);
	$c+=$daily_chq_total[$i];
	$this->Cell(30,7,iconv("UTF-8", "BIG5-HKSCS",$daily_creditcard[$i]),$border,0,'R',0);
	$d+=$daily_creditcard[$i];
	$this->Cell(30,7,iconv("UTF-8", "BIG5-HKSCS",$daily_eps[$i]),$border,0,'R',0);
	$e+=$daily_eps[$i];
	$this->Cell(30,7,iconv("UTF-8", "BIG5-HKSCS",$daily_unionpay[$i]),$border,0,'R',0);
	$f+=$daily_unionpay[$i];
	
	$this->Cell(30,7,iconv("UTF-8", "BIG5-HKSCS",$daily_revenue[$i]),$border,1,'R',0);
	$g+=$daily_revenue[$i];
	
	//$this->Cell(50,8,iconv("UTF-8", "BIG5-HKSCS"," "),$border,1,'R',0);
	 	 
	}
	
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",'Total:'),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$a),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$b),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$c),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$d),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$e),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$f),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$g),$border,1,'R',0);
	//$this->Cell(50,8,iconv("UTF-8", "BIG5-HKSCS"," "),$border,1,'R',0);
	 
 
 $result->free ();
  
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
	$this->Ln(0);
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
$pdf=new pdf('L','mm',array(216,297));
$pdf->SetAutoPageBreak(true,2);
$pdf->SetTopMargin(0);
$pdf->SetLeftMargin(0);
$pdf->AddBig5Font();
$title='收支日報表';
$header_title=array();
 
$pdf->Body($month,$year,$shop);
 
$pdf->SetAuthor('YRT Company Limited');

$filepath='./statistic/misc_monthly_pdf/'.$invoice_date.'_'.$shop.'.pdf';
 
 
//echo $filepath;
$pdf->Output($filepath,'F');
?>
