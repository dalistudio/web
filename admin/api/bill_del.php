<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 过磅单 - 数据表
// 删除 - 根据编号删除记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Id = $_GET['id'];
	
	$sql  = "DELETE FROM bill ";
	$sql .= " WHERE ";
	$sql .= "bill_id='".$Id."'"; // 编号
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("过磅单删除成功~"); // 执行成功
//			header('Location: /admin/bill.php');
		}
		else
		{
			echo("过磅单删除失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
