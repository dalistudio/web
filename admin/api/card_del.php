<?php
//
// Copyright (c) 2014, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 门禁卡 - 数据表
// 删除 - 根据卡号删除记录
//
	include '../../session.inc';
	include '../../conn.php';
	$KaHao = $_GET['KaHao'];
	
	$sql  = "DELETE FROM card ";
	$sql .= " WHERE ";
	$sql .= "card_KaHao='".$KaHao."'"; // 卡号
	$sql .= ";";
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
//			echo("门禁卡删除成功~"); // 执行成功
			header('Location: /admin/card.php');
		}
		else
		{
			echo("门禁卡删除失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
