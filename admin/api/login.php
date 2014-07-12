<?php
	include '../../session.inc';
	include '../../conn.php';
	
	$User = $_POST['user'];  // 用户名
	$Pwd  = $_POST['pwd'];   // 密码
	$Level= $_POST['level']; // 级别
	$User = iconv('GB2312', 'UTF-8', $User); // 中文转码
	
	// 检查登陆信息
function check_auth($User,$Pwd,$Level)
{
	// 判断如果用户名和密码正确
	// 这里需要搜索数据库
	$sql="Select * FROM user WHERE user_name='".$User."';";
	if(inject_check($sql))
	{
		$result=mysql_query($sql); // 执行SQL语句
	}
	
	while($row = mysql_fetch_array($result)) // 循环每条记录
	{
		if($User == $row['user_name']) // 比较用户名
		{
			if(($Pwd == $row['user_pwd']) && ($Level==$row['user_level'])) // 比较用户密码和级别
			{
				setcookie("AID","AAAAABBBBBCCCCCDDDDDEEEEE"); // 身份ID,最好每个用户生成不同的ID

				$UserId = $row['user_id']; // 获得数据库中用户ID
				$_SESSION['id'] = $UserId;
				$_SESSION['User'] = $User;
				$_SESSION['Level'] = $Level;
				$name = $User; // 设置$name的值
				return $name; // 返回$name的值
			}
			else
			{
				return false; // 返回假，阻止POST请求
			}
		}
		else // 错误
		{
			return false; // 返回假，阻止POST请求
		}	
	}
	mysql_close($conn); // 关闭数据库连接
}

// 如果提交按钮存在且不为空，并且检查登陆信息正确
if($name=check_auth($User, $Pwd, $Level))
{
    $_SESSION['name'] = $name; // 用户名称
	header('Location: ../main.php'); // 跳转到规则页面
	die(); // 不执行之后的代码
}
else
{
	header('Location: ../index.php'); // 跳转到规则页面
	die(); // 不执行之后的代码
}
?>