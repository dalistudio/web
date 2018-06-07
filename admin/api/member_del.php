<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 会员
// 删除 - 根据会员名称删除记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Name = $_GET['Name'];
	
	$sql  = "DELETE FROM member ";
	$sql .= " WHERE ";
	$sql .= "member_name='".$Name."'"; // 会员名称
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("会员删除成功~"); // 执行成功
			header('Location: /admin/member.php');
		}
		else
		{
			echo("会员删除失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
