<? 
if ($add==1) //after submit
  {
   $flag=0;
  include("../include/config.php");
      
   $query="select * from member where member_id='$member_id'";
   $result=mysql_query($query);
   $row= mysql_fetch_array ($result);
   if ($row["member_id"]!=null)
   $flag=1;
   
   
   
   if ($flag==1)
   {
    echo "此項 客戶編號 已於早前被輸入資料庫";
   }
   else
   {

  
       
    $query="insert into member (member_id,member_name,member_add,member_tel,member_fax,member_good_type,creditLevel,transportLevel,remark) values ('$member_id','$member_name','$member_add','$member_tel','$member_fax','$member_good_type','$creditLevel','$transportLevel','$remark')";
  
      
      if (mysql_query($query))
      echo "己經存入";
      else
       echo "Too Bad!";
   }

}
?>
<html>
<head>

<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<LINK REL=stylesheet HREF="english.css" TYPE="text/css">
<STYLE TYPE="text/css">
h1 {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"}
h2 {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"}
li { line-height: 14pt }
input {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 12px}
select {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 12px}
.login       { background-color: #CCCCCC; color: #000000; font-size: 9pt; border-style: solid; 
               border-width: 1px }
small {  font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt; line-height: 14pt}
p { font-family: "Verdana", "Arial", "Helvetica", "sans-serif"; font-size: 9pt ;font-color: #FFFFFF}
.style6 {color: #FFFFFF}
.style7 {color: #000000; border-style: solid; border-width: 1px; background-color: #CCCCCC;}
</STYLE>

<script language="JavaScript">
function checkform()
{
	if(document.membernameform.member_id.value == "")
	{
	alert ("請輸入供應商編號.");
	document.membernameform.member_id.focus();
	}else
	{
        document.membernameform.submit();
   }

}
</script>
</head>

<body text="#000000">
<form name=membernameform method="post" action="inmembername.php">
  
  <div align="center">
    <table width="750" border="0" cellpadding="0" cellspacing="0">
      <tr bgcolor="#006666">
        <td>&nbsp;</td>
        <td withd="86%">&nbsp;</td>
      </tr>
      <tr bgcolor="#666666"> 
        <input name="add" type="hidden" class="style7" value=1>
        <td width="33%" class="style6">客戶編號 :</td>
        <td width="67%" withd="86%"> 
        <input name="member_id" type="text" style="border-width: 1px; background-color: #CCCCCC;" maxlength="20" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#666666"> 
        <td width="33%" class="style6">客戶中文名稱 :        </td>
        <td width="67%"> 
        <input name="member_name" type="text" style="border-width: 1px; background-color: #CCCCCC;" value="" size="40" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#666666"> 
        <td width="33%" class="style6">客戶地址 :        </td>
        <td width="67%"> 
        <textarea name="member_add" cols="40" rows="4" style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid"></textarea>        </td>
      </tr>
      <tr bgcolor="#666666"> 
        <td width="33%" class="style6">客戶電話號碼 : </td>
        <td width="67%"> 
        <input name="member_tel" type="text" style="border-width: 1px; background-color: #CCCCCC;" value="" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#666666"> 
        <td width="33%" class="style6">客戶傳真號碼 :</td>
        <td width="67%"> 
        <input name="member_fax" type="text" style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#666666"> 
        <td width="33%" class="style6">客戶貨品種類 :</td>
        <td width="67%"> 
        <input name="member_good_type" type="text" style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid">        </td>
      </tr>
      <tr bgcolor="#006666">
        <td bgcolor="#666666" class="style6">客戶級別 :  </td>
        <td bgcolor="#666666" class="style6"><label>
          <select name="creditLevel">
            <option value="A" selected>A</option>
            <option value="B">B</option>
            <option value="C">C</option>
            <option value="D">D</option>
            <option value="E">E</option>
          </select>
        </label></td>
      </tr>
      <tr bgcolor="#006666">
        <td bgcolor="#666666" class="style6">Remark</td>
        <td bgcolor="#666666" class="style6"><label>
          <textarea name="remark"></textarea>
        </label></td>
      </tr>
      <tr bgcolor="#006666"> 
        <td width="33%">&nbsp;</td>
        <td width="67%" class="style6"><a href="JavaScript:checkform();"><img src="submit.gif" width="49" height="21" border=0 align=bottom></a>        </td>
      </tr>
    </table>  
  </div>
</form>
</body>
</html>
