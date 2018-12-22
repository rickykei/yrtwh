<?php
	$invoiceRecord=16;
	require_once("./include/config.php");
	require_once("./include/functions.php");
	  include_once("./include/timestamp.php");
	//get Staff name
	$connection = DB::connect($dsn);
    if (DB::isError($connection))
      die($connection->getMessage());
       $query="SET NAMES 'UTF8'";
    
    if (DB::isError($connection)) die($connection->getMessage());

   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
	  $sql="SELECT * FROM staff";
	 $staffResult = $connection->query($sql);
         $ts = new TIMESTAMP;
	   
	$id=$_REQUEST['id'];
	//load invoice_header
	$sql="Select * from invoice where invoice_no = ".$id;
	$invoiceResult = $connection->query($sql);
	$invoicerow = $invoiceResult->fetchRow(DB_FETCHMODE_ASSOC);
	
	   
?><META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
 
<? // = $ajax->loadJsCore(true) ?>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/functions.js"></script>
<script type="text/javascript" src="./include/invoice.js"></script>
<link href="./include/invoice.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./js/js.storage.min.js"></script> 
<script type="text/javascript">
 
  var pos='<?php echo $pos;?>';
  
 	  function backPOS(){
		  
			var item=[];
			var i=0;
			var items =[];
			
					 
			for(i=0;i<16;i++) {
			 
				 if ($('#goods_partno'+i).val()!="" && $('#goods_partno'+i).val()!=null){
					item[0] = $('#qty'+i).val();
					item[1] = $('#goods_partno'+i).val();
					item[2] = $('#goods_detail'+i).val();
					item[3] = $('#market_price'+i).val();
					item[4] ='';
					item[5] = $('#discount'+i).val();
					item[6] ='';
					item[7] ='';
					item[8] ='';
					item[9] = $('#deductStockX'+i).val();
					item[10] = $('#cuttingX'+i).val();
					item[11] = $('#deliveredX'+i).val();
					
					items.push(item);
					 localStorage.setItem(pos+'_myItems',JSON.stringify(items));
					 item=[];
				 }
			}
				 
			 window.location.href="/?page=<?echo $page;?>&subpage=index_edit.php&pos=<?php echo $pos;?>&id=<?php echo $id;?>";
 	};

 $(function() {
	
	 var items = localStorage.getItem(pos+'_memid');
		items = JSON.parse(items);
		$(items).each(function (index, data) {
			$('#mem_id').val(data);
		});
		var items = localStorage.getItem(pos+'_memadd');
		items = JSON.parse(items);
		$(items).each(function (index, data) {
			$('#mem_add').val(data);
		});
		var items = localStorage.getItem(pos+'_receiver');
		items = JSON.parse(items);
		$(items).each(function (index, data) {
			$('#receiver').val(data);
		});
	
	function refresh(){
		
		items = localStorage.getItem(pos+'_myItems');
			if (items != null) {
		
			items = JSON.parse(items);
			var counter = 0;
			var total_price=0;
			$(items).each(function (index, data) {
			 
			 
			  $('#qty'+index).val(data[0]);
			  $('#goods_detail'+index).val(data[2]);
			  $('#market_price'+index).val(data[3]);
			  $('#goods_partno'+index).focus();
			 // findPartNoAjax(index);
			    
				
 
				var newRow = $("<tr>");
				var cols = "";

				
			
					cols += '<td><div align="center"><span class="style7">'+(counter+1)+'</span></div></td></td>';
					cols += '<td><input name="goods_partno[]" type="text" id="goods_partno'+counter+'"   readonly="readonly" value="'+data[1]+'"/></td>';
					cols += '<td><input name="qty[]" type="text" id="qty'+counter+'"  value="'+data[0]+'"   ></td>';
					if (data[4]=='Y'){
						cols += '<td><input name="goods_detail[]" type="text" id="goods_detail'+counter+'"  size="35" value="'+data[2]+'" readonly="readyonly"></td>';
						cols += '<td> <input name="market_price[]" type="text" id="market_price'+counter+'"  value="'+data[3]+'"    readonly="readonly"/></td>';
					}else{
						cols += '<td><input name="goods_detail[]" type="text" id="goods_detail'+counter+'"  size="35" value="'+data[2]+'"  ></td>';
						cols += '<td> <input name="market_price[]" type="text" id="market_price'+counter+'"  value="'+data[3]+'"    /></td>';
					}
					
					if (data[5]==null){
						cols += '<td> <input name="discount[]" type="text" id="discount'+counter+'"  value="0"   /></td>';
					}else{
						cols += '<td> <input name="discount[]" type="text" id="discount'+counter+'"  value="'+data[5]+'"   /></td>';
					}
				 
					
					if (data[9]=='N'){
					cols += '<td> <input name="deductStockX[]" type="checkbox"  id="deductStockX'+counter+'" value="Y" onClick="javascript:clickCheckBoxDeductStock('+counter+')" checked/></td>';
					cols += '<input type="hidden" name="deductStock[]" id="deductStock'+counter+'" value="N"/>';
					}
					else{
					cols += '<td> <input name="deductStockX[]" type="checkbox"  id="deductStockX'+counter+'" value="N" onClick="javascript:clickCheckBoxDeductStock('+counter+')" /></td>';	
					cols += '<input type="hidden" name="deductStock[]" id="deductStock'+counter+'" value="Y"/>';
					}
					
				  
					if (data[10]=='N'){
					cols += '<td> <input name="cuttingX[]" type="checkbox"  id="cuttingX'+counter+'" value="N" onClick="javascript:clickCheckBoxCutting('+counter+')" /></td>';
					cols += '<input type="hidden" name="cutting[]" id="cutting'+counter+'" value="N"/>';
					}else{
					cols += '<td> <input name="cuttingX[]" type="checkbox"  id="cuttingX'+counter+'" value="Y" onClick="javascript:clickCheckBoxCutting('+counter+')" checked/></td>';	
					cols += '<input type="hidden" name="cutting[]" id="cutting'+counter+'" value="Y"/>';
					}
				
					if (data[11]=='N'){
					cols += '<td> <input name="deliveredX[]" type="checkbox"  id="deliveredX'+counter+'" value="N" onClick="javascript:clickCheckBoxDelivered('+counter+')" /></td>';
					cols += '<input type="hidden" name="delivered[]" id="delivered'+counter+'" value="N"/>';
					}else{
					cols += '<td> <input name="deliveredX[]" type="checkbox"  id="deliveredX'+counter+'" value="Y" onClick="javascript:clickCheckBoxDelivered('+counter+')" checked/></td>';
					cols += '<input type="hidden" name="delivered[]" id="delivered'+counter+'" value="Y"/>';
					}
				
					cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger " data="'+counter+'" value="Delete"></td>';
				
				
				total_price=total_price+parseFloat(data[3])*parseFloat(data[0]);
				
			
				newRow.append(cols);
				$("table.order-list").append(newRow);
				counter++;
			});
			
			 
			$('#subsubtotal').val($('#countid').val());
    
		}
		
			//$('#alldelivered0').attr('checked',true);
		 
			count_total();
	};
		
	$(document).on('input','[id^=qty],[id^=discount]',function () { 
			count_total();
	});
	

	$("table.order-list").on("click", ".ibtnDel", function (event) {
		   
			pointer=$(this).attr("data");
			
			$('#goods_partno'+pointer).val("");
			$('#qty'+pointer).val("");
			$('#market_price'+pointer).val("");
			$(this).closest("tr").remove();       
			 count_total();
			 $('#subsubtotal').val($('#countid').val());
	});
	
   refresh();
   findAddressAlertAjax();
   findMemIdAjax('pos');
   		
   //selectall_delivered();
 });
 </script>
 

