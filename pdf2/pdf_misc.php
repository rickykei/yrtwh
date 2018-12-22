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
   $result = $connection->query("SELECT * FROM misc where id=".$invoice_no);

      if (DB::isError($result))
      die ($result->getMessage());
  
  
   $miscCnt=0;
   $resultMisc= $connection->query(" Select * from misc_misc where misc_id =".$invoice_no);
   if (DB::isError($resultMisc)) die ($resultMisc->getMessage());
   while ($row =& $result->fetchRow(DB_FETCHMODE_ASSOC))
   {
    $id=$row["id"];
	$daily_revenue=$row['daily_revenue'];
	$daily_expend=$row['daily_expend'];
	$daily_cheque=$row['daily_cheque'];
	$daily_creditcard=$row['daily_creditcard'];
	$daily_unionpay=$row['daily_unionpay'];
	$daily_eps=$row['daily_eps'];
	$daily_cash=$row['daily_cash'];
	$daily_income=$row['daily_income'];
	$daily_drawer=$row['daily_drawer'];
	$past_daily_drawer=$row['past_daily_drawer'];
	$drawer_diff=$row['drawer_diff'];
	$area=$row['area'];
	$invoice_date=$row['invoice_date'];
	
}
  
  
   $miscCnt=0;
   $resultMisc= $connection->query(" Select * from misc_misc where misc_id =".$invoice_no);
    if (DB::isError($resultMisc))
      die ($resultMisc->getMessage());
   while ($row =& $resultMisc->fetchRow(DB_FETCHMODE_ASSOC))
   {
	
	$misc_misc[$miscCnt]=$row["misc"];
	$misc_miscAmt[$miscCnt]=$row["misc_amt"];
	$miscCnt++;
	
   }

    $miscCnt=0;
	$resultMisc= $connection->query(" Select * from misc_chq where misc_id =".$invoice_no);
	 if (DB::isError($resultMisc))
      die ($resultMisc->getMessage());
   while ($row =& $resultMisc->fetchRow(DB_FETCHMODE_ASSOC))
   {     
	$cheque[$miscCnt]=$row["cheque"];
	$cheque_amt[$miscCnt]=$row["cheque_amt"];
	$miscCnt++;
   }
   
     $miscCnt=0;
	 	$resultMisc= $connection->query(" Select * from misc_cash where misc_id =".$invoice_no);
		 if (DB::isError($resultMisc))
      die ($resultMisc->getMessage());
   while ($row =& $resultMisc->fetchRow(DB_FETCHMODE_ASSOC))
   {

  
	$cash[$miscCnt]=$row["cash"];
	$cashAmt[$miscCnt]=$row["cash_amt"];
	$miscCnt++;
   }
   
 $this->SetY(-8);
   //$this->Ln(95);
  // $this->Ln(85);
   $this->SetTextColor(0,0,0);
   $this->SetFont('Big5','',16);
  // $this->SetDrawColor(255,255,255);
  $border=1;
  
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","收支日報表"),$border,0,'R',0);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS","發票日期"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$invoice_date),$border,0,'R',0);
	$this->Cell(40,8,iconv("UTF-8", "BIG5-HKSCS",$area),$border,1,'C',0);
	 
	$this->SetFont('Big5','',12);
		$this->Ln(5);
	
	
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",'什項支出'),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",'金額'),$border,0,'R',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'C',0);
    $this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",'支票'),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",'金額'),$border,1,'R',0);
	
	for ($i=0;$i<15;$i++){
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",$i+1),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$misc_misc[$i]),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$misc_miscAmt[$i]),$border,0,'R',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",$i+1),$border,0,'R',0);
    $this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$cheque[$i]),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$cheque_amt[$i]),$border,1,'R',0);
	}
	  $this->SetFont('Big5','',12);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","生意總額"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$daily_revenue),$border,0,'R',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'C',0);
    $this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",'是日存柜'),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$daily_drawer),$border,1,'R',0);
	
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","總支出"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$daily_expend),$border,0,'R',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",'昨日存柜'),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$past_daily_drawer),$border,1,'R',0);
	
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","支票"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$daily_cheque),$border,0,'R',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",'差額'),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$drawer_diff),$border,1,'R',0);
 
	
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","信用卡"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$daily_creditcard),$border,0,'R',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,1,'R',0);
 
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","銀聯卡"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$daily_unionpay),$border,0,'R',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,1,'R',0);
	
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","EPS"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$daily_eps),$border,0,'R',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,1,'R',0);
  
    $this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",""),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS","入數"),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",$daily_income),$border,0,'R',0);
	$this->Cell(10,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'C',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,0,'R',0);
	$this->Cell(30,8,iconv("UTF-8", "BIG5-HKSCS",''),$border,1,'R',0);
 
 
 
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
$pdf=new pdf('P','mm',array(210,297));
$pdf->SetAutoPageBreak(true,2);
$pdf->SetTopMargin(0);
$pdf->SetLeftMargin(0);
$pdf->AddBig5Font();
$title='收支日報表';
$header_title=array();
$pdf->Body($invoice_no);
$pdf->SetAuthor('YRT Company Limited');

$filepath='./misc/pdf/'.$invoice_no.'.pdf';
 
if (file_exists($filepath)) {
	//move to backup
	$file_timestamp=date("Ymd_His") ;
	$filepathnew='./misc/backuppdf/'.$invoice_no.'_'.$file_timestamp.'.pdf';
	copy($filepath, $filepathnew);
}
//echo $filepath;
$pdf->Output($filepath,'F');
?>
