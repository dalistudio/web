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
<title>门禁卡管理</title>
<script language="javascript">
	function OnAdd()
	{
		document.form1.action = "api/card_add.php";
		document.form1.submit(); // 提交按钮
	}

	function OnUpdate()
	{
		document.form1.action = "api/card_update.php";
		document.form1.submit(); // 提交按钮
	}
	
	function OnDel()
	{
		document.form1.action = "api/card_del.php";
		document.form1.submit(); // 提交按钮
	}
	
	// 处理选择行事件
	function OnSelect(id,kahao,chehao,chexing,dianhua,danwei)
	{
		//alert("test");
		document.getElementById("id").value=id;
		document.getElementById("KaHao").value=kahao;
		document.getElementById("CheHao").value=chehao;
		document.getElementById("CheXing").value=chexing;
		document.getElementById("DianHua").value=dianhua;
		document.getElementById("DanWei").value=danwei;
	}
</script>
</head>

<body>
<table class="tbl" width="600" border="1">
  <tr>
    <th width="10%">编号</th>
    <th width="20%">卡号</th>
    <th width="15%">车号</th>
    <th width="15%">车型</th>
    <th width="20%">电话</th>
    <th width="20%">单位</th>
  </tr>
<?php
  $sql  = "Select * FROM card;";
  $result=mysql_query($sql); // 执行SQL语句
  while($row = mysql_fetch_array($result)) // 循环每条记录
  {
	print("<tr onclick=OnSelect('".$row['card_id']."','".$row['card_KaHao']."','".$row['card_CheHao']."','".$row['card_CheXing']."','".$row['card_DianHua']."','".$row['card_DanWei']."');>");
 	print("  <td>".$row['card_id']."</td>");
  	print("  <td>".$row['card_KaHao']."</td>");
  	print("  <td>".$row['card_CheHao']."</td>");
  	print("  <td>".$row['card_CheXing']."</td>");
  	print("  <td>".$row['card_DianHua']."</td>");
  	print("  <td>".$row['card_DanWei']."</td>");
  	print("</tr>");
  }
?>
  <tr>
    <td>&nbsp;</td>
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
  	<th colspan="2">门禁卡数据</th>
  </tr>
  <tr>
    <td align="center">编号：</td>
    <td><input name="id" type="text" disabled="disabled" id="id" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">卡号：</td>
    <td><input type="text" name="KaHao" id="KaHao" /></td>
  </tr>
  <tr>
    <td align="center">车号：</td>
    <td><input type="text" name="CheHao" id="CheHao" /></td>
  </tr>
  <tr>
    <td align="center">车型：</td>
    <td><input type="text" name="CheXing" id="CheXing" /></td>
  </tr>
  <tr>
    <td align="center">电话：</td>
    <td><input type="text" name="DianHua" id="DianHua" /></td>
  </tr>
  <tr>
    <td align="center">单位：</td>
    <td><input type="text" name="DanWei" id="DanWei" /></td>
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