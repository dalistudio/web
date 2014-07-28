<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include 'session.inc';
	include 'conn.php';
	$Id = $_GET['id']; // 单号
	if($Id <= 100000) // 门禁卡的编号范围最大10万张
	{
		$sql="Select * FROM card WHERE card_KaHao='".$Id."';"; // 根据卡号查表
		$result=mysql_query($sql); // 执行SQL语句
		$row = mysql_fetch_array($result); // 记录
		{
			$KaHao = $row['card_KaHao']; // 卡号
			$CheHao = $row['card_CheHao']; // 车号
			$CheXing = $row['card_CheXing']; // 车型
			$DianHua = $row['card_DianHua']; // 电话
			$DanWei = $row['card_DanWei']; // 单位
		}
		// 返回JSON数据
		if(empty($row))
		{
			print('[');
			print('"0"'); // 返回0，表示数据库中没有找到这个卡号
			print(']');
		}
		else
		{
			print('[');
			print('"'.$KaHao.'",');
			print('"'.$CheHao.'",');
			print('"'.$CheXing.'",');
			print('"'.$DianHua.'",');
			print('"'.$DanWei.'"');
			print(']');
		}
	}
?>