<form action="/?pos=<?php echo $pos;?>&id=<?php echo $id;?>&page=ipadpos&subpage=index5_edit.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="1000"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99d6ff">
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td align="center" valign="top">
	<table width="100%"  border="0" cellpadding="2" cellspacing="0">
       <tr>
        <td width="13%" height="21" bgcolor="#666666"><span class="style6"><a href="/?page=invoice&subpage=invoicelist.php">更改出貨單</a><a href="javascript:backPOS('<?php echo $pos;?>');">POS</a>  </span></td>
        <td width="35%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?>[<?php echo $id;?>]</td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4">
		<table width="100%" border="1" cellpadding="2" cellspacing="0">
          <tr bgcolor="#004d80">
            <td width="80">
                <span class="style6">發票日期：</span></td>
            <td width="150"><input name="invoice_date" type="text" id="invoice_date"   size="15" maxlength="20" READONLY="READONLY"  value="<?php $ts->getDate($invoicerow['invoice_date']);?>"></td>
             <td width="79"><span class="style6">營業員 ： </span></td>
            <td width="110">
              <select name="sales" id="sales">
			  <?php
			  // 20100329 disable change staff name on invoice editing RW
				//   Fung request add bonus issue
				 //
			  if (!($AREA=="Y" && $PC=="99") && !($AREA=="Y" && $PC=="1") ){
					echo "<option value=\"".$invoicerow['sales_name']."\" ";	
					echo "selected";
					echo ">".$invoicerow['sales_name']."</option>";
			  }
			  else
			  {
				  while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
				  {
					echo "<option value=\"".$row['name']."\" ";
					if ($invoicerow['sales_name']==$row['name'])
					echo "selected";
					echo ">".$row['name']."</option>";
					}
			  }
			?>
                    
                </select><span class="style6"><?=$invoicerow['sales_name']?></span>	</td>
            
			<td colspan="3"><input name="status" type="radio" value="A" <?php if($invoicerow['settle']=="A"){echo "checked";}?>>
              <span class="style6">入帳</span>
              <input name="status" type="radio" value="S" <?php if($invoicerow['settle']=="S"){echo "checked";}?>>
              <span class="style6">掛單</span><span class="style5">&nbsp; 
			  <input id="status1" name="status" type="radio" value="D" <?php if($invoicerow['settle']=="D"){echo "checked";}?> >
			  <span class="style6">訂金</span> <br>
				 <input id="deposit_method1" name="deposit_method" type="radio" value="C" <?php if($invoicerow['deposit_method']=="C"){echo "checked";}?>>
				<span class="style6">現金入賑</span>
			  <input id="deposit_method2" name="deposit_method" type="radio" value="D" <?php if($invoicerow['deposit_method']=="D"){echo "checked";}?>>
			  <span class="style6">會員賑戶扣數</span><span class="style6">
			 
			  <br>
                <input name="delivery" type="radio" id="delivery" value="Y" <?php if ($invoicerow['delivery']=="Y"){echo "checked";}?>/>
                </span><span class="style6">送貨
                  <input name="delivery" type="radio" id="radio" value="S" <?php if ($invoicerow['delivery']=="S"){echo "checked";}?>/>
                  自取
  <input name="delivery" type="radio" id="radio2" value="C" <?php if ($invoicerow['delivery']=="C"){echo "checked";}?>/>
                  街車即走</span>&nbsp; 
				   <input name="delivery" type="radio" id="delivery1" value="W" <?php if ($invoicerow['delivery']=="W"){echo "checked";}?>/>
			     <span class="style6">等電</span> 
				  <span class="style6">分店</span>:
              
              <select name="branchID" id="branchID">
                <?
              		for ($i=0;$i<count($shop_array);$i++){
              	   ?><option value="<?=$shop_array[$i]?>" <? if($invoicerow["branchID"]==$shop_array[$i]) {echo "selected";}?>><?=$shop_array[$i]?></option>	
              	   <?
              		}
              		?>
              </select>         </td>
			</tr>
			
          <tr bgcolor="#004d80">
            <td ><span class="style6">送貨日期：</span></td>
            <td ><input name="delivery_date" type="text" id="delivery_date" tabindex="39" size="12" maxlength="20" value="<?php $ts->getDate($invoicerow['delivery_date']);?>"><input name="cal" id="calendar" value=".." type="button"></td>
           
            <td ><span class="style6">客戶編號：</span></td>
            <td colspan="1" ><input onKeyPress="next_text_box(event,'delivery_date')"  onBlur="javascript: check888();"  name="mem_id" tabindex="38" type="text" id="mem_id"  size="15" onChange="findMemIdAjax()"  value="<?php echo $invoicerow['member_id'];?>" /> </td>
			 
			<td width="237"><span class="style6">客戶名稱：
			  <input name="mem_name" type="text" id="mem_name"   value="<?php echo $invoicerow['customer_name'];?>" >
			  </span></td>
            <td width="118" ><span class="style6">會員級別</span>
              <input name="mem_credit_level" id="mem_credit_level" type="text" disabled="disabled" class="blocktextbox" size="3" maxlength="3">
		  </td>
		  <td>
		 <input name="sum_dep_amt" id="sum_dep_amt" type="hidden" disabled="disabled" class="blocktextbox" size="10" maxlength="10"> 
		 <input name="sum_inv_dep_amt" id="sum_inv_dep_amt" type="hidden" disabled="disabled" class="blocktextbox" size="10" maxlength="10"> 
		 
		  <label><span class="style6">結餘 : </label></span><input name="mem_dep_bal" id="mem_dep_bal" type="text" disabled="disabled" class="blocktextbox" size="10" maxlength="10">
		  </td>
          </tr>
		  
		   <tr bgcolor="#004d80">
					<td ><span class="style6">送貨時間：</span></td>
					
					<td colspan="1">
					<select name="delivery_timeslot" id="delivery_timeslot">
              <option value="1" <?php if ($invoicerow['delivery_timeslot']==1) {echo "selected";}?>> 早 08:00-12:00</option> 
			  <option value="2" <?php if  ($invoicerow['delivery_timeslot']==2) {echo "selected";}?>> 午 12:01-14:00</option> 
			  <option value="3" <?php if  ($invoicerow['delivery_timeslot']==3) { echo "selected";}?>> 晚 14:01-18:00</option> 
			  </select>
					 </td>
					 <td colspan="1">
					  <span class="style6">收貨人： </span></td>
					  <td colspan="1">
					  <input  name="receiver" tabindex="38" type="text" id="receiver"  size="15"  value="<?php echo $invoicerow['receiver'];?>"/>
					 </td>
					 <td colspan="3">
					    <span class="style6">姓氏： </span><input  name="lastname" tabindex="38" type="text" id="lastname"  size="15" value="<?php echo $invoicerow['lastname'];?>" />
					 </td>
             </tr>
		  
		     <tr bgcolor="#004d80">
					<td ><span class="style6">會員remark： </span></td>
					
					 
					 <td colspan="6">
					  <input  name="mem_remark"   type="text" id="mem_remark"  size="80" />
					 </td>
					  
             </tr>
			 
          <tr bgcolor="#004d80">
          <td><span class="style6">入賬日期：</span></td>
                    <td><input name="settledate" type="text" id="settledate" value="<? echo Date("Y-m-d H:i"); ?>" size="15" maxlength="20"><input name="cal2" id="calendar2" value=".." type="button"></td>
                
            <td><span class="style6">送貨地址：</span></td>
            <td colspan="3"><input onKeyPress="next_text_box(event,'mem_id')" tabindex="37" name="mem_add" type="text" id="mem_add" size="60" maxlength="255" onChange="findAddressAlertAjax()" /></td>
			<td><input type="text" id="warning" name="warning" readonly="readonly" /></td>
                </tr>
         
        </table>
		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
        
		  
		  <tr><td colspan="9"><table id="myTable" class="table order-list">
		  
		    <tr bgcolor="#004d80">
            <td width="4%"><span class="style6">行數</span></td>
            <td width="20%"><span class="style6">貨品編號</span></td>
            <td width="7%"><span class="style6">數量</span></td>
            <td width="30%"><span class="style6">項目</span></td>
            <td width="9%"><span class="style6"><span class="style6">單價</span></span></td>
            <td width="7%"><span class="style6">折扣%</span></td>
                <td width="5%" class="style6"><div align="center">行送</div></td>
            <td width="6%" class="style6"><div align="center">界板</div></td>
			 <td width="6%"><span class="style6">出貨
              <input name="delivered" type="checkbox" id="alldelivered0" onChange="javascript:selectall_delivered();"/>
            </span></td>
          </tr>
		  </table></td></tr>
        </table> 
		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#004d80">
            <tr>
              <td width="7%"><span class="style6">
                <input name="clear" type="reset" id="clear" value="清除">
              </span></td>
              <td width="10%"><span class="style6">扶力費折扣：</span></td>
              <td width="8%">
                <!--<input type="checkbox" name="special_man_power" value="Y" />-->
                <input name="special_man_power_percent" type="text" id="special_man_power_percent" value="6" size="3" maxlength="5" />
                <span class="style6"><strong>%                </strong></span></td>
              <td width="7%"><span class="style6">總折扣</span></td>
            <td width="18%"><span class="style6">
              <label>
              <input name="subdiscount" type="text" id="subdiscount" value="0" size="5" maxlength="3">
              </label>
