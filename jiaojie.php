<?php
	$User = $_GET['user'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"> 
<html> 
<head> 
<title>交接班报表</title> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="js/Calendar.js"></script> 
</head> 
<body>
<form name="form1" method="post" action="Report_JiaoJie.php">
<table width="600" border="1" align="center"  cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4" align="center"><?=$User?>的交接班报表</td>
  </tr>
  <tr>
    <td align="center">开始时间：</td>
    <td align="center"><input type="text" name="start" readOnly onClick="setDayHM(this);"></td>
    <td align="center">结束时间：</td>
    <td align="center"><input type="text" name="end" readOnly onClick="setDayHM(this);"> </td>
  </tr>
  <tr>
    <td colspan="4" align="center"><input type="submit" value="提交"></td>
    <td colspan="4" align="center"><input type="text" name="user" value="<?=$User?>" style="display:none;"></td>
    </tr>
</table>
</form>
</body> 
</html>