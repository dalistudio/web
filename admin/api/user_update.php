<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

// 
// 用户
// 更新 - 根据用户名称更新记录
// 
	include '../../session.inc';
	include '../../conn.php';
	$Id = $_GET['id'];
	$Name = $_GET['Name'];
	$Pwd = $_GET['Pwd'];
	$Level = $_GET['Level'];
	
	$sql  = "UPDATE user SET ";
	$sql .= "user_pwd='".$Pwd."',"; // 用户密码
	$sql .= "user_level='".$Level."',"; // 用户级别
	$sql .= "user_name='".$Name."'"; // 用户名称
	$sql .= " WHERE ";
	$sql .= "user_id='".$Id."'";
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("用户更新成功~"); // 执行成功
			header('Location: /admin/user.php');
		}
		else
		{
			echo("用户更新失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
