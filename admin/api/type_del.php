<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 类型
// 删除 - 根类型编号删除记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Id = $_GET['id'];
	
	$sql  = "DELETE FROM type ";
	$sql .= " WHERE ";
	$sql .= "type_id='".$Id."'"; // 会员名称
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("类型删除成功~"); // 执行成功
			header('Location: /admin/type.php');
		}
		else
		{
			echo("类型删除失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
