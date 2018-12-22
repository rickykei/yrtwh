<?
$invoiceRecord=16;
$totalcounter=0;
//count input
for ($i=0;$i<$invoiceRecord;$i++)
{
	if ($goods_partno[$i]!="")
	$totalcounter++;
}

//* 20120709 +  buy 138-3 free 333

/*for ($i=0;$i<$totalcounter;$i++)
{
	if ($goods_partno[$i]=="138-3"){
		$goods_partno[$totalcounter]="3333";
		$qty[$totalcounter]=$qty[$i];
		$totalcounter++;
	}
}
*/
//* 20110911 +  buy 138-3 free 333 END
 

//get name
require_once("./include/config.php");
require_once("./include/functions.php");


//20160825 remove del_timeslot when delivery="w"
if ($delivery=='W')
{$delivery_timeslot=0;
$delivery_date='';}

//correct time slot to del date 20151211

$delivery_date=correct_delTimeSlot_to_delDate($delivery_date,$delivery_timeslot);

//correct time slot to del date 20151211

   $query="SET NAMES 'UTF8'";
    $connection = DB::connect($dsn);

   if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());

	$total_man_power_price=0;

	for ($i=0;$i<$totalcounter;$i++)
	{
		$query="select * from sumgoods where goods_partno='".$goods_partno[$i]."' and status='Y'";
		$result=$connection->query($query);
		if (DB::isError($result)) die ($result->getMessage());
	    $row = $result->fetchRow(DB_FETCHMODE_ASSOC);

	//20060409 trim special char from input
	$goods_detail[$i]=htmlspecialchars(stripslashes($goods_detail[$i]));
	if ($goods_detail[$i]=="")
    $goods_detail[$i]=$row["goods_detail"];
	if ($market_price[$i]=="")
    $market_price[$i]=$row["market_price"];

	// if 
	//echo $i."manpower=".$manpower[$i];
	if ($manpower[$i]=="Y")
	{
	$count_man_flag=1;
	$total_man_power_price=$total_man_power_price+($qty[$i]*$market_price[$i]);
	  
	}
	else
	{		      
	}
	
	
	}

$temp_total_man_power_price=$total_man_power_price;
//part of manpowerprice
if ($count_man_flag==1)
{
	if ($total_man_power_price>=2500)
	{
	//$total_man_power_price=$total_man_power_price*0.06; 20060625
	$total_man_power_price=$total_man_power_price*$special_man_power_percent/100;
	}
	else
	{
	$total_man_power_price=2500*$special_man_power_percent/100;
}

	if ($total_man_power_price<150)
		$total_man_power_price=150;
	
	
	
	
	
	

//Part of special man power
/*if ($count_man_flag==1&&$special_man_power_percent!=0)
{
//echo "specialMn";
//echo "special_manpowerPrice"+$special_man_power_percent;
	$total_man_power_price=$total_man_power_price+(($temp_total_man_power_price*$special_man_power_percent)/100);
//	echo $total_man_power_price;
}
*/
}
?> 
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
function MM_findObj(n, d) { //v4.0
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && document.getElementById) x=document.getElementById(n); return x;
}

function MM_showHideLayers() { //v3.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v='hide')?'hidden':v; }
    obj.visibility=v; }
}
//-->
</script>
<script language="javascript">
function first_text_box_focus()
{
	document.form1.elements[0].focus();
}

function next_text_box(a)
{
	if (event.keyCode==13)
	{
	//alert(a);
	eval("document.form1.elements["+a+"].focus();");
	//alert(event.keyCode);
	return false;
	}

}

function AddrWindow(toccbcc){
	///var abc;
	//abc=document.form1.partno[0].value;
	//alert(abc);
	window.open('page_search_partno.php?recid=' + toccbcc,"","width=500,height=360,scrollbars=yes");
}
 
