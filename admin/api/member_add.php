<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
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
	$JingGao = $_GET['JingGao']; // 警告额度
	$XinYong = $_GET['XinYong']; // 信用额度
	$BlackList = $_GET['BlackList']; // 黑名单
	
	$sql  = "INSERT INTO member SET ";
	$sql .= "member_name='".$Name."',"; // 会员名称
	$sql .= "member_DianHua='".$DianHua."',"; // 会员电话
	$sql .= "member_YuE='".$YuE."',"; // 会员余额
	$sql .= "member_Type='".$Type."',"; // 会员类型
	$sql .= "member_JingGao='".$JingGao."',"; // 警告额度
	$sql .= "member_Xinyong='".$XinYong."',"; // 信用额度
	$sql .= "member_BlackList='".$BlackList."'"; // 黑名单
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("会员添加成功~"); // 执行成功
			header('Location: /admin/member.php');
		}
		else
		{
			echo("会员添加失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
