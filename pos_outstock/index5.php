<?php
	$invoiceRecord=16;
	require_once("./include/config.php");
	require_once("./include/functions.php");
	
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
       
?><META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
 
<? // = $ajax->loadJsCore(true) ?>
<style type="text/css">
@import url(./include/cal/calendar-win2k-1.css);
</style>
<script type="text/javascript" src="./include/cal/calendar.js"></script>
<script type="text/javascript" src="./include/cal/lang/calendar-en.js"></script>
<script type="text/javascript" src="./include/cal/calendar-setup.js"></script>
<script type="text/javascript" src="./include/functions.js"></script>
<script type="text/javascript" src="./include/outstock.js"></script>
<link href="./include/outstock.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="./js/js.storage.min.js"></script> 
<script type="text/javascript">
 
  var pos='<?php echo $pos;?>';
  
 	  function backPOS(){
		  
			var item=[];
			var i=0;
			var items =[];
			
					 
			for(i=0;i<16;i++) {
			 
				 if ($('#goods_partno'+i).val()!="" && $('#goods_partno'+i).val()!=null){
					item[0] = $('#box'+i).val();
					item[1] = $('#goods_partno'+i).val();
					item[2] = $('#rest_qty'+i).val();
					item[3] = $('#rest_box'+i).val();
					item[4] = $('#place'+i).val();
					item[5] = $('#qty_per_unit'+i).val();
					item[6] = $('#weight'+i).val();
					item[7] = $('#goods_detail'+i).val();
					
					items.push(item);
					 localStorage.setItem(pos+'_myItems',JSON.stringify(items));
					 item=[];
				 }
			}
				 
			 window.location.href="/?page=pos_outstock&subpage=index.php&pos=<?php echo $pos;?>";
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
			  
			  //$('#qty'+index).val(data[0]);
			  //$('#goods_detail'+index).val(data[2]);
			  ///$('#market_price'+index).val(data[3]);
			  //$('#goods_partno'+index).focus();
			 // findPartNoAjax(index);
		 	 
				var newRow = $("<tr>");
				var cols = "";
 
					cols += '<td><div align="center"><span class="style7">'+(counter+1)+'</span></div></td></td>';
					cols += '<td><input name="goods_partno[]" type="text" id="goods_partno'+counter+'"   readonly="readonly" value="'+data[1]+'"/></td>';
					cols += '<td><select name="place[]" id="place'+counter+'" ><option value="'+data[4]+'">'+data[4]+'</option> </select></td>';
					cols += '<td><input name="box[]" type="text" id="box'+counter+'"  size="35" value="'+data[0]+'" readonly="readyonly"></td>';
					cols += '<td> <input name="qty[]" type="text" id="qty'+counter+'"  value="'+data[0]*data[5]+'"  /></td>';
					cols += '<td> <input name="goods_detail[]" type="text" id="goods_detail'+counter+'"  value="'+data[7]+'"   /></td>';
					cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger " data="'+counter+'" value="Delete"></td>';
					cols += '<input type="hidden" name="rest_qty[]" id="rest_qty'+counter+'" value="'+data[2]+'">';
					cols += '<input type="hidden" name="rest_box[]" id="rest_box'+counter+'" value="'+data[3]+'">';
					cols += '<input type="hidden" name="qty_per_unit[]" id="qty_per_unit'+counter+'" value="'+data[5]+'">';
					cols += '<input type="hidden" name="weight[]" id="weight'+counter+'" value="'+data[6]+'">';
			 
				total_price=total_price+parseFloat(data[3])*parseFloat(data[0]);
				
			
				newRow.append(cols);
				$("table.order-list").append(newRow);
				counter++;
			});
			
			 
			$('#subsubtotal').val($('#countid').val());
    
		}
		
			$('#alldelivered0').attr('checked',true);
		 
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
		
   selectall_delivered();
 });
 </script>
 

<form action="/?page=pos_outstock&subpage=index6.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
<table width="1000"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99CCCC">
  <tr>
    <td width="4" height="360">&nbsp;</td>
    <td align="center" valign="top"><table width="100%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#006666"><span class="style6"><a href="../">提貨單</a> <a href="javascript:backPOS()">POS</a></span></td>
        <td width="34%"><span class="style7"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></span></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="1" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006666">
            <td width="80">
                <span class="style6">提貨單日期</span></td>
            <td width="150">
			<input name="outstock_date" type="text" id="outstock_date" value="<? echo Date("Y-m-d H:i"); ?>" size="15" maxlength="20" readonly="readonly">
			<input name="cal" id="calendar" value=".." type="button">
			</td>
             <td width="79"><span class="style6">職員 ： </span></td>
            <td width="110">
              <select name="sales" id="sales">
              <option value="" > </option>
			  <?php while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
			  {
                echo "<option value=\"".$row['name'];
                echo "\"";
                if ($USER==$row['name'])
           			echo " selected";
                echo ">".$row['name']."</option>";
				}?>
                </select>			</td>
            
			 
			</tr>
			 <tr bgcolor="#006666" >
            <td width="20%" height="21">
                <span class="style6"> 軍地倉去：</span></td>
            <td width="28%" > 
			<select name="to_shop" id="to_shop">
<option value="自提">自提</option>
            <option value="Y鋪">Y鋪</option>  
			<option value="元朗倉">元朗倉</option>  
            </select></td>
            <td width="17%" ><span class="style6">運送方法 : </span></td>
            <td width="35%" ><select name="delivery_method" id="delivery_method">
              <option value="大車">大車</option>  
			<option value="24吊">24吊</option>  
            </select></td>
          </tr>
          
		  
		   
		   
          
         
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#FFFFFF">
        
		  
		  <tr><td colspan="9"><table id="myTable" class="table order-list">
		  
		    <tr bgcolor="#006666">
             <td width="6%"><span class="style6">行數</span></td>
            <td width="20%"><span class="style6">貨品編號</span></td>
			<td width="10%"><span class="style6">儲放位置</span></td>
            <td width="7%"><span class="style6">箱數量</span></td>
			<td width="7%"><span class="style6">裝數量</span></td>
            <td width="30%"><span class="style6">貨品描述</span></td>
			<td width="30%"><span class="style6">Action</span></td>
          </tr>
		  </table></td></tr>
        </table> 
		</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="" colspan="4">
          <table width="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="#006666">
            <tr>
              <td width="" colspan="6"><span class="style6">
                <input name="clear" type="reset" id="clear" value="清除">
              </span></td>
               
          
           
             
              
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
      inputField  : "outstock_date",         // ID of the input field
      ifFormat    : "%Y-%m-%d",    // the date format
      showsTime      :    true,
      button      : "calendar"       // ID of the button
      
    }
  );
   
  
 
</script> 