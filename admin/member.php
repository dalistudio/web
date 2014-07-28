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
<title>客户管理</title>
<script language="javascript">
	function OnAdd()
	{
		document.form1.action = "api/member_add.php";
		document.form1.submit(); // 提交按钮
	}

	function OnUpdate()
	{
		document.form1.action = "api/member_update.php";
		document.form1.submit(); // 提交按钮
	}
	
	function OnDel()
	{
		document.form1.action = "api/member_del.php";
		document.form1.submit(); // 提交按钮
	}
	
	// 处理选择行事件
	function OnSelect(id,name,dianhua,yue,type)
	{
		//alert("test");
		document.getElementById("id").value=id;
		document.getElementById("Name").value=name;
		document.getElementById("DianHua").value=dianhua;
		document.getElementById("YuE").value=yue;
		document.getElementById("Type").value=type;
	}
</script>
</head>

<body>
<table class="tbl" width="600" border="1">
  <tr>
    <th width="10%">编号</th>
    <th width="30%">名称</th>
    <th width="20%">电话</th>
    <th width="20%">余额</th>
    <th width="20%">类型</th>
  </tr>
<?php
  $sql  = "Select * FROM member;";
  $result=mysql_query($sql); // 执行SQL语句
  while($row = mysql_fetch_array($result)) // 循环每条记录
  {
	print("<tr onclick=OnSelect('".$row['member_id']."','".$row['member_name']."','".$row['member_DianHua']."','".$row['member_YuE']."','".$row['member_Type']."');>");
 	print("  <td>".$row['member_id']."</td>");
  	print("  <td>".$row['member_name']."</td>");
  	print("  <td>".$row['member_DianHua']."</td>");
  	print("  <td>".$row['member_YuE']."</td>");
	switch($row['member_Type'])
	{
		case "0":
			print("  <td>零售</td>");
			break;
		case "1":
			print("  <td>预付</td>");
			break;
		case "2":
			print("  <td>月结</td>");
			break;
	}
  	print("</tr>");
  }
?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
<table class="tbl" width="300" border="1">
  <tr>
  	<th colspan="2">客户数据</th>
  </tr>
  <tr>
    <td align="center">编号：</td>
    <td><input name="id" type="text" disabled="disabled" id="id" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">名称：</td>
    <td><input type="text" name="Name" id="Name" /></td>
  </tr>
  <tr>
    <td align="center">电话：</td>
    <td><input type="text" name="DianHua" id="DianHua" /></td>
  </tr>
  <tr>
    <td align="center">余额：</td>
    <td><input type="text" name="YuE" id="YuE" /></td>
  </tr>
  <tr>
    <td align="center">类型：</td>
    <td><select name="Type" id="Type">
    <option value="0">零售
    <option value="1">预存
    <option value="2">月结
    </select></td>
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