<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 门禁卡 - 数据表
// 添加 - 卡号为唯一值
//
	include '../../session.inc';
	include '../../conn.php';
	$KaHao = $_GET['KaHao'];
	$CheHao = $_GET['CheHao'];
	$CheXing = $_GET['CheXing'];
	$DianHua = $_GET['DianHua'];
	$DanWei = $_GET['DanWei'];
	
	$sql  = "INSERT INTO card SET ";
	$sql .= "card_KaHao='".$KaHao."',"; // 卡号
	$sql .= "card_CheHao='".$CheHao."',"; // 车号
	$sql .= "card_CheXing='".$CheXing."',"; // 车型
	$sql .= "card_DianHua='".$DianHua."',"; // 电话
	$sql .= "card_DanWei='".$DanWei."'"; // 单位
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("门禁卡添加成功~"); // 执行成功
		}
		else
		{
			echo("门禁卡添加失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
