<?php
	include 'session.inc';
	include 'conn.php';
	$DanWei = $_GET['DanWei'];
	
	$sql  = "SELECT * FROM member WHERE ";
	$sql .= "member_name='".iconv('GB2312', 'UTF-8', $DanWei)."';";

//	print($sql);
	$result=mysql_query($sql); // 执行SQL语句
	$row = mysql_fetch_array($result); // 循环每条记录

	$YuE = $row['member_YuE']; 
	print($YuE);
	
?>