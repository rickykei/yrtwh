 

 

 
function SearchStaff(){
	///var abc;
	//abc=document.form1.partno[0].value;
	//alert(abc);
	window.open('page_search_staff.php?recid=3',"Search Sfaff","left=400,screenY=300,width=530,height=360,scrollbars=yes");
}
function checkform()
{
	if (document.form1.fee.value=="")
	{
		alert('價錢');
		document.form1.fee.focus();
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