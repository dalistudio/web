<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 客户价目 - 数据表
// 删除 - 根据编号删除记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Id = $_GET['id'];
	
	$sql  = "DELETE FROM goods ";
	$sql .= " WHERE ";
	$sql .= "goods_id='".$Id."'"; // 编号
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("客户价目删除成功~"); // 执行成功
			header('Location: /admin/goods.php');
		}
		else
		{
			echo("客户价目删除失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
