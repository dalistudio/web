<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//

	include 'session.inc';
	include 'conn.php';
	
	$Id = $_GET['id']; // 单号
	if($Id==0)
	{
		// 查询数据库，获得sys表中的增量单号
		// 并加1返回新的单号。
		$sql="Select * FROM sys WHERE sys_id=1;";
		$result=mysql_query($sql); // 执行SQL语句
		while($row = mysql_fetch_array($result)) // 循环每条记录
		{
			$DanHao = $row['sys_DanHao']; // 单号
		}
		$DanHao += 1; // 单号 +1
		print('{"id":"'.$DanHao.'"}'); // 返回JSON数据
		
		// 更新单号
		$sql="UPDATE sys SET ";
		$sql .= "sys_DanHao="."'".$DanHao."'"; 
		$sql .= " WHERE ";
		$sql .= "sys_id=1";
		$sql .= ";";
		mysql_query($sql,$conn);
	}
	else // 获得表中的单号数据
	{
		$sql="Select * FROM bill WHERE bill_DanHao='".$Id."';"; // 根据单号查询数据
		if(inject_check($sql))
		{
			$result=mysql_query($sql); // 执行SQL语句
		}
	
		$row = mysql_fetch_array($result);
		//while($row = mysql_fetch_array($result)) // 循环每条记录
		{
			if(empty($row))
			{
				print('{');
				print('"id":"0"'); // 返回ID为0，表示数据库中没有找到这个单号
				print('}');
			}
			else
			{
				print('{');
				print('"id":"'.$row['bill_DanHao'].'",'); // 单号
				print('"ch":"'.$row['bill_CheHao'].'",'); // 车号
				print('"cx":"'.$row['bill_CheXing'].'",'); // 车型
				print('"dh":"'.$row['bill_DianHua'].'",'); // 电话
				print('"dw":"'.$row['bill_DanWei'].'",'); // 单位
				print('"hw":"'.$row['bill_HuoWu'].'",'); // 货物
				print('"gg":"'.$row['bill_GuiGe'].'",'); // 规格
				print('"pz":"'.$row['bill_PiZhong'].'",'); // 皮重
				print('"mz":"'.$row['bill_MaoZhong'].'",'); // 毛重
				print('"jz":"'.$row['bill_JingZhong'].'",'); // 净重
				print('"dj":"'.$row['bill_DanJia'].'",'); // 单价
				print('"djdw":"'.$row['bill_DanJiaDanWei'].'",'); // 单价单位
				print('"md":"'.$row['bill_MiDu'].'",'); // 密度
				print('"je":"'.$row['bill_JinE'].'",'); // 金额
				print('"ye":"'.$row['bill_YuE'].'",'); // 余额
				print('"bz":"'.$row['bill_BeiZhu'].'",'); // 备注
				print('"gb1":"'.$row['bill_GuoBang1'].'",'); // 第一次过磅时间
				print('"gb2":"'.$row['bill_GuoBang2'].'",'); // 第二次过磅时间
				print('"cc":"'.$row['bill_ChuChang'].'",'); // 出场时间
				print('"sby":"'.$row['bill_SiBangYuan'].'",'); // 司磅员
				print('"bay":"'.$row['bill_BaoAnYuan'].'",'); // 保安员
				print('"zt":"'.$row['bill_ZhuangTai'].'",'); // 状态
				print('"type":"'.$row['bill_Type'].'"'); // 支付类型
				print('}');
			}
			
		}
	}
	mysql_close($conn); // 关闭数据库连接
?>