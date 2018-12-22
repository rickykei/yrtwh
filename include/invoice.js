//20170907 1957 

var totalinvoiceRecord=16;
 
function count_total()
{ 
	
	var total=0.00;
	//cal basic total
	for(i=0;i<totalinvoiceRecord;i++)
	{
		
		if($("#market_price"+i).length)
			total=total+((document.getElementById('market_price'+i).value*document.getElementById('qty'+i).value*(100-document.getElementById('discount'+i).value))/100);
	 
	}
	 
	//find manpower total 找出苦力的total
	var manpower=0.00;
	var z=0;
	
	//----disable manpower
	//for(i=0;i<totalinvoiceRecord;i++)
	//{
		//if (document.getElementById('manpowerX'+i).checked==true)
		//{
		//z=1;
		//manpower=manpower+(document.getElementById('market_price'+i).value*document.getElementById('qty'+i).value);
		//}
	//}
	//count manpower total logic
	var totalmanpower=0.00;
	if (z==1){
	if (manpower>=2500)	{	
//	totalmanpower=manpower*0.06;20060625	
	totalmanpower=manpower*document.getElementById('special_man_power_percent').value/100;	
	}
	else	{	
		totalmanpower=2500*document.getElementById('special_man_power_percent').value/100;	

		
		}
		if (totalmanpower<150)
		totalmanpower=150;
		
		}
	
	//count specialmanpower total logic
	var totalspecialmanpower=0;
 
	var subtotal=0;
	subtotal=total+totalmanpower+totalspecialmanpower;
 
	var subsubtotal=0;
	subsubtotal=(subtotal*((100-document.getElementById('subdiscount').value)/100))-document.getElementById('subdeduct').value;
	//subtotal - final discount - deuct
	
	//20181320 CreditCard Charge
	if (document.getElementById('creditcard').checked==true){
		subsubtotal=subsubtotal+Math.round(subsubtotal*3/100);
	}
	
 
	 $('#subsubtotal').val($('#countid').val());
	 
	document.getElementById('countid').value=subsubtotal.toFixed(2);
	//document.getElementById('mem_add').focus();
}
	
function first_text_box_focus()
{
	//document.getElementById('goods_id0');
	document.getElementById('goods_partno0').focus();
	
	//<label></label>document.getElementById('goods_id0').focus();
}
function clickCheckBox(a)
{
	// $i 0-17
	if (document.getElementById('manpowerX'+a).checked)
	{
		document.getElementById('manpower'+a).value='Y';
	}
	else
	{
		document.getElementById('manpower'+a).value='N';
	}
	
}

function clickCheckBoxDelivered(a)
{
	// $i 0-17
	if (document.getElementById('deliveredX'+a).checked)
	{
		document.getElementById('delivered'+a).value='Y';
	}
	else
	{
		document.getElementById('delivered'+a).value='N';
	}
	
}
function clickCheckBoxDeductStock(a)
{
	// $i 0-17
	if (document.getElementById('deductStockX'+a).checked)
	{
		document.getElementById('deductStock'+a).value='N';
	}
	else
	{
		document.getElementById('deductStock'+a).value='Y';
	}
	
}
function clickCheckBoxCutting(a)
{
	// $i 0-17
	if (document.getElementById('cuttingX'+a).checked)
	{
		document.getElementById('cutting'+a).value='Y';
	}
	else
	{
		document.getElementById('cutting'+a).value='N';
	}
	
}
function selectall()
{

	if (document.getElementById('allmanpower0').checked)
	{
		for (i=0;i<totalinvoiceRecord;i++)
		{
		document.getElementById('manpowerX'+i).checked=true;
		document.getElementById('manpower'+i).value='Y';
		}
	}
	else
	{
		for (i=0;i<totalinvoiceRecord;i++)
		{
		document.getElementById('manpowerX'+i).checked=false;
		document.getElementById('manpower'+i).value='Y';
		}
	}
}
function selectall_delivered()
{

	if (document.getElementById('alldelivered0').checked)
	{
		for (i=0;i<totalinvoiceRecord;i++)
		{
		document.getElementById('deliveredX'+i).checked=true;
		document.getElementById('delivered'+i).value='Y';
		}
	}
	else
	{
		for (i=0;i<totalinvoiceRecord;i++)
		{
		document.getElementById('deliveredX'+i).checked=false;
		document.getElementById('delivered'+i).value='Y';
		}
	}
}





function checkform()
{
	
	if (document.form1.mem_name.value=="")
	{
		alert('請輸入客戶名稱');
		document.form1.mem_name.focus();
	}
	else if($('#goods_partno0').val()=="")
	{
		alert('請輸入貨品');
		document.form1.mem_name.focus();
	}
	else
	{
		
	count_total();
		
		if ($("#deposit_method2").attr('checked')){
				
				 //alert($('#mem_dep_bal').val());
				 //alert($('#countid').val());
			if (parseInt($('#mem_dep_bal').val())<parseInt($('#countid').val()))
				alert('會員存款不足');
			else
				document.form1.submit();
		}else{
 		document.form1.submit();
		}
		
	}
}

  
 function findPartNoAjax(goods_row, stockFlag) {
	index = goods_row;
	goods_partno = document.getElementById("goods_partno" + index).value;
	
	if (goods_partno == '') {
	//	document.getElementById("productCheckImg" + index).style.display = 'none';
	//	clearProductField(index);
	//	calSubTotal();
	}
	else {
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null) {
			alert ("Browser does not support HTTP Request");
			return;
		}
		
		//document.getElementById("real_stock" + index).value = 'Retrieving ...';

		xmlhttp.onreadystatechange=stateChanged;
		xmlhttp.open("GET","/invoice/productxml.php?goods_partno=" + goods_partno,false);
		xmlhttp.send(null);
 
	}
} 
 








 
