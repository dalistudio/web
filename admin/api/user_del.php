<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 用户
// 删除 - 根据用户名称删除记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Name = $_GET['Name'];
	
	$sql  = "DELETE FROM user ";
	$sql .= " WHERE ";
	$sql .= "user_name='".$Name."'"; // 用户名称
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("用户删除成功~"); // 执行成功
			header('Location: /admin/user.php');
		}
		else
		{
			echo("用户删除失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
