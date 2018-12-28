 
ls=Storages.localStorage;
var pos='pos1';


	  $(function () { 
		refresh(); 
	  });
	
	 function refresh() {
		var total=0;
		
		 
		items = localStorage.getItem(pos+'_myItems');
		var ul = $('#rightlist');
		 ul.html('');
		if (items != null) {
			items = JSON.parse(items);
			$(items).each(function (index, data) {
				var tmp=index+1;
				total=total+(parseFloat(data[0])*parseFloat(data[6]));
				console.log('totalprice='+total);
			ul.append('<tr><td>['+tmp+']</td><td>' + data[1] +'</td> <td> <a class="chgQty" data="'+index+'" dataDesc="'+data[2]+'" >'+ data[0] +' 箱</a></td><td>'+data[0]*data[5]+'件 </td><td>'+data[4]+'</td><td> <a class="remove" data="'+index+'">X</a></td></tr>');
			});
				ul.append('<tr><td colspan="1">總重:</td><td colspan="3"> <b>'+total+'</b></td></tr>');
		}
		
		
		var ino = localStorage.getItem('invoiceno');
 
		 var inoh=$('#ino');
		 
	 }
	

	
   $(document).on('click', '#cleanall', function(){
	ls=Storages.localStorage;
	ls.remove(pos+'_myItems');
	ls.remove(pos+'_memadd');
	ls.remove(pos+'_memid');
	ls.remove(pos+'_receiver');
	ls.remove('invoiceno');
	inoh.show();
	 refresh(); 
	});
  
  
    $(document).on('click', '.chgQty', function(){
		var id=$(this).attr("data");
		 $('#desc') .val('tempdesc');
		$('#action').val(id);
	 	$('#qty').click();
		
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
		// click mem_id
		$(' .quickinput_memid').click(function(){
			  quickinputMemID();
		});
		// click mem_add
		$('.quickinput_memadd').click(function(){
			  quickinputMemAdd();
		});
		// click receiver
		$('.quickinput_receiver').click(function(){
			  quickinputReceiver();
		});

		
		
	  });
	  
	   function quickinputMemAdd(){
		  
				var items = localStorage.getItem(pos+'_memadd');
				items = new Array();
				items.push($('#mem_add').val());
				localStorage.setItem(pos+'_memadd',JSON.stringify(items));
				refresh();
	  }
	  
	  function quickinputMemID(){
		var items = localStorage.getItem(pos+'_memid');
		items = new Array();
		items.push($('#mem_id').val());
		localStorage.setItem(pos+'_memid',JSON.stringify(items));
		refresh();
	  }
	   function quickinputReceiver(){
		var items = localStorage.getItem(pos+'_receiver');
		items = new Array();
		items.push($('#receiver').val());
		localStorage.setItem(pos+'_receiver',JSON.stringify(items));
		refresh();
	  }
	  
	  function quickinput(){
		  $('#partno').val($('#quickinput').val());
			findPartNo($('#partno').val());
		 	$('#qty').click();
	  }
	   
	 function storeItem() {
		 
		 
				var item=[];
				var items = localStorage.getItem(pos+'_myItems');
				var id=0;
				id=$('#action').val();
		 
		if(id=='' ){
			 
				item[0] = $('#out_box').val();
				item[1] = $('#partno').val();
				item[2] = $('#rest_qty').val();
				item[3] = $('#rest_box').val();
				item[4] = $('#place').val();		
				item[5] = $('#qty_per_unit').val();
				item[6] = $('#weight').val();
				item[7] = $('#detail').val();
					 
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
		 url: "/pos_outstock/productxml.php?goods_partno="+goods_partno,
		 success: function(xml){
			 $('#price').val($(xml).find('product_market_price').text());
			// alert( $('#price').val());
    		$('#desc').val($(xml).find('product_goods_detail').text());
			$('#readonly').val($(xml).find('product_readonly').text());
			  // alert( $('#desc').val());
		 }
	 })
		
 
	 
} 
 

			

