<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include 'session.inc';
	include 'conn.php';
	
	$datetime = strtotime("now"); // 获得当前日期
	$mysqldate = date("Y-m-d H:i:s", $datetime); // 转换日期为指定字符串
	
	$sql  = "Select * FROM bill WHERE ";
	$sql .= "(";
	$sql .= "bill_ZhuangTai='0'"; // 第一次提交的单据
//	$sql .= " or ";
//	$sql .= "bill_ZhuangTai='1'"; // 第二次提交的单据
	$sql .= ")";
	$sql .= " and ";
//	$sql .= "TO_DAYS(NOW()) - TO_DAYS(bill_GuoBang1) <= 1"; // 查询1天内的记录
	$sql .= "UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(bill_GuoBang1)<=86400"; // 查询1天内的记录
	$sql .= ";";

//	print("sql=".$sql);
	
	$result=mysql_query($sql); // 执行SQL语句
	print('['); 
	while($row = mysql_fetch_array($result)) // 循环每条记录
	{
		$DanHao = $row['bill_DanHao']; // 单号
		$CheHao = $row['bill_CheHao']; // 车号
		$CheXing = $row['bill_CheXing']; // 车型
		$DianHua = $row['bill_DianHua']; // 联系电话
		$DanWei = $row['bill_DanWei']; // 收货单位
		$HuoWu = $row['bill_HuoWu']; // 货物名称
		$GuiGe = $row['bill_GuiGe']; // 货物规格
		$PiZhong = $row['bill_PiZhong']; // 皮重
		$GuoBang = $row['bill_GuoBang1']; // 第一次过磅时间
		$ZhuangTai = $row['bill_ZhuangTai']; // 状态
		print('{');
			print('"id":"'.$DanHao.'",'); // 单号
			print('"ch":"'.$CheHao.'",'); // 车号
			print('"cx":"'.$CheXing.'",'); // 车型
			print('"dh":"'.$DianHua.'",'); // 电话
			print('"dw":"'.$DanWei.'",'); // 单位
			print('"hw":"'.$HuoWu.'",'); // 货物
			print('"gg":"'.$GuiGe.'",'); // 规格
			print('"pz":"'.$PiZhong.'",'); // 皮重
			print('"gb":"'.$GuoBang.'",'); // 第一次过磅时间
			print('"zt":"'.$ZhuangTai.'"'); // 状态
		print('},');
	}
		print('{"id":"0"}'); // id=0 表示结束
	print(']');
?>