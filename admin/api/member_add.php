<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 会员
// 添加 - 根据会员名称删除记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Name = $_GET['Name'];
	$DianHua = $_GET['DianHua'];
	$YuE = $_GET['YuE'];
	$Type = $_GET['Type'];
	
	$sql  = "INSERT INTO member SET ";
	$sql .= "member_name='".$Name."',"; // 会员名称
	$sql .= "member_DianHua='".$DianHua."',"; // 会员电话
	$sql .= "member_YuE='".$YuE."',"; // 会员余额
	$sql .= "member_Type='".$Type."'"; // 会员类型
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("会员添加成功~"); // 执行成功
		}
		else
		{
			echo("会员添加失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