%<strong>
<input name="subdeduct" type="text" id="subdeduct" value="0" size="7" maxlength="7">
$</strong></span></td>
              <td width="17%" class="style6">訂金
                  <input name="deposit" type="text" class="disabled" id="count" size="10" />              </td>
              <td width="17%"><span class="style6">
                <input type="button" name="Submit" value="暫計" onClick="javascript:count_total()">
                <input name="count" type="text" class="disabled" id="countid" size="10" />
              </span></td>
              <td width="8%" class="style6">信用卡
                <input type="checkbox" name="creditcard" id="creditcard"></td>
              <td width="8%"><input name="submitb" type="button" id="submitb" value="送出" onClick="checkform()"></td>
            </tr>
          </table>          </td>
      </tr>
    
    </table>     </td>
  </tr>
</table>
<?php 
//20060426
		if ($status=="A")
{
	?>	<input type="hidden" name="deposit" value="<?=$subsubtotal?>"/>
		<? }else{?>
		<input type="hidden" name="deposit" value="<?=$deposit?>"/>
<? }
$subsubtotal=($total_man_power_price+$total_price)*(100-$subdiscount)/100-$subdeduct;
 if ($creditcard=="on"){
		 			$creditcardrate=3;
		 			$creditcardtotal=round($subsubtotal*$creditcardrate/100);
					$subsubtotal=$subsubtotal+$creditcardtotal;
		 }
	?>	 
