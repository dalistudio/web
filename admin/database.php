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
<style type="text/css">
.tbl tr td strong {
	color: #F00;
}
.red {
	color: #F00;
}
</style>
<title>数据库管理</title>
<script language="javascript">
	function OnStart(obj)
	{
		// 获得按钮，并禁用。
		var but_Sys = document.getElementById("sys");
		var but_Bill = document.getElementById("bill");
		var but_member = document.getElementById("member");
		var but_Pay = document.getElementById("pay");
		var but_Type = document.getElementById("type");
		var but_Goods = document.getElementById("goods");
		var but_Car = document.getElementById("car");
		
		if(obj.checked)
		{
			// 启用
			alert("警告！！！\n这些操作可能会删除数据，并无法恢复，\n请先 \"备份\" 数据库，再操作！");
			but_Sys.disabled = false;
			but_Bill.disabled = false;
			but_member.disabled = false;
			but_Pay.disabled = false;
			but_Type.disabled = false;
			but_Goods.disabled = false;
			but_Car.disabled = false;
		}
		else
		{
			// 禁用
			//alert("22222");
			but_Sys.disabled = true;
			but_Bill.disabled = true;
			but_member.disabled = true;
			but_Pay.disabled = true;
			but_Type.disabled = true;
			but_Goods.disabled = true;
			but_Car.disabled = true;
		}
	}
	
	function OnSys()
	{
		self.location.href="api/sys_update.php?DanHao=100000";
	}
	function OnBill()
	{
		self.location.href="api/bill_clear.php";
	}
	function OnMember()
	{
		self.location.href="api/member_clear.php";
	}
	function OnPay()
	{
		self.location.href="api/pay_clear.php";
	}
	function OnType()
	{
		self.location.href="api/type_clear.php";
	}
	function OnGoods()
	{
		self.location.href="api/goods_clear.php";
	}
	function OnCar()
	{
		self.location.href="api/car_clear.php";
	}
</script>
</head>

<body>
<table class="tbl" width="600">
	<tr>
   	  <th colspan="2">数据库</th>
    </tr>
    <tr>
    	<td colspan="2">
        <strong>警告！！！</strong><br />
       	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1、此操作会删除数据库中所有相关的数据，在操作之前<span class="red">请确认已经备份数据</span>。<br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2、删除的数据无法恢复。<br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3、需要点击下面复选框才可以开始操作。<br />
      </td>
    </tr>
    <tr>
    	<td colspan="2"><input name="start" type="checkbox" onclick="OnStart(this);" />
    	开始数据库清空操作</td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<th>过磅单编号：</th>
        <td><input id="sys" name="sys" type="button" value="设置单号 = 100000" disabled="disabled" onclick="OnSys();" /> 
        sys表 十万以下的单号保留给门禁卡使用</td>
    </tr>
    <tr>
    	<th>过磅单数据：</th>
        <td><input id="bill" name="bill" type="button" value="清空数据" disabled="disabled" onclick="OnBill();" /> 
         bill表</td>
    </tr>
   	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<th>客户数据：</th>
        <td><input id="member" name="member" type="button" value="清空数据" disabled="disabled" onclick="OnMember();" /> member表</td>
    </tr>
    <tr>
    	<th>消费数据：</th>
        <td><input id="pay" name="pay" type="button" value="清空数据" disabled="disabled" onclick="OnPay();" /> pay表</td>
    </tr>
    <tr>
    	<th>货物数据：</th>
        <td><input id="type" name="type" type="button" value="清空数据" disabled="disabled" onclick="OnType();" /> type表</td>
    </tr>
    <tr>
    	<th>价目表数据：</th>
        <td><input id="goods" name="goods" type="button" value="清空数据" disabled="disabled" onclick="OnGoods();" /> goods表</td>
    </tr>
    <tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr>
    	<th>车辆数据：</th>
      <td><input id="car" name="car" type="button" value="清空数据" disabled="disabled" onclick="OnCar();" />        car表 保存车辆最后一次拉料数据。</td>
    </tr>
</table>

</body>
</html>