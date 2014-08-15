<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 支付 - 数据表
// 更新 - 根据支付号修改记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Id = $_GET['id'];
	$Member = $_GET['Member'];
	$DanHao = $_GET['DanHao'];
	$JinE = $_GET['JinE'];
	$Date = $_GET['Date'];
	
	$sql  = "UPDATE pay SET ";
	$sql .= "member_name='".$Member."',"; // 客户
	$sql .= "bill_DanHao='".$DanHao."',"; // 单号
	$sql .= "pay_JinE='".$JinE."',"; // 支付金额
	$sql .= "pay_date='".$Date."'"; // 支付日期
	$sql .= " WHERE ";
	$sql .= "pay_id='".$Id."'"; // 支付号
	$sql .= ";";
	print($sql);
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("支付表更新成功~"); // 执行成功
			header('Location: /admin/pay.php');
		}
		else
		{
			echo("支付表更新失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