</script>
<script type="text/javascript" src="./include/invoice.js"></script>
<link href="./include/invoice.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<form name="form1" action="/?pos=<?php echo $pos;?>&id=<?php echo $id;?>&page=ipadpos&subpage=index6_edit.php" method="POST">
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td width="801" align="center" valign="top"><table width="101%" height="100%" border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="19%" height="21" bgcolor="#004d80"><span class="style6">出貨單</span></td>
        <td width="29%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#004d80">
            <td width="14%" height="21">
                <span class="style6"> 發票日期： </span>            </td>
            <td width="35%"><span class="style6"><?echo $invoice_date;?></span></td>
            <td width="16%"><span class="style6">送貨日期：</span></td>
            <td width="35%"><span class="style6"><?echo $delivery_date;?></span></td>
          </tr>
		    <tr bgcolor="#004d80">
            <td width="14%" height="21"></td>
            <td width="35%"><span class="style6"></span></td>
            <td width="16%"><span class="style6">送貨時間：</span></td>
            <td width="35%"><span class="style6"><?php
			if ($delivery_timeslot==1) echo "早 9-12";
			if ($delivery_timeslot==2) echo "午 12-2";
			if ($delivery_timeslot==3) echo "晚  2-6";
			?></span></td>
          </tr>
          <tr bgcolor="#004d80">
            <td><span class="style6">員工姓名：</span></td>
            <td><span class="style6"><?echo $sales;?></span></td>
            <td><span class="style6">送貨：</span></td>
            <td><span class="style6"><?if ($delivery=="Y") {echo "是";}else if($delivery=="S") {echo "自取";} else if($delivery=="C"){echo "街車送貨";} else {echo "等電";}?></span></td>
          </tr>
          <tr bgcolor="#004d80">
            <td height="23"><span class="style6">客戶名稱：</span></td>
            <td height="23"><span class="style6"><?echo $mem_name;?></span></td>
            <td height="23"><span class="style6">收貨人：</span></td>
            <td height="23"><span class="style6"><?echo $receiver;?></span></td>
          </tr>
		  <tr bgcolor="#004d80">
			<td height="23"><span class="style6"></span></td>
            <td height="24"><span class="style6"> </td>
			           
            <td height="24" class="style6">姓氏：</td>
            <td height="24"><span class="style6"><?echo $lastname;?></span></td>
          </tr>
          <tr bgcolor="#004d80">
            <td height="24"><span class="style6">客戶地址：</span></td>
            <td height="24"><span class="style6"><?echo $mem_add;?></span></td>
            <td height="24" class="style6">客戶編號：</td>
            <td height="24"><span class="style6"><?echo $mem_id;?></span></td>
          </tr>
          <tr bgcolor="#004d80">
            <td height="24"><span class="style6">入賬日期：</span></td>
            <td height="24"><span class="style6"><?=$settledate?></span></td>
           
            <td height="24"><span class="style6">
              <?if ($status=="A"){echo "入賑";}else if ($status=="S"){echo "掛單";} else {echo "訂金";};?>
            </span></td>
			 <td height="24" class="style6"> <?if ($deposit_method=="C"){echo "現金入賑";}else if ($deposit_method=="D"){echo "會員賑戶扣數";} ?></td>
          </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
          <tr bgcolor="#004d80">
            <td width="5%"><span class="style6">行數</span></td>
            <td width="24%" class="style6">貨品編號</td>
            <td width="32%" class="style6">項目</td>
            <td width="5%" class="style6">數量</td>
            <td width="13%" class="style6">單價</td>
            <td width="4%" class="style6">折扣</td>
            <td width="5%" class="style6">行送</td>
            <td width="9%" class="style6">界板</td>
            <!--<td width="2%"><span class="style6"><span class="style6">扶力</span></span></td> //-->
			<td width="2%"><span class="style6"><span class="style6">出貨</span></span></td>
          <td width="10%" class="style6">Subtotal</td>
          </tr>
		  <? 
		  $total_price=0.00;
		  for($i=0;$i<$totalcounter;$i++)
		  {?>
          <tr bgcolor="#CCCCCC">
            <td><span class="style7"><?echo $i+1;?></span></td>
            <td><span class="style7"><?echo $goods_partno[$i];?></span></td>
            <td><span class="style7"><?echo $goods_detail[$i];?></span></td>
            <td><span class="style7"><?echo $qty[$i];?></span></td>
            <td><span class="style7">$<?echo $market_price[$i];?></span></td>
            <td><span class="style7"><?echo $discount[$i];?></span></td>
            <td><span class="style7"><?if ($deductStock[$i]=="N"){ echo "Y";}else{echo "N";}?></span></td>
            <td><span class="style7"><?echo $cutting[$i];?></span></td>
            <!--<td><span class="style7"><?echo $manpower[$i];?></span></td> --->
			<td><span class="style7"><?echo $delivered[$i];?></span></td>
          <td><span class="style7"><?$subtotal[$i]=(($market_price[$i]-($market_price[$i]*$discount[$i])/100))*$qty[$i];echo "$".number_format($subtotal[$i], 2, '.', ', ');?></span></td>
          </tr>
		  <?
		  $total_price=$total_price+$subtotal[$i];
		  }
	
		  ?>
        </table>          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#004d80">
            <tr>
              <td width="16%">&nbsp;</td>
              <td width="13%">&nbsp;</td>
              <td width="15%">&nbsp;</td>
            <td width="39%">&nbsp;</td>
              <td width="8%">&nbsp;</td>
              <td width="9%">&nbsp;</td>
            </tr>
				<tr bgcolor="#CCCCCC"><td colspan='3'></td><td><div align="right"><span class="style7">合計</span><span class="style7">：</span></div></td>
				  <td colspan="4"><div align="left" class="style7">$<?php echo number_format($total_price, 2, '.', ',');?></div></td>
			    </tr>
		    <tr bgcolor="#CCCCCC"><td colspan='3'></td><td><div align="right"><span class="style7">扶力費</span><span class="style7">：</span></div></td>
		      <td colspan="4"><div align="left" class="style7">$<?php echo number_format($total_man_power_price, 2, '.', ',');?></div></td>
		      </tr>
			 <tr bgcolor="#CCCCCC">
			   <td colspan='3'></td>
			   <td align="right"><span class="style7">扶力費折扣：</span></td>
			   <td colspan="4"><span class="style7"><?echo $special_man_power_percent;?> %</span></td>
			   </tr>
			 <tr bgcolor="#CCCCCC"><td colspan='3'></td><td><div align="right"><span class="style7">總折扣</span><span class="style7">：</span></div></td>
			   <td colspan="4"><div align="left" class="style7">減<?php echo $subdiscount;?>% 減<?php echo number_format($subdeduct, 2, '.', ',');?>元 </div></td>
			   </tr>
			 <tr bgcolor="#CCCCCC">
			   <td height="23" colspan='3'></td>
			   <td align="right" class="style7">訂金：</td>
			   <td colspan="4"><span class="style7">$<?
		$subsubtotal=($total_man_power_price+$total_price)*(100-$subdiscount)/100-$subdeduct;
