<?php
	include 'session.inc';
	include 'conn.php';
	$HuoWu = $_GET['huowu'];
	
	// ����Ļ��ﲻ��Ҫ���б���ת��
	
	$sql  = "SELECT * FROM type WHERE ";
	$sql .= "type_HuoWu='".iconv('GB2312', 'UTF-8', $HuoWu)."';";

//	print($sql);
	$result=mysql_query($sql); // ִ��SQL���
	
	print('[');
	while($row = mysql_fetch_array($result)) // ѭ��ÿ����¼
	{
		$type_GuiGe = $row['type_GuiGe']; // ����Ĺ��
		print('"'.$type_GuiGe.'",');
	}
	print('"0"');
	print(']');
	
?>