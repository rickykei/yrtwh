<?  include_once("./include/config.php");?>
  
<style type="text/css">
 
body {
	background-color: #B2DDEB;
	text-align: center;
}
.style1 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 22px;
}
 
</style></head>
<LINK REL=stylesheet HREF="english.css" TYPE="text/css">
<body text="#000000"><table border="0" align="center">
  <tr>
    <td bgcolor="#FFFFFF"><table width="800" border="0" height="91" align="center">
      <tr bgcolor="#999999">
        <td height="34" colspan="3">
          <div align="center" class="style1">YRT 倉 2018  [<?php echo $UNAME; ?>]<a href="/logout.php"> LOGOUT</a> 
 </div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td width="25%">
          <div align="center"><a href="/?page=ingood&subpage=ingoodname.php&add=0" target="_blank">入貨名</a></div></td>
        <td width="54%" height="21">
          <div align="center"><a href="/?page=instock&subpage=index.php" target="instock">入倉單</a></div></td>
        <td width="21%" height="21"> <div align="center"><a href="/?page=outstock&subpage=index.php" target="invoice">提貨單</a> </div></td>
      </tr>
      <tr bgcolor="#CCCCCC">
        <td>
           <div align="center"><a href="/?page=ingood&subpage=ingood_list.php" target="_blank">所有入貨名</a></div></td></td>
        <td>
          <div align="center"> <a href="/?page=instock&subpage=instocklist.php" target="instocklist">所有入倉單</a></div></td>
        <td><div align="center"><a href="/?page=outstock&subpage=outstocklist.php" target="invoicelist">所有提貨單</a></div></td>
      </tr>
	 
 
	      
      
      
        
      <tr bgcolor="#CCCCCC">
        <td align="center" height="20"> </td>
        <td><div align="center">  </div></td>
        <td align="center"><a href="/?page=pos_outstock&subpage=index.php&pos=pos1">POS 提貨單</a></td>
      </tr>
      
	      <tr bgcolor="#CCCCCC">
        <td align="center"> </td>
        <td><div align="center"> <a target="_blank" href="/?page=statistic&subpage=inventory.php">存貨表 </a></div></td>
        <td align="center"><span class="style6"><a href="/?page=staff&subpage=index.php" target="_blank">員工設定</a></span></td>
      </tr>
      
      
	   
    </table></td>
  </tr>
</table><br>
</body></html>
 
