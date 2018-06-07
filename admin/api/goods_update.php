<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 客户价目 - 数据表
// 更新 - 根据客户、货物、规格和车型，修改密度、价格和单位
//
	include '../../session.inc';
	include '../../conn.php';
	$Id = $_GET['id'];
	$Member = $_GET['Member'];
	$HuoWu = $_GET['HuoWu'];
	$GuiGe = $_GET['GuiGe'];
	$MiDu = $_GET['MiDu'];
	$DanJia = $_GET['DanJia'];
	$DanWei = $_GET['DanWei'];
	$CheXing = $_GET['CheXing'];
	
	$sql  = "UPDATE goods SET ";
	$sql .= "goods_MiDu='".$MiDu."',"; // 货物密度
	$sql .= "goods_DanJia='".$DanJia."',"; // 单价
	$sql .= "goods_DanWei='".$DanWei."',"; // 单位
	$sql .= "member_id='".$Member."',"; // 客户编号
	$sql .= "goods_name='".$HuoWu."',"; // 货物名称
	$sql .= "goods_GuiGe='".$GuiGe."',"; // 货物规格
	$sql .= "goods_CheXing='".$CheXing."'"; // 车型
	$sql .= " WHERE ";
	$sql .= "goods_id='".$Id."'";
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("客户价目更新成功~"); // 执行成功
			header('Location: /admin/goods.php');
		}
		else
		{
			echo("客户价目更新失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
