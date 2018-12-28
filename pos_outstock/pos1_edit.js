 
ls=Storages.localStorage;
var pos='pos1_edit';


	  $(function () { 
		refresh(); 
	  });
	
	 function refresh() {
		var total=0;
		var items = localStorage.getItem(pos+'_myOutstock'); 
		var ul = $('#rightlist');
		ul.html('');
		if (items != null) {
			items = JSON.parse(items);
			$(items).each(function (index, data) {
				ul.append('<tr><td colspan="1">單號 : </td><td colspan="4">'+ data[0]+'</td></tr>');
		 
			 
			});
		}
	 
		
		items = localStorage.getItem(pos+'_myItems');
			var ul = $('#rightlist');
		if (items != null) {
			items = JSON.parse(items);
			$(items).each(function (index, data) {
				var tmp=index+1;
				total=total+(parseFloat(data[4])*parseFloat(data[7]));
				console.log('totalprice='+total);
		
			ul.append('<tr><td>['+tmp+']</td><td>' + data[1] +' </td><td><a class="chgQty" data="'+index+'" dataDesc="'+data[2]+'" >'+ data[3] +'  箱</a></td><td><a class="chgQty" data="'+index+'" dataDesc="'+data[2]+'" >'+ data[4] +'件</a></td><td>'+data[5]+' </td><td><a class="remove" data="'+index+'">X</a></td></tr>');
			});
		 	ul.append('<tr><td>總重:</td><td colspan=3> '+total+'</td></tr>');
		}
		
		
		
		var ino = localStorage.getItem('outstockno');
		 
		 var inoed=$('#ino_ed');
		 var inoh=$('#ino');
		 
		   
		  
		
	
	}
	
	

	
   $(document).on('click', '#cleanall', function(){
	ls=Storages.localStorage;
	ls.remove(pos+'_myItems');
 
	ls.remove('outstockno');
	inoh.show();
	 refresh(); 
	});
  
  
    $(document).on('click', '.chgQty', function(){
		var id=$(this).attr("data");
		 $('#desc') .val('tempdesc');
		$('#action').val(id);
	 	$('#out_box').click();
		
	});
  
    $(document).on('click', '.remove', function(){
	  var del_id=$(this).attr("data");
	  	 var item=[];
			 var items = localStorage.getItem(pos+'_myItems');
			if (items != null) {
			items = JSON.parse(items);
			} else {
			items = new Array();
			}
			items.splice(del_id,1);
			localStorage.setItem(pos+'_myItems',
			JSON.stringify(items));
			refresh();
	});
	
	 $( function() {
		 
		 

		 
		$("#backlink").click(function(event) {
			event.preventDefault();
			history.back(1);
		});
		
		$("#nextlink").click(function(event) {
		 	event.preventDefault();
			history.go(1);
		});
	
		$('#model a[href], #modelmenu a[href]').click(function(){
		//alert($(this).text());
			ls.set('selected_model1',$(this).text());
		//alert(ls.get('selected_model1'));
		});
		
			$('#model2 a[href]').click(function(){
		//alert($(this).text());
		ls.set('selected_model2',$(this).text());
		//alert(ls.get('selected_model2'));
	});
 
		
		$('#quickinput').keypress(function (e) {
			if (e.which == 13) {
				  quickinput();
				return false;     
			}
		});
		
		$("#quickinput").autocomplete({
			minLength: 1,
		    source: "./pos_outstock/search_partno.php",
			focus: function (event, ui) {
				$("#quickinput").val(ui.item.value);
				return false;
			},
			select: function (event, ui) {
				$("#quickinput").val(ui.item.value);
               return false;
			}
		}).data("ui-autocomplete")._renderItem = function (ul, item) {
			return $("<li></li>")
            .data("item.autocomplete", item)
            .append("<a>" + item.label + " ($" + item.desc + ")</a>")
            .appendTo(ul);
		};
		
		//quick input click
		$('.quickinput').click(function(){
			  quickinput();
			
		});
		 
		
	  });
	  
	 
	  
	  function quickinput(){
		  $('#partno').val($('#quickinput').val());
			findPartNo($('#partno').val());
		 	$('#out_box').click();
	  }
	   
	 function storeItem() {
		 
		 
				var item=[];
				var items = localStorage.getItem(pos+'_myItems');
				var id=0;
				 
				id=$('#action').val();
		 
		if(id=='' ){
			 
				item[0] = $('#partno').val();
				item[1] = $('#partno').val();
				item[2] = $('#detail').val();		
				item[3] = $('#out_box').val();
				item[4] = $('#out_box').val()*$('#qty_per_unit').val();
				item[5] = $('#place').val();		
				item[6] = $('#qty_per_unit').val();		
				item[7] = $('#weight').val();		
				
					 
				if (items != null) {
					items = JSON.parse(items);
				} else {
					items = new Array();
				}
				
				var count = Object.keys(items).length;
				if (count<16){
		 				items.push(item);
				}else{
					alert('不能輸入多於16件貨');
				}
					
		}else{
			items = JSON.parse(items);
			items[id][0] = $('#qty').val();
		}
	
		$('#action').val('');
				localStorage.setItem(pos+'_myItems',JSON.stringify(items));
				refresh();
	}

 function findPartNo(goods_partno, stockFlag) {
 
	 $.ajax({
		 type: 'GET',
		 dataType: "xml",
		 url: "/pos/productxml.php?goods_partno="+goods_partno,
		 success: function(xml){
			 $('#price').val($(xml).find('product_market_price').text());
			// alert( $('#price').val());
    		$('#desc').val($(xml).find('product_goods_detail').text());
			$('#readonly').val($(xml).find('product_readonly').text());
			  // alert( $('#desc').val());
		 }
	 })
		
 
	 
} 
 

			

