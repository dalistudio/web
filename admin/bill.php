<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include '../session.inc';
	include '../conn.php';
	
	$Member_id = $_POST['member_id'];
	$Goods_HuoWu = $_POST['goods_HuoWu'];
	$Goods_GuiGe = $_POST['goods_GuiGe'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="/css/Default.css" />
<title>过磅单管理</title>
<script language="javascript">
	function OnAdd()
	{
		document.form1.action = "api/goods_add.php";
		document.form1.submit(); // 提交按钮
	}

	function OnUpdate()
	{
		document.form1.action = "api/goods_update.php";
		document.form1.submit(); // 提交按钮
	}
	
	function OnDel()
	{
		document.form1.action = "api/goode_del.php";
		document.form1.submit(); // 提交按钮
	}

	// 处理选择行事件
	function OnSelect(id)
	{
		//alert("test");
		document.getElementById("id").value=id;
	}
</script>
</head>

<body>
<form id="Form_Find" method="post" action="goods.php">
<table class="tbl" width="300" border="1">
	<tr>
    	<th colspan="2">查询条件</th>
    </tr>
	<tr>
   	  <th width="100">客户</th>
      <td>
        <select name="member_id" id="member_id">
        <?php
			$member_sql = "Select * FROM member;";
			$member_result=mysql_query($member_sql);
			print("<option value=''>全部");
			while($member_row = mysql_fetch_array($member_result))
			{
				print("<option value=".$member_row['member_id'].">".$member_row['member_name']);
			}
		?>
    	</select>
        </td>
    </tr>
    <tr>
    	<th>货物</th>
        <td><input name="goods_HuoWu" type="text" />
        </td>
    </tr>
    <tr>
    	<th>规格</th>
        <td><input name="goods_GuiGe" type="text" />
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="center">
        <input type="submit" value="查询" />
        </td>
  </tr>
</table>
</form>

<br />
<table class="tbl" width="1200" border="1">
  <tr>
    <th scope="col" width="80">单号</th>
    <th scope="col" width="100">车号</th>
    <th scope="col" width="100">单位</th>
    <th scope="col" width="80">货物</th>
    <th scope="col" width="80">规格</th>
    <th scope="col" width="80">净重</th>
    <th scope="col" width="80">密度</th>
    <th scope="col" width="80">单价</th>
    <th scope="col" width="80">金额</th>
    <th scope="col" width="80">余额</th>
    <th scope="col" width="80">备注</th>
  </tr>
<?php
  $sql  = "Select * FROM bill";
//  $sql .= " WHERE ";
//  if(strcmp($Member_id,'')!=0) $sql .= "goods.member_id='".$Member_id."' and ";
//  if(strcmp($Goods_HuoWu,'')!=0) $sql .= "goods.goods_name='".$Goods_HuoWu."' and ";
//  if(strcmp($Goods_GuiGe,'')!=0) $sql .= "goods.goods_GuiGe='".$Goods_GuiGe."' and ";
//  $sql .= "member.member_id=goods.member_id";
  $sql .= ";";

  $result=mysql_query($sql); // 执行SQL语句
  while($row = mysql_fetch_array($result)) // 循环每条记录
  {
	print("<tr onclick=OnSelect('".$row['bill_id']."');>");
 	print("  <td>".$row['bill_DanHao']."</td>");
	print("  <td>".$row['bill_CheHao']."</td>");
  	print("  <td>".$row['bill_DanWei']."</td>");
  	print("  <td>".$row['bill_HuoWu']."</td>");
  	print("  <td>".$row['bill_GuiGe']."</td>");
  	print("  <td>".$row['bill_JingZhong']."</td>");
  	print("  <td>".$row['bill_MiDu']."</td>");
	print("  <td>".$row['bill_DanJia']."</td>");
	print("  <td>".$row['bill_JinE']."</td>");
	print("  <td>".$row['bill_YuE']."</td>");
	print("  <td>".$row['bill_BeiZhu']."</td>");
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
  	<th colspan="2">价目数据</th>
  </tr>
  <tr>
    <td align="center">编号：</td>
    <td><input name="id" type="text" disabled="disabled" id="id" readonly="readonly" /></td>
  </tr>
  <tr>
    <td align="center">客户：</td>
    <td><input type="text" name="Member" id="Member" />
    这是编号</td>
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
    <td align="center">密度：</td>
    <td><input type="text" name="MiDu" id="MiDu" /></td>
  </tr>
  <tr>
    <td align="center">单价：</td>
    <td><input type="text" name="DanJia" id="DanJia" /></td>
  </tr>
  <tr>
    <td align="center">单位：</td>
    <td><input type="text" name="DanWei" id="DanWei" /></td>
  </tr>
  <tr>
    <td align="center">车型：</td>
    <td><input type="text" name="CheXing" id="CheXing" /></td>
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