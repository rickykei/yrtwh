<html>
<head>
<title>會員登記表</title>
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
.style6 {
	color: #000000;
}
.style7 {color: #000000; border-style: solid; border-width: 1px; background-color: #CCCCCC;}
</STYLE>
<?   require_once("../include/config.php"); ?>
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onkeydown="detectKeyBoard(event)">
<form action="inmembername2.php" method="POST" enctype="application/x-www-form-urlencoded" name="membernameform">
<table width="710" height="400" border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#99CC99">
  <tr>
    <td  >&nbsp;</td>
    <td  align="center" valign="top">
      <table width="95%"  border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td width="14%" height="21" bgcolor="#CC9900"><span class="style6">會員登記表</span></td>
        <td width="34%"><? echo "< ".$AREA."鋪,第".$PC."機 >";?></td>
        <td width="15%">&nbsp;</td>
        <td width="37%">&nbsp;</td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td height="24" colspan="4"><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#006633">
            <td width="27" height="21" bgcolor="#CCCC00">&nbsp;</td>
            <td width="178" bgcolor="#CCCC00">&nbsp;</td>
             <td width="454" bgcolor="#CCCC00">&nbsp;</td>
            <td width="217" bgcolor="#CCCC00">&nbsp;</td>
			</tr>
          <tr bgcolor="#006633">
            <td height="21" bgcolor="#CCCC00">&nbsp;</td>
            <td align="right" bgcolor="#CCCC00"><span class="style6">客戶編號 :</span></td>
            <td bgcolor="#CCCC00"><input name="member_id" type="text" style="border-width: 1px; background-color: #CCCCCC;" maxlength="20" #invalid_attr_id="solid"></td>
            <td bgcolor="#CCCC00">&nbsp;</td>
            </tr>
          <tr bgcolor="#006633">
            <td height="21" bgcolor="#CCCC00">&nbsp;</td>
            <td align="right" bgcolor="#CCCC00"><span class="style6">客戶中文名稱 : </span></td>
            <td bgcolor="#CCCC00"><input name="member_name" type="text" style="border-width: 1px; background-color: #CCCCCC;" value="" size="40" #invalid_attr_id="solid"></td>
            <td bgcolor="#CCCC00">&nbsp;</td>
            </tr>
          <tr bgcolor="#006633">
            <td height="21" bgcolor="#CCCC00">&nbsp;</td>
            <td align="right" bgcolor="#CCCC00"><span class="style6">客戶地址 : </span></td>
            <td bgcolor="#CCCC00"><textarea name="member_add" cols="40" rows="4" style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid"></textarea></td>
            <td bgcolor="#CCCC00">&nbsp;</td>
            </tr>
          <tr bgcolor="#006633">
            <td height="21" bgcolor="#CCCC00">&nbsp;</td>
            <td align="right" bgcolor="#CCCC00"><span class="style6">客戶電話號碼 : </span></td>
            <td bgcolor="#CCCC00"><input name="member_tel" type="text" style="border-width: 1px; background-color: #CCCCCC;" value="" #invalid_attr_id="solid"></td>
            <td bgcolor="#CCCC00">&nbsp;</td>
            </tr>
          <tr bgcolor="#006633">
            <td height="21" bgcolor="#CCCC00">&nbsp;</td>
            <td align="right" bgcolor="#CCCC00"><span class="style6">客戶傳真號碼 :</span></td>
            <td bgcolor="#CCCC00"><input name="member_fax" type="text" style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid"></td>
            <td bgcolor="#CCCC00">&nbsp;</td>
          </tr>
          <tr bgcolor="#006633">
            <td height="21" bgcolor="#CCCC00">&nbsp;</td>
            <td align="right" bgcolor="#CCCC00"><span class="style6">戶貨品種類 :</span></td>
            <td bgcolor="#CCCC00"><input name="member_good_type" type="text" style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid"></td>
            <td bgcolor="#CCCC00">&nbsp;</td>
          </tr>
          <tr bgcolor="#006633">
            <td height="21" bgcolor="#CCCC00">&nbsp;</td>
            <td align="right" bgcolor="#CCCC00"><span class="style6">客戶級別 : </span></td>
            <td bgcolor="#CCCC00"><select name="creditLevel"  style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid">
              <option value="A" selected>A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
              <option value="E">E</option>
            </select></td>
            <td bgcolor="#CCCC00">&nbsp;</td>
          </tr>
          <tr bgcolor="#006633">
            <td height="21" bgcolor="#CCCC00">&nbsp;</td>
            <td align="right" bgcolor="#CCCC00"><span class="style6">備註: </span></td>
            <td bgcolor="#CCCC00"><textarea name="remark"  style="border-width: 1px; background-color: #CCCCCC;" #invalid_attr_id="solid"></textarea></td>
            <td bgcolor="#CCCC00">&nbsp;</td>
          </tr>
          <tr bgcolor="#006633">
            <td height="21" bgcolor="#CCCC00">&nbsp;</td>
            <td align="right" bgcolor="#CCCC00">&nbsp;</td>
            <td bgcolor="#CCCC00"><input type="button" value="送出" onclick="checkform()"/>
              <?=$alertMsg?></td>
            <td bgcolor="#CCCC00">&nbsp;</td>
          </tr>
         
        </table></td>
      </tr>
    
    </table>     </td>
  </tr>
</table>

</form>


</body>
</html>
