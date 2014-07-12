<?php
//
// 会员
// 更新 - 根据会员名称更新记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Name = $_GET['Name'];
	$DianHua = $_GET['DianHua'];
	$YuE = $_GET['YuE'];
	
	$sql  = "UPDATE member SET ";
	$sql .= "member_DianHua='".$DianHua."',"; // 会员电话
	$sql .= "member_YuE='".$YuE."'"; // 会员余额
	$sql .= " WHERE ";
	$sql .= "member_name='".$Name."'"; // 会员名称
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("会员更新成功~"); // 执行成功
		}
		else
		{
			echo("会员更新失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
