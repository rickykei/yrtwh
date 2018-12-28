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
  $ts = new TIMESTAMP;
	   
   // (Run the query on the winestore through the connection
   $result = $connection->query("SET NAMES 'UTF8'");
   if (DB::isError($result)) die ($result->getMessage());
	  $sql="SELECT * FROM staff";
	 $staffResult = $connection->query($sql);
	 
	 
	 $id=$_REQUEST['id'];
	//load invoice_header
	$sql="Select * from outstock where outstock_no = ".$outstock_no;
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
				 
			 window.location.href="/?page=pos_outstock&subpage=index_edit.php&pos=<?php echo $pos;?>";
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
					cols += '<td><select name="place[]" id="place'+counter+'" ><option value="'+data[5]+'">'+data[5]+'</option> </select></td>';
					cols += '<td><input name="box[]" type="text" id="box'+counter+'"  size="35" value="'+data[3]+'" readonly="readyonly"></td>';
					cols += '<td> <input name="qty[]" type="text" id="qty'+counter+'"  value="'+data[4]+'"  /></td>';
					cols += '<td> <input name="goods_detail[]" type="text" id="goods_detail'+counter+'"  value="'+data[2]+'"   /></td>';
					cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger " data="'+counter+'" value="Delete"></td>';
					cols += '<input type="hidden" name="rest_qty[]" id="rest_qty'+counter+'" value="'+data[2]+'">';
					cols += '<input type="hidden" name="rest_box[]" id="rest_box'+counter+'" value="'+data[3]+'">';
					cols += '<input type="hidden" name="qty_per_unit[]" id="qty_per_unit'+counter+'" value="'+data[6]+'">';
					cols += '<input type="hidden" name="weight[]" id="weight'+counter+'" value="'+data[7]+'">';
			 
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
 

<form action="/?page=pos_outstock&subpage=index6_edit.php" method="POST" enctype="application/x-www-form-urlencoded" name="form1">
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
            <td height="21"><label><span class="style6">提倉單編號 :</span> </label></td>
            <td colspan="2"><label><span class="style6"><?php echo $outstock_no; ?></span><input type="hidden" name="outstock_no" value="<?php echo $outstock_no; ?>"> </label></td>
            <td width="29%">&nbsp;</td>
          </tr>
          <tr bgcolor="#006666">
            <td width="80">
                <span class="style6">提貨單日期</span></td>
            <td width="150">
			<input name="outstock_date" type="text" id="outstock_date" value=<?php $ts->getDate($invoicerow['outstock_date']);?>" size="15" maxlength="20" readonly="readonly">
			<input name="cal" id="calendar" value=".." type="button">
			</td>
             <td width="79"><span class="style6">職員 ： </span></td>
            <td width="110">
              <select name="sales" id="sales">
              <?php
			  // 20100329 disable change staff name on invoice editing RW
				//   Fung request add bonus issue
				 //
			  if (!($AREA=="Y" && $PC=="99") && !($AREA=="Y" && $PC=="1") ){
					echo "<option value=\"".$invoicerow['staff_name']."\" ";	
					echo "selected";
					echo ">".$invoicerow['staff_name']."</option>";
			  }
			  else
			  {
				  while ($row = $staffResult->fetchRow(DB_FETCHMODE_ASSOC))
				  {
					echo "<option value=\"".$row['name']."\" ";
					if ($invoicerow['staff_name']==$row['name'])
					echo "selected";
					echo ">".$row['name']."</option>";
					}
			  }
			?>
                </select>			</td>
            
			 
			</tr>
			 <tr bgcolor="#006666" >
            <td width="20%" height="21">
                <span class="style6"> 軍地倉去：</span></td>
            <td width="28%" > 
			<select name="to_shop" id="to_shop">
<option value="自提" <?php if ($invoicerow['to_shop']=='自提' ){echo 'selected';}?>>自提</option>
            <option value="Y鋪"  <?php if ($invoicerow['to_shop']=='Y鋪' ){echo 'selected';}?>>Y鋪</option>  
			<option value="元朗倉"  <?php if ($invoicerow['to_shop']=='元朗倉' ){echo 'selected';}?>>元朗倉</option>  
            </select></td>
            <td width="17%" ><span class="style6">運送方法 : </span></td>
            <td width="35%" ><select name="delivery_method" id="delivery_method">
              <option value="大車" <?php if ($invoicerow['delivery_method']=='大車' ){echo 'selected';}?>>大車</option>  
			<option value="24吊" <?php if ($invoicerow['delivery_method']=='24吊' ){echo 'selected';}?>>24吊</option>  
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
               
          
           <input type="hidden" name="update" value="3" /><input type="hidden" name="AREA" value="<?echo $AREA;?>" /><input type="hidden" name="PC" value="<?echo $PC;?>" />
             
              <input type="hidden" name="pos" value="<?=$pos?>"/>

              <td width="8%"><input name="submitb" type="button" id="submitb" value="送出" onClick="checkform()"><input type="hidden" name="outstock_no" value="<?echo $outstock_no;?>" >
        </td>
            </tr>
          </table>          </td>
      </tr>
    
    </table>     </td>
  </tr>
</table>
 
 

 
 
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