<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

	include 'session.inc';
	include 'conn.php';
	$CheHao = $_GET['chehao'];
	
	// 这里的车号不需要进行编码转换 
	
	$sql  = "SELECT * FROM car WHERE ";
	$sql .= "car_CheHao='".iconv('GB2312', 'UTF-8', $CheHao)."';";

//	print($sql);
	$result=mysql_query($sql); // 执行SQL语句
	
	print('[');
	while($row = mysql_fetch_array($result)) // 循环每条记录
	{
		$car_CheHao = $row['car_CheHao']; // 车号
		$car_CheXing = $row['car_CheXing']; // 车型
		$car_DanWei = $row['car_DanWei']; // 单位
		$car_HuoWu = $row['car_HuoWu']; // 货物名称
		$car_GuiGe = $row['car_GuiGe']; // 货物的规格
		$car_XianZhong = $row['car_XianZhong']; // 限重 v1.7.1
		print('"'.$car_CheHao.'",');
		print('"'.$car_CheXing.'",');
		print('"'.$car_DanWei.'",');
		print('"'.$car_HuoWu.'",');
		print('"'.$car_GuiGe.'",');
		print('"'.$car_XianZhong.'",'); // 限重 v1.7.1
	}
	print('"0"');
	print(']');
	
?>