<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 支付 - 数据表
// 添加 - 单号为唯一值
//
	include '../../session.inc';
	include '../../conn.php';
	$Member = $_GET['Member'];
	$DanHao = $_GET['DanHao'];
	$JinE = $_GET['JinE'];
	$Date = $_GET['Date'];
	if(strcmp($Date,'')==0)
	{
		date_default_timezone_set('PRC');//其中PRC为“中华人民共和国”
		$datetime = strtotime("now"); // 获得当前日期
		$mysqldate = date("Y-m-d H:i:s", $datetime); // 转换为指定格式的字符串
		$Date = $mysqldate;
	}
	
	$sql  = "INSERT INTO pay SET ";
	$sql .= "member_name='".$Member."',"; // 客户
	$sql .= "bill_DanHao='".$DanHao."',"; // 单号
	$sql .= "pay_JinE='".$JinE."',"; // 支付金额
	$sql .= "pay_Date='".$Date."'"; // 支付日期
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("支付表添加成功~"); // 执行成功
		}
		else
		{
			echo("支付表添加失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}
	
	// 获取客户的余额
 	$member = "Select * FROM member WHERE member_name='".$Member."';";
    $result=mysql_query($member); // 执行SQL语句
	$row = mysql_fetch_array($result); // 获得记录
	
	$Member_YuE = 0.00; // 声明浮点数
	$Member_YuE = $row['member_YuE']; // 会员的余额
	$Member_id = $row['member_id']; // 会员编号
            	
	$Member_YuE += $JinE; // 余额 = 余额 + 金额

	// 将余额写入数据库
	$member  = "UPDATE member SET ";
	$member .= "member_YuE='".$Member_YuE."'"; // 余额
	$member .= " WHERE ";
	$member .= "member_id='".$Member_id."';"; // 单位
	mysql_query($member); // 执行SQL语句
	
	mysql_close($conn); // 关闭数据库连接
?>
