<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 门禁卡 - 数据表
// 更新 - 根据卡号修改记录
//
	include '../../session.inc';
	include '../../conn.php';
	$KaHao = $_GET['KaHao'];
	$CheHao = $_GET['CheHao'];
	$CheXing = $_GET['CheXing'];
	$DianHua = $_GET['DianHua'];
	$DanWei = $_GET['DanWei'];
	
	$sql  = "UPDATE card SET ";
	$sql .= "card_CheHao='".$CheHao."',"; // 车号
	$sql .= "card_CheXing='".$CheXing."',"; // 车型
	$sql .= "card_DianHua='".$DianHua."',"; // 电话
	$sql .= "card_DanWei='".$DanWei."'"; // 单位
	$sql .= " WHERE ";
	$sql .= "card_KaHao='".$KaHao."'"; // 卡号
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("门禁卡更新成功~"); // 执行成功
			header('Location: /admin/card.php');
		}
		else
		{
			echo("门禁卡更新失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
