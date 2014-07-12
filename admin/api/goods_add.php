<?php
//
// 客户价目 - 数据表
// 添加
//
	include '../../session.inc';
	include '../../conn.php';
	$Member = $_GET['Member'];
	$HuoWu = $_GET['HuoWu'];
	$GuiGe = $_GET['GuiGe'];
	$MiDu = $_GET['MiDu'];
	$DanJia = $_GET['DanJia'];
	$DanWei = $_GET['DanWei'];
	$CheXing = $_Get['CheXing'];
	
	$sql  = "INSERT INTO goods SET ";
	$sql .= "member_id='".$Member."',"; // 客户编号
	$sql .= "goods_name='".$HuoWu."',"; // 货物名称
	$sql .= "goods_GuiGe='".$GuiGe."',"; // 货物规格
	$sql .= "goods_MiDu='".$MiDu."',"; // 货物密度
	$sql .= "goods_DanJia='".$DanJia."',"; // 单价
	$sql .= "card_DanWei='".$DanWei."',"; // 单位
	$sql .= "goods_CheXing='".$CheXing."'"; // 车型
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("客户价目添加成功~"); // 执行成功
		}
		else
		{
			echo("客户价目添加失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
