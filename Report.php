<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<script language="javascript">
function onPost(id)
{
	if(id==1)
	{
		// 查询
		form1.action="Report_Gen.php";
		form1.submit(); 
	}
	if(id==2)
	{
		// 下载
		form1.action="Report_Excel.php";
		form1.submit(); 
	}
}
</script>
<script src="js/WdatePicker.js"></script> 
<title>生成财务报表</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="Report_Excel.php">
  <br />
<table class="tbl" width="300" border="0">
  <tr>
    <th colspan="2" scope="col">条件</th>
    </tr>
  <tr>
    <td align="right">开始时间：</td>
    <td><input type="text" name="start" onFocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/></td>
  </tr>
  <tr>
    <td align="right">结束时间：</td>
    <td><input type="text" name="end" onFocus="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true})"/></td>
  </tr>
  <tr>
    <td width="91" align="right">车号：</td>
    <td width="199"><input type="text" name="CheHao" /></td>
  </tr>
  <tr>
    <td align="right">车型：</td>
    <td><input type="text" name="CheXing" /></td>
  </tr>
  <tr>
    <td align="right">客户：</td>
    <td><input type="text" name="DanWei" /></td>
  </tr>
  <tr>
    <td align="right">客户类型：</td>
    <td><select name="Type">
    <OPTION VALUE="">全部
    <OPTION VALUE="0">零售
    <OPTION VALUE="1">预付款
    <OPTION VALUE="2">月结
    </select></td>
  </tr>
  <tr>
    <td align="right">货物：</td>
    <td><input type="text" name="HuoWu" /></td>
  </tr>
  <tr>
    <td align="right">规格：</td>
    <td><input type="text" name="GuiGe" /></td>
  </tr>
  <tr>
    <td align="right">司磅员：</td>
    <td><input type="text" name="SiBangYuan" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><input type="button" value="查询" onclick="onPost(1);" /></td>
    <td><input type="button" value="下载" onclick="onPost(2);" />
    (注：生成需要10秒)</td>
  </tr>
</table>

</form>
</body>
</html>