//20060426
		if ($status=="A"|| $status=="D")
{
 echo number_format($subsubtotal, 2, '.', ',');
  }else{
		 echo number_format($deposit, 2, '.', ',');
		 }
			  
			   ?></span></td>
			   </tr>
			 <tr bgcolor="#CCCCCC">
			   <td height="23" colspan='3'></td>
			   <td align="right" class="style7">信用卡：</td>
			   <td colspan="4">
			     <div align="left"><span class="style7">
			       $<?
		   $creditcardtotal=0;
			$creditcardrate=0;
		 if ($creditcard=="on"){
		 			$creditcardrate=3;
		 			$creditcardtotal=round($subsubtotal*$creditcardrate/100);
					$subsubtotal=$subsubtotal+$creditcardtotal;
		 }
		echo  number_format($creditcardtotal, 2, '.', ',');

			  
			   ?>
			       <br />
			     </span></div></td>
			   </tr>
			 <tr bgcolor="#CCCCCC">
			   <td height="23" colspan='3'></td>
			   <td align="right"><span class="style7">總合計</span><span class="style7">：</span></td>
			   <td colspan="4"><span class="style7">$<?php
					
				  echo number_format($subsubtotal, 2, '.', ',');
				  ?>
			   </span></td>
			   </tr>
          </table>          </td>
      </tr>
      <tr>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td height="">&nbsp;</td>
        <td>
        
        <input type="hidden" name="invoice_date" value="<? echo $invoice_date;?>">
        <input type="hidden" name="delivery_date" value="<? echo $delivery_date;?>">
		<input type="hidden" name="delivery_timeslot" value="<? echo $delivery_timeslot;?>">
        <input type="hidden" name="settledate" value="<? echo $settledate;?>">
		<input type="hidden" name="sales" value="<? echo $sales;?>" />
        <input type="hidden" name="mem_id" value="<? echo $mem_id;?>">
        <input type="hidden" name="mem_name" value="<? echo $mem_name;?>">
        <input type="hidden" name="mem_add" value="<? echo $mem_add;?>">
        <input type="hidden" name="mem_tel" value="<? echo $mem_tel;?>">
		<input type="hidden" name="AREA" value="<?echo $AREA;?>" />
		<input type="hidden" name="PC" value="<?echo $PC;?>" />
		<input type="hidden" name="delivery" value="<?echo $delivery;?>" />
		<input type="hidden" name="special_man_power_percent" value="<?=$special_man_power_percent?>" />
        <input type="hidden" name="receiver" value="<?=$receiver?>" />
		<input type="hidden" name="lastname" value="<?=$lastname?>" />
		<input type="hidden" name="pos" value="<?=$pos?>"/>
		
        <?php
        for($i=0;$i<$totalcounter;$i++)
        {
        ?>
        <input type="hidden" name="goods_partno[]" value="<? echo $goods_partno[$i];?>">
        <input type="hidden" name="goods_detail[]" value="<? echo $goods_detail[$i];?>">
        <input type="hidden" name="qty[]" value="<? echo $qty[$i];?>">
        <input type="hidden" name="market_price[]" value="<? echo $market_price[$i];?>">
        <input type="hidden" name="discount[]" value="<? echo $discount[$i];?>">
        <input type="hidden" name="subtotal[]" value="<? echo $subtotal[$i];?>">
		<input type="hidden" name="manpower[]" value="<? echo $manpower[$i];?>" />
		<input type="hidden" name="delivered[]" value="<? echo $delivered[$i];?>" />
		<input type="hidden" name="deductStock[]" value="<? echo $deductStock[$i];?>" />
		<input type="hidden" name="cutting[]" value="<? echo $cutting[$i];?>" />
        <?php }?>
		
		<input type="hidden" name="status" value="<?=$status?>"/>
<?
//20060426
		if ($status=="A")
{
	?>	<input type="hidden" name="deposit" value="<?=$subsubtotal?>"/>
		<? }else{?>
		<input type="hidden" name="deposit" value="<?=$deposit?>"/>
<? }?>
		<input type="hidden" name="deposit_method" value="<?=$deposit_method?>"/>
		<input type="hidden" name="creditcardtotal" value="<?=$creditcardtotal?>"/>
   		<input type="hidden" name="creditcardrate" value="<?=$creditcardrate?>"/>
		<input type="hidden" name="subsubtotal" value="<?=$subsubtotal?>"/>
		<input type="hidden" name="subdiscount" value="<? echo $subdiscount;?>" />
		<input type="hidden" name="subdeduct" value="<? echo $subdeduct;?>" />
		<input type="hidden" name="man_power_price" value="<? echo $total_man_power_price;?>" />
        <input name="clear" type="reset" id="clear" value="上一步" onClick="history.back(1);;">
        <input name="submitb" type="submit" id="submitb" value="送出"></td>
      </tr>
    </table></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
 
