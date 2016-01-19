<?php
//
// 客户价目 - 数据表
// 更新 - 根据客户、货物、规格和车型，修改密度、价格和单位
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
	
	$sql  = "UPDATE goods SET ";
	$sql .= "goods_MiDu='".$MiDu."',"; // 货物密度
	$sql .= "goods_DanJia='".$DanJia."',"; // 单价
	$sql .= "goods_DanWei='".$DanWei."'"; // 单位
	$sql .= " WHERE ";
	$sql .= "member_id='".$Member."' and "; // 客户编号
	$sql .= "goods_name='".$HuoWu."' and "; // 货物名称
	$sql .= "goods_GuiGe='".$GuiGe."' and "; // 货物规格
	$sql .= "goods_CheXing='".$CheXing."'"; // 车型
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("客户价目更新成功~"); // 执行成功
		}
		else
		{
			echo("客户价目更新失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
