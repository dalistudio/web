<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 系统
// 更新 - 主要更新单号的开始顺序
//
	include '../../session.inc';
	include '../../conn.php';
	$DanHao = $_GET['DanHao'];
	
	$sql  = "UPDATE sys SET ";
	$sql .= "sys_DanHao='".$DanHao."'"; // 单号
	$sql .= " WHERE ";
	$sql .= "sys_id=1";
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("更新单号成功~"); // 执行成功
		}
		else
		{
			echo("更新单号失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
