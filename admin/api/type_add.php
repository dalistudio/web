<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 类型
// 添加 - 即货物的类型和规格
//
	include '../../session.inc';
	include '../../conn.php';
	$HuoWu = $_GET['HuoWu'];
	$GuiGe = $_GET['GuiGe'];
	
	$sql  = "INSERT INTO type SET ";
	$sql .= "type_HuoWu='".$HuoWu."',"; // 货物
	$sql .= "type_GuiGe='".$GuiGe."'"; // 规格
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("类型添加成功~"); // 执行成功
			header('Location: /admin/type.php');
		}
		else
		{
			echo("类型添加失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