<input type="hidden" name="AREA" value="<?echo $AREA;?>" />
<input type="hidden" name="PC" value="<?echo $PC;?>" />
<input type="hidden" name="subsubtotal" value="<?=$subsubtotal?>"/>
<input type="hidden" name="pos" value="<?=$pos?>"/>


		
		<input type="hidden" name="creditcardtotal" value="<?=$creditcardtotal?>"/>
   		<input type="hidden" name="creditcardrate" value="<?=$creditcardrate?>"/>
		<input type="hidden" name="subsubtotal" id="subsubtotal" value="<?=$subsubtotal?>"/>
 
		<input type="hidden" name="man_power_price" value="<? echo $total_man_power_price;?>" />
<? 
for ($i=0;$i<$invoiceRecord;$i++)
 {?>
 
 
  <input type="hidden" name="delivered[]" id="delivered<?echo $i;?>" value="N"/>
<input type="hidden" name="manpower[]" id="manpower<?echo $i;?>" value="N"/>
<input type="hidden" name="deductStock[]" id="deductStock<?echo $i;?>" value="Y"/>
<input type="hidden" name="cutting[]" id="cutting<?echo $i;?>" value="N"/>
 
<?}?>
</form>
 
<script type="text/javascript">
 
  Calendar.setup(
    {
      inputField  : "delivery_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
    Calendar.setup(
    {
      inputField  : "settledate",         // ID of the input field
      ifFormat    : "%Y-%m-%d %H:%M",    // the date format
      showsTime      :    true,
      button      : "calendar2"       // ID of the button
      
    }
  );
  
 
</script> 