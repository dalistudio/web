<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 客户 - 数据表
// 清理
//
	include '../../session.inc';
	include '../../conn.php';
	check_login();
	if($_SESSION['Level']!=0)
	{
		print("无权访问");
		die();
	}
	
	$sql = "TRUNCATE TABLE member;";
	
	// 关闭外键检查
	mysql_query('SET foreign_key_checks=0',$conn);
	if(mysql_query($sql,$conn)) // 执行语句
	{
		echo("客户表清理干净~"); // 执行成功
	}
	else
	{
		echo("客户清理失败！！！\n");
		echo("ERROR：". mysql_error()); // 执行失败
	}
	//开启外键检查
	mysql_query('SET foreign_key_checks=1',$conn);

	mysql_close($conn); // 关闭数据库连接
?>