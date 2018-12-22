function SearchStaff(){
	///var abc;
	//abc=document.form1.partno[0].value;
	//alert(abc);
	window.open('/invoice/page_search_staff.php?recid=3',"Search Sfaff","left=400,screenY=300,width=530,height=360,scrollbars=yes");
}
function AddrWindow(toccbcc){
	///var abc;
	//abc=document.form1.partno[0].value;
	//alert(abc);
	//window.open('page_search_partno.php?recid=' + toccbcc,"Searh GoodsID","left=400,screenY=300,width=530,height=360,scrollbars=yes");
	popUp("/?page=invoice&subpage=page_search_partno.php&recid=" + toccbcc,700,500);
}
function detectKeyBoard(evt){
	
        if(document.all)evt = event;
        var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
        var obj = document.getElementById('debug');
        // obj.innerHTML = charCode; // For testing purpose only -> get current charcode
		if(evt.ctrlKey){
            if(charCode==38) count_total();
			 if(charCode==39) checkform();
            if(charCode==37) back(-1);
        }
}    
function check888(){
	
	   if (document.getElementById('mem_id').value=='888')
	   {
		   
		  // document.getElementById('status1').checked=true;
		   document.getElementById('delivery2').checked=true;

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

function findAddressAlertAjax() {
	 
	mem_add = document.getElementById("mem_add").value;
	
	if (mem_add == '') {
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
 
		xmlhttp.onreadystatechange=addressStateChanged;
		xmlhttp.open("GET","/invoice/addressxml.php?mem_add=" + mem_add,false);
		xmlhttp.send(null);
		
		 
	}
} 

function popUp(URL,w,h) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width="+ w +",height="+h+"');");
}

function addressStateChanged() {
	  
	if (xmlhttp.readyState==4) {
	 
		xmlDoc=xmlhttp.responseXML;
		
		element = xmlDoc.getElementsByTagName("address_mem_add")[0];
		//imgElem = document.getElementById("productCheckImg" + index);
		if (element == null) {
			//imgElem.src = "./images/wrong.png";
			//imgElem.style.display = 'inline';
			//document.getElementById("real_stock" + index).value = '0';
			return;
		}
		else {
			//imgElem.style.display = 'none';
		}
	
	 
		document.getElementById("mem_add").value = xmlDoc.getElementsByTagName("address_mem_add")[0].childNodes[0].nodeValue;
		

		node = xmlDoc.getElementsByTagName("address_alert")[0].childNodes[0]
		if (node != null)	document.getElementById("warning").value = node.nodeValue;



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

function memStateChanged() {
		 
	if (xmlhttp.readyState==4) {
		xmlDoc=xmlhttp.responseXML;
		
		element = xmlDoc.getElementsByTagName("mem_id")[0];
		//imgElem = document.getElementById("productCheckImg" + index);
		if (element == null) {
			//imgElem.src = "./images/wrong.png";
			//imgElem.style.display = 'inline';
			//document.getElementById("real_stock" + index).value = '0';
			return;
		}
		else {
			//imgElem.style.display = 'none';
		}
 
	 
		document.getElementById("mem_id").value = xmlDoc.getElementsByTagName("mem_id")[0].childNodes[0].nodeValue;
		
		node = xmlDoc.getElementsByTagName("mem_name")[0].childNodes[0]
		if (node != null) document.getElementById("mem_name").value = node.nodeValue;
		

		node = xmlDoc.getElementsByTagName("mem_credit_level")[0].childNodes[0]
		if (node != null)	document.getElementById("mem_credit_level").value = node.nodeValue;

		node = xmlDoc.getElementsByTagName("mem_alert")[0].childNodes[0]
		if (node != null)	document.getElementById("warning").value = node.nodeValue;

		
		node = xmlDoc.getElementsByTagName("mem_dep_bal")[0].childNodes[0]
		if (node != null)	document.getElementById("mem_dep_bal").value = node.nodeValue;
		
		node = xmlDoc.getElementsByTagName("mem_add")[0].childNodes[0]
		
		if (node != null)	
			if( $('#mem_add').val()=='' ) {
				document.getElementById("mem_add").value = node.nodeValue;
			}
		
		 	node = xmlDoc.getElementsByTagName("sum_dep_amt")[0].childNodes[0]
		if (node != null)	document.getElementById("sum_dep_amt").value = node.nodeValue;
		
		 	node = xmlDoc.getElementsByTagName("sum_inv_dep_amt")[0].childNodes[0]
		if (node != null)	document.getElementById("sum_inv_dep_amt").value = node.nodeValue;
		
			node = xmlDoc.getElementsByTagName("mem_remark")[0].childNodes[0]
		if (node != null)	document.getElementById("mem_remark").value = node.nodeValue;
		


	}
}

 function findMemIdAjax($pos) {

	mem_id = document.getElementById("mem_id").value;
	
	if (mem_id == '') {
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

		xmlhttp.onreadystatechange=memStateChanged;
		if ($pos=='pos')
		xmlhttp.open("GET","/pos/memberxml.php?mem_id=" + mem_id,true);
		else
		xmlhttp.open("GET","/invoice/memberxml.php?mem_id=" + mem_id,true);
		xmlhttp.send(null);
		
		 
	}
} 


function stateChanged() {
 
	if (xmlhttp.readyState==4) {
	 
		xmlDoc=xmlhttp.responseXML;
		
		element = xmlDoc.getElementsByTagName("product_goods_partno")[0];
		//imgElem = document.getElementById("productCheckImg" + index);
		if (element == null) {
			//imgElem.src = "./images/wrong.png";
			//imgElem.style.display = 'inline';
			//document.getElementById("real_stock" + index).value = '0';
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
		
		if (node.nodeValue =='N') 
		document.getElementById("market_price" + index).readOnly=false;
		else
		document.getElementById("market_price" + index).readOnly=true;
		
		
		//add stock bal 20151204
		node = xmlDoc.getElementsByTagName("product_stock_bal")[0].childNodes[0]
		if (node != null) 
			$("#stockbal_" + index).html(node.nodeValue)	
		 
			
// 20101223 adviced by WanChai Yan
	//	document.getElementById("qty" + index).value = "1";
	}
}