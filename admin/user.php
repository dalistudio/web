<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include '../session.inc';
	include '../conn.php';
	
	check_login();
	if($_SESSION['Level']!=0)
	{
		print("无权访问");
		die();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>用户管理</title>
<script language="javascript">
	function OnAdd()
	{
		document.form1.action = "api/user_add.php";
		document.form1.submit(); // 提交按钮
	}

	function OnUpdate()
	{
		document.form1.action = "api/user_update.php";
		document.form1.submit(); // 提交按钮
	}
	
	function OnDel()
	{
		document.form1.action = "api/user_del.php";
		document.form1.submit(); // 提交按钮
	}
	
	// 处理选择行事件
	function OnSelect(id,name,pwd,level)
	{
		//alert("test");
		document.getElementById("id").value=id;
		document.getElementById("Name").value=name;
		document.getElementById("Pwd").value=pwd;
		document.getElementById("Level").value=level;
	}
</script>
</head>

<body>
<table class="tbl" width="600" border="1">
  <tr>
    <th width="20%">编号</th>
    <th width="30%">名称</th>
    <th width="30%">密码</th>
    <th width="20%">级别</th>
  </tr>
<?php
  $sql  = "Select * FROM user;";
  $result=mysql_query($sql); // 执行SQL语句
  while($row = mysql_fetch_array($result)) // 循环每条记录
  {
	print("<tr onclick=OnSelect('".$row['user_id']."','".$row['user_name']."','".$row['user_pwd']."','".$row['user_level']."');>");
 	print("  <td>".$row['user_id']."</td>");
  	print("  <td>".$row['user_name']."</td>");
  	print("  <td>".$row['user_pwd']."</td>");
	switch($row['user_level'])
	{
		case "0":
			print("  <td>管理员</td>");
			break;
		case "1":
			print("  <td>司磅员</td>");
			break;
		case "2":
			print("  <td>保安员</td>");
			break;
		case "3":
			print("  <td>财务人员</td>");
			break;
		case "4":
			print("  <td>地磅管理</td>");
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
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
<table class="tbl" width="300" border="1">
  <tr>
  	<th colspan="2">用户数据</th>
  </tr>
  <tr>
    <td align="center">编号：</td>
    <td><input name="id" type="text" id="id" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">名称：</td>
    <td><input type="text" name="Name" id="Name" /></td>
  </tr>
  <tr>
    <td align="center">密码：</td>
    <td><input type="text" name="Pwd" id="Pwd" /></td>
  </tr>
  <tr>
    <td align="center">级别：</td>
    <td><select name="Level" id="Level">
    <option value="0">管理员
    <option value="1">司磅员
    <option value="2">保安员
    <option value="3">财务人员
    <option value="4">地磅管理
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