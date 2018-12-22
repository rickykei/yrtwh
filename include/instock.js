 $(function() {
    
	$("#goods_partno0").focus();

  
	//place event
	$('select').focus(function () {
        
			var aa=$(this).attr('id');
			var bb=aa.replace('place','');
			console.log(aa);
			var cc=$('#goods_partno'+bb).val();
			console.log(cc);
			
           var url = "/outstock/get_place_response.php?goods_partno="+$('#goods_partno'+bb).val();
			 //var url = "/outstock/lang.json";

            $.getJSON(url, function (data) {
				$('#place'+bb).html('');
				console.log(data);
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#'+aa).append('<option value="' + value.ID + '">' + value.Name + '</option>');
                });
            });
	});
   
});

function checkQtyPerBox(i){
	console.log(i);
	var partno=encodeURIComponent($('#goods_partno'+i).val());
	var box=encodeURIComponent($('#box'+i).val());
	var place=$('#place'+i).val();
	console.log('partno='+partno);
	 
	
	var getBoxQty = $.post( "/instock/get_qty_per_box_response.php",{goods_partno: partno,box:box}, function(data) {
		console.log(partno );
		console.log( "success" );
	}).done(function(data) {
		//set box textbox value
		$('#qty'+i).val(data.data.qty_per_unit);
		$('#goods_detail'+i).val(data.data.goods_detail);
		console.log("JSON RESPONSE="+data.data.qty_per_unit );
		 
		console.log("JSON RESPONSE="+data.data.goods_detail );
	  })
	  .fail(function(jqxhr, textStatus, error) {
		var err = textStatus + ", " + error;
		console.log( "Request Failed: " + err );
	  })
	  .always(function() {
		console.log( "complete" );
	  });
}   
  
  
function detectKeyBoard(evt){
	
        if(document.all)evt = event;
        var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
        var obj = document.getElementById('debug');
        // obj.innerHTML = charCode; // For testing purpose only -> get current charcode
		if(evt.ctrlKey){
            if(charCode==38) count_total();
            
        }
}    
 
 
function first_text_box_focus()
{
	 
	document.getElementById('goods_partno0').focus();
	 
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
	///var abc;
	//abc=document.form1.partno[0].value;
	//alert(abc);
	//window.open('page_search_partno.php?recid=' + toccbcc,"Searh GoodsID","left=400,screenY=300,width=530,height=360,scrollbars=yes");
	popUp("/?page=instock&subpage=page_search_partno.php&recid=" + toccbcc,700,500);
}
function SearchStaff(){
	///var abc;
	//abc=document.form1.partno[0].value;
	//alert(abc);
	window.open('page_search_staff.php?recid=3',"Search Sfaff","left=400,screenY=300,width=530,height=360,scrollbars=yes");
}
function checkform()
{
	if (document.form1.goods_partno0.value=="")
	{
		alert('最少一件貨');
		document.form1.goods_partno0.focus();
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
