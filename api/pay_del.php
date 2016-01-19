<?php
//
// 支付 - 数据表
// 删除 - 根据卡号删除记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Id = $_GET['id'];
	
	$sql  = "DELETE FROM pay ";
	$sql .= " WHERE ";
	$sql .= "pay_id='".$Id."'"; // 支付号
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("支付表删除成功~"); // 执行成功
		}
		else
		{
			echo("支付表删除失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
