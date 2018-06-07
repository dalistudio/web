<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 价目表 - 数据表
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
	
	$sql = "TRUNCATE TABLE goods;";
	
	if(mysql_query($sql,$conn)) // 执行语句
	{
		echo("价目表清理干净~"); // 执行成功
	}
	else
	{
		echo("价目清理失败！！！\n");
		echo("ERROR：". mysql_error()); // 执行失败
	}

	mysql_close($conn); // 关闭数据库连接
?>