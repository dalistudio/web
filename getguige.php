<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

	include 'session.inc';
	include 'conn.php';
	$HuoWu = $_GET['huowu'];
	
	// 这里的货物不需要进行编码转换
	
	$sql  = "SELECT * FROM type WHERE ";
	$sql .= "type_HuoWu='".iconv('GB2312', 'UTF-8', $HuoWu)."';";

//	print($sql);
	$result=mysql_query($sql); // 执行SQL语句
	
	print('[');
	while($row = mysql_fetch_array($result)) // 循环每条记录
	{
		$type_GuiGe = $row['type_GuiGe']; // 货物的规格
		print('"'.$type_GuiGe.'",');
	}
	print('"0"');
	print(']');
	
?>