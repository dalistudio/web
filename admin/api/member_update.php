<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

//
// 会员
// 更新 - 根据会员名称更新记录
//
	include '../../session.inc';
	include '../../conn.php';
	$Id = $_GET['id'];
	$Name = $_GET['Name'];
	$DianHua = $_GET['DianHua'];
	$YuE = $_GET['YuE'];
	$Type = $_GET['Type'];
	$JingGao = $_GET['JingGao']; // 警告额度
	$XinYong = $_GET['XinYong']; // 信用额度
	$BlackList = $_GET['BlackList']; // 黑名单

	// 1、根据 id 获得原会员的名字 name
	$name_sql = "SELECT member_name FROM stone.member WHERE member_id='".$Id."';";
	$result=mysql_query($name_sql ); // 执行SQL语句
	while($row = mysql_fetch_array($result)) // 循环每条记录
	{
		$Old_Name = $row['member_name']; // 旧会员名
	}
	
	// 2、更新 member 表的数据
	$sql  = "UPDATE member SET ";
	$sql .= "member_DianHua='".$DianHua."',"; // 会员电话
	$sql .= "member_YuE='".$YuE."',"; // 会员余额
	$sql .= "member_Type='".$Type."',"; // 会员类型
	$sql .= "member_name='".$Name."',"; // 会员名称
	$sql .= "member_JingGao='".$JingGao."',"; // 警告额度
	$sql .= "member_Xinyong='".$XinYong."',"; // 信用额度
	$sql .= "member_BlackList='". $BlackList."'"; // 黑名单
	$sql .= " WHERE ";
	$sql .= "member_id='".$Id."'";
	$sql .= ";";
//	print($sql);
	
	if(inject_check($sql))
	{
		if(mysql_query($sql,$conn)) // 执行语句
		{
			// 3、更新 member 成功后，更新 pay 表的原会员为新会员名
			if(strcmp($Name,$Old_Name)!=0)
			{
				// 开启事务
				mysql_query("BEGIN",$conn);

				// 设置安全更新
				mysql_query("SET session SQL_SAFE_UPDATES=0;",$conn);

				$update_sql = "UPDATE pay SET member_name='".$Name."' WHERE member_name='".$Old_Name."';";
				mysql_query($update_sql,$conn);

				// 提交事务
				mysql_query("COMMIT",$conn); // 提交
			}
//			echo("会员更新成功~"); // 执行成功
			header('Location: /admin/member.php');
		}
		else
		{
			echo("会员更新失败！！！\n");
			echo("ERROR：". mysql_error()); // 执行失败
		}
	}

	mysql_close($conn); // 关闭数据库连接
?>
