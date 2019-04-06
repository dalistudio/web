<?php
//
// Copyright (c) 2014-2019, wangdali <wangdali@qq.com>, All Rights Reserved.
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
<title>限重管理</title>
<script language="javascript">
    function OnOpen()
	{
		var option=confirm("是否真的启用限重模块?");//true,false
		if(option){
			document.form1.action = "api/limit_open.php";
			document.form1.submit(); // 开启按钮
		}
    }

    function OnClose()
	{
		var option=confirm("是否真的禁用限重模块?");//true,false
		if(option){
			document.form1.action = "api/limit_close.php";
			document.form1.submit(); // 关闭按钮
		}
	}
    
	function OnAdd()
	{
		document.form1.action = "api/limit_add.php";
		document.form1.submit(); // 提交按钮
	}

	function OnUpdate()
	{
		var option=confirm("是否真的编辑?");//true,false
		if(option){
			document.form1.action = "api/limit_update.php";
			document.form1.submit(); // 编辑按钮
		}
	}
	
	function OnDel()
	{
		var option=confirm("是否真的删除?");//true,false
		if(option){
			document.form1.action = "api/limit_del.php";
			document.form1.submit(); // 删除按钮
		}
		
	}
	
	// 处理选择行事件
	function OnSelect(id,Axle,Type,Weight)
	{
		//alert("test");
		document.getElementById("id").value=id;
		document.getElementById("Axle").value=Axle;
		document.getElementById("Type").value=Type;
		document.getElementById("Weight").value=Weight;
	}
</script>
</head>

<body>
<table class="tbl" width="600" border="1">
  <tr>
    <th width="40%">限重模块启用/禁止:
    <?php
        $sql  = "Select * FROM sys;";
        $result=mysql_query($sql); // 执行SQL语句
        while($row = mysql_fetch_array($result)) // 循环每条记录
        {
            switch($row['sys_limit_flag'])
	        {
		        case "0":
			        print(" <div style='color:#F00'>禁用</div> ");
			        break;
		        case "1":
			        print(" <div style='color:#F00'>启用</div> ");
                    break;
            }
        }
    ?>
    </th>
    <td width="30%" align="center"><input type="button" name="Open" id="Open" value="启用" onclick="OnOpen();" /></td>
    <td width="30%" align="center"><input type="button" name="Close" id="Close" value="禁止" onclick="OnClose();" /></td>
  </tr>
</table>
<br />
<br />
<table class="tbl" width="600" border="1">
  <tr>
    <th width="20%">编号</th>
    <th width="30%">车轴数</th>
    <th width="30%">车类型</th>
    <th width="20%">限重(吨)</th>
  </tr>
<?php
  $sql  = "Select * FROM limits;";
  $result=mysql_query($sql); // 执行SQL语句
  while($row = mysql_fetch_array($result)) // 循环每条记录
  {
	print("<tr onclick=OnSelect('".$row['id']."','".$row['limit_axle']."','".$row['limit_type']."','".$row['limit_weight']."');>");
 	print("  <td>".$row['id']."</td>");
  	print("  <td>".$row['limit_axle']."</td>");
  	print("  <td>".$row['limit_type']."</td>");
    print("  <td>".$row['limit_weight']."</td>");
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
  	<th colspan="2">限重数据</th>
  </tr>
  <tr>
    <td align="center">编号：</td>
    <td><input name="id" type="text" id="id" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">车轴数：</td>
    <td><input type="text" name="Axle" id="Axle" /></td>
  </tr>
  <tr>
    <td align="center">车类型：</td>
    <td><input type="text" name="Type" id="Type" /></td>
  </tr>
  <tr>
    <td align="center">限重(吨)：</td>
    <td><input type="text" name="Weight" id="Weight" /></td>
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