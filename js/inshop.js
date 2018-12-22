 
function detectKeyBoard(evt){
	
        if(document.all)evt = event;
        var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
        var obj = document.getElementById('debug');
        // obj.innerHTML = charCode; // For testing purpose only -> get current charcode
		if(evt.ctrlKey){
            if(charCode==38) count_total();
            
        }
}    
function countSubTotal(i)
{
	var temp=0;
	temp=document.getElementById('market_price'+i).value*document.getElementById('qty'+i).value;
	document.getElementById('subtotal'+i).value=temp-(temp/100)*document.getElementById('discount'+i).value;;
}
function count_total()
{
	 
	var total=0.00;
	var totaltotal=0.00;
	//cal basic total
	for (i=0;i<18;i++)
	{
			
		total=total+parseFloat(document.getElementById('subtotal'+i).value);
	}
	document.getElementById('count_price').value=total;
	document.getElementById('total_price').value=total-(total/100)*document.getElementById('sub_discount').value;;
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
		for (i=0;i<18;i++)
		{
		document.getElementById('manpowerX'+i).checked=true;
		document.getElementById('manpower'+i).value='Y';
		}
	}
	else
	{
		for (i=0;i<18;i++)
		{
		document.getElementById('manpowerX'+i).checked=false;
		document.getElementById('manpower'+i).value='Y';
		}
	}
}


function next_text_box(evt,box)
{
  var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));

	if (charCode==13)
	{
	document.getElementById(box).focus();
	//alert(event.keyCode);
	return false;
	}

}

function popUp(URL,w,h) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width="+ w +",height="+h+"');");
}

function AddrWindow(toccbcc){
	//var abc;
	//abc=document.form1.partno[0].value;
	//alert(abc);
	//window.open('page_search_partno.php?recid=' + toccbcc,"Searh GoodsID","left=400,screenY=300,width=530,height=360,scrollbars=yes");
	popUp("/?page=inshop&subpage=page_search_partno.php&recid=" + toccbcc,700,500);
}
function SearchStaff(){
	///var abc;
	//abc=document.form1.partno[0].value;
	//alert(abc);
	window.open('/?page=inshop&subpage=page_search_staff.php&recid=3',"Search Sfaff","left=400,screenY=300,width=530,height=360,scrollbars=yes");
}
function checkform()
{
	if (document.form1.supplier_invoice_no.value=="")
	{
		alert('供應商發票編號');
		document.form1.supplier_invoice_no.focus();
	}
	else
	{
	
		document.form1.submit();
		
	}
}
function DisplayKey(e) {
   if (e.keyCode) keycode=e.keyCode;
     else keycode=e.which;
   character=String.fromCharCode(keycode);
   window.status += character;
  }

  function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}

function findPartNoAjax(goods_row, stockFlag) {
	 
	index = goods_row;
	goods_partno = document.getElementById("goods_partno" + index).value;
	 
	if (goods_partno == '') {
 
	} else {
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null) {
			alert ("Browser does not support HTTP Request");
			return;
		}
		
		//document.getElementById("real_stock" + index).value = 'Retrieving ...';

		xmlhttp.onreadystatechange=stateChanged;
		xmlhttp.open("GET","/invoice/productxml.php?goods_partno=" + goods_partno,false);
		xmlhttp.send(null);
		count_total();
	}
} 
 
 function stateChanged() {
 
	if (xmlhttp.readyState==4) {
	 
		xmlDoc=xmlhttp.responseXML;
		
		element = xmlDoc.getElementsByTagName("product_goods_partno")[0];
		 
		if (element == null) {
 			return;
		}
		else {
			//imgElem.style.display = 'none';
		}
 
		document.getElementById("goods_partno" + index).value = xmlDoc.getElementsByTagName("product_goods_partno")[0].childNodes[0].nodeValue;
		
		node = xmlDoc.getElementsByTagName("product_goods_detail")[0].childNodes[0]
		if (node != null) document.getElementById("goods_detail" + index).value = node.nodeValue;
		

		node = xmlDoc.getElementsByTagName("product_market_price")[0].childNodes[0]
		if (node != null)	document.getElementById("market_price" + index).value = node.nodeValue;

		//check readonly
		node = xmlDoc.getElementsByTagName("product_readonly")[0].childNodes[0]
		
		//20180508 alvin recommend to change to false
		if (node.nodeValue =='N') 
		document.getElementById("market_price" + index).readOnly=false;
		else
		document.getElementById("market_price" + index).readOnly=false;
		
		 if ($('#market_price' + index).val()!='' && $('#qty' + index).val()!=''){
			 //alert($('#market_price' + index).val());
			 $('#subtotal'+index).val(parseInt($('#market_price' + index).val())*parseInt($('#qty' + index).val()));
		 }
		
		//add stock bal 20151204
		node = xmlDoc.getElementsByTagName("product_stock_bal")[0].childNodes[0]
		if (node != null) 
			$("#stockbal_" + index).html(node.nodeValue)	
		 
	}
}