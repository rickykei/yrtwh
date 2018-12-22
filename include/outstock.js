$(function() {
    
	$("#goods_partno0").focus();

  
	//place event
	$('select').focus(function () {
        
			var aa=$(this).attr('id');
			var bb=aa.replace('place','');
			console.log(aa);
			var cc=$('#goods_partno'+bb).val();
			console.log(cc);
			var partno=encodeURIComponent(cc);
           var url = "/outstock/get_place_response.php";
			 //var url = "/outstock/lang.json";

            $.post(url,{goods_partno: partno},function (data) {
				$('#place'+bb).html('');
				console.log(data);
                $.each(data, function (index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    $('#'+aa).append('<option value="' + value.ID + '">' + value.Name + '</option>');
                });
            });
	});
   
});

function checkInputQty(i){
	var box=$('#box'+i).val();
	var qty_per_unit=$('#qty_per_unit'+i).val();
	var weight_per_unit=$('#weight_per_unit'+i).val();
	console.log('box='+box);
	console.log('qty_per_unit='+qty_per_unit);
	console.log('weight_per_unit='+weight_per_unit);
	//box=box*qty_per_unit;
	totalweight=box*weight_per_unit*qty_per_unit;
	$('#qty'+i).val(box*qty_per_unit);
	$('#weight_per_row'+i).val(totalweight);
	console.log('weight_per_row='+$('#weight_per_row'+i).val());
	var totalweight=0;
	var weight=0;
	for(i=0; i < 17; i++) 
    { 
		weight=parseFloat($('#weight_per_row'+i).val());
        totalweight+=parseFloat(weight.toFixed(2));
		console.log('loop row weight='+$('#goods_partno'+i).val()+' '+totalweight);
    } 
	console.log('totalweight='+totalweight);
    $('#total_weight').val(totalweight);
}

function checkStock(i){
	console.log(i);
	var partno=encodeURIComponent($('#goods_partno'+i).val());
	var place=$('#place'+i).val();
	console.log('partno='+partno);
	console.log('place='+$('#place'+i).val());
	var getBoxQty = $.post( "/outstock/get_box_qty_response.php",{goods_partno: partno,place:place}, function() {
			console.log(partno );
			console.log( "success" );
	}).done(function(data) {
		//set box textbox value
		$('#box'+i).val(data.data.box);
		$('#qty'+i).val(data.data.qty);
		$('#goods_detail'+i).val(data.data.goods_detail);
		$('#qty_per_unit'+i).val(data.data.qty_per_unit);
		$('#weight_per_unit'+i).val(data.data.weight_per_unit);
		console.log("JSON RESPONSE="+data.data.qty );
		console.log("JSON RESPONSE="+data.data.box );
		console.log("JSON RESPONSE="+data.data.goods_detail );
		console.log("JSON RESPONSE="+$('#qty_per_unit'+i).val());
		console.log("JSON RESPONSE="+$('#weight_per_unit'+i).val());
	  })
	  .fail(function(jqxhr, textStatus, error) {
		var err = textStatus + ", " + error;
		console.log( "Request Failed: " + err );
	  })
	  .always(function() {
		console.log( "complete" );
	  });
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
