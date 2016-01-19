<?php
//
// 用户
// 添加
// 
	include '../../session.inc';
	include '../../conn.php';
	$Name = $_GET['Name'];
	$Pwd = $_GET['Pwd'];
	$Level = $_GET['Level'];
	
	$sql  = "INSERT INTO user SET ";
	$sql .= "user_name='".$Name."',"; // 用户名称
	$sql .= "user_pwd='".$Pwd."',"; // 用户密码
	$sql .= "user_level='".$Level."'"; // 用户级别
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			echo("用户添加成功~"); // 执行成功
		}
		else
		{
			echo("用户添加失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
