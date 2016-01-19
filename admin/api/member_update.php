<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 会员
// 更新 - 根据会员名称更新记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Id = $_GET['id'];
	$Name = $_GET['Name'];
	$DianHua = $_GET['DianHua'];
	$YuE = $_GET['YuE'];
	$Type = $_GET['Type'];
	$JingGao = $_GET['JingGao']; // 警告额度
	$XinYong = $_GET['XinYong']; // 信用额度
	
	$sql  = "UPDATE member SET ";
	$sql .= "member_DianHua='".$DianHua."',"; // 会员电话
	$sql .= "member_YuE='".$YuE."',"; // 会员余额
	$sql .= "member_Type='".$Type."',"; // 会员类型
	$sql .= "member_name='".$Name."',"; // 会员名称
	$sql .= "member_JingGao='".$JingGao."',"; // 警告额度
	$sql .= "member_Xinyong='".$XinYong."'"; // 信用额度
	$sql .= " WHERE ";
	$sql .= "member_id='".$Id."'";
	$sql .= ";";
	print($sql);
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("会员更新成功~"); // 执行成功
			header('Location: /admin/member.php');
		}
		else
		{
			echo("会员更新失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
