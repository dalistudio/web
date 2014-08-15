<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 过磅单表 - 数据表
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
	
	$sql = "TRUNCATE TABLE bill;";
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("过磅单表清理干净~"); // 执行成功
		}
		else
		{
			echo("过磅单清理失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>