<?php
//
// 类型
// 更新 - 根类型编号更新记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Id = $_GET['id'];
	$HuoWu = $_GET['HuoWu'];
	$GuiGe = $_GET['GuiGe'];
	
	$sql  = "UPDATE type SET ";
	$sql .= "type_HuoWu='".$HuoWu."',"; // 货物
	$sql .= "type_GuiGe='".$GuiGe."'"; // 规格
	$sql .= " WHERE ";
	$sql .= "type_id='".$Id."'"; // 类型编号
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("类型更新成功~"); // 执行成功
		}
		else
		{
			echo("类型更新失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
