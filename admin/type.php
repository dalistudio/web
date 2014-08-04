<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include '../session.inc';
	include '../conn.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>货物管理</title>
<script language="javascript">
	function OnAdd()
	{
		document.form1.action = "api/type_add.php";
		document.form1.submit(); // 提交按钮
	}

	function OnUpdate()
	{
		document.form1.action = "api/type_update.php";
		document.form1.submit(); // 提交按钮
	}
	
	function OnDel()
	{
		document.form1.action = "api/type_del.php";
		document.form1.submit(); // 提交按钮
	}
	
	// 处理选择行事件
	function OnSelect(id,huowu,guige)
	{
		//alert("test");
		document.getElementById("id").value=id;
		document.getElementById("HuoWu").value=huowu;
		document.getElementById("GuiGe").value=guige;
	}
</script>
</head>

<body>
<table class="tbl" width="600" border="1">
  <tr>
    <th scope="col" width="20%">编号</th>
    <th scope="col" width="40%">货物</th>
    <th scope="col" width="40%">规格</th>
  </tr>
<?php
  $sql  = "Select * FROM type;";
  $result=mysql_query($sql); // 执行SQL语句
  while($row = mysql_fetch_array($result)) // 循环每条记录
  {
	print("<tr onclick=OnSelect('".$row['type_id']."','".$row['type_HuoWu']."','".$row['type_GuiGe']."');>");
 	print("  <td>".$row['type_id']."</td>");
  	print("  <td>".$row['type_HuoWu']."</td>");
  	print("  <td>".$row['type_GuiGe']."</td>");
  	print("</tr>");
  }
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
<table class="tbl" width="300" border="1">
  <tr>
  	<th colspan="2">货物数据</th>
  </tr>
  <tr>
    <td align="center">编号：</td>
    <td><input name="id" type="text" id="id" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">货物：</td>
    <td><input type="text" name="HuoWu" id="HuoWu" /></td>
  </tr>
  <tr>
    <td align="center">规格：</td>
    <td><input type="text" name="GuiGe" id="GuiGe" /></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
          <th scope="col"><input type="button" name="Add" id="Add" value="添加" onclick="OnAdd();" /></th>
          <th scope="col"><input type="button" name="Update" id="Update" value="编辑" onclick="OnUpdate();" /></th>
          <th scope="col"><input type="button" name="Del" id="Del" value="删除" onclick="OnDel();" /></th>
        </tr>
    </table></td>
    </tr>
</table>
</form>
</body>
</html>