<?php
//
// Copyright (c) 2014-2018, wangdali <wangdali@qq.com>, All Rights Reserved.
//
	include '../conn.php';

	$Start = $_POST['start']; // 开始时间
	$End = $_POST['end']; // 结束时间
	$CheHao = $_POST['CheHao']; // 车号
	$CheXing = $_POST['CheXing']; // 车型
	$DanWei = $_POST['DanWei']; // 单位
	$HuoWu = $_POST['HuoWu']; // 货物
	$GuiGe = $_POST['GuiGe']; // 规格
	$Type = $_POST['Type']; // 支付类型
	$SiBangYuan = $_POST['SiBangYuan']; // 司磅员

	// 测试用
//	$Start = '2014-07-10 00:00:00'; // 开始时间
//	$End = '2014-07-13 23:00:00'; // 结束时间
//	$CheHao = ''; // 车号
//	$CheXing = ''; // 车型
//	$DanWei = ''; // 单位
//	$HuoWu = ''; // 货物
//	$GuiGe = ''; // 规格
	
	// 报表名称
	switch($Type)
	{
		case "":
			$Title = "全部客户报表";
			break;
		case "0":
			$Title = "零售客户报表";
			break;
		case "1":
			$Title = "预存款客户报表";
			break;
		case "2":
			$Title = "月结客户报表";
			break;
	}
	//////////////////////////////////////////////////////////////////
	// 这里输出 HTML
	print('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">');
	print('<html xmlns="http://www.w3.org/1999/xhtml">');
	print('<head>');
	print('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />');
	print('<title>财务报表</title>');
	print('</head>');
	print('<body>');
	print('<table width="100%" border="1">');
	print('<tr><td colspan="11" align="center"><h1>'.$Title.'</h1></td></tr>');
	
	print('<tr>');
	print('<td align="right">开始时间：</td>');
	print('<td align="left" colspan="2">'.$Start.'</td>');
	print('<td>&nbsp;</td>');
	print('<td align="right">结束时间：</td>');
	print('<td align="left" colspan="2">'.$End.'</td>');
	print('<td>&nbsp;</td>');
	print('<td>&nbsp;</td>');
	print('<td align="right">重量：KG</td>');
	print('<td align="right">单位：元</td>');
	print('</tr>');
	
	print('<tr align="center">');
	print('<td><b>序号</b></td>');
	print('<td><b>单号</b></td>');
	print('<td><b>车号</b></td>');
	print('<td><b>车型</b></td>');
	print('<td><b>客户</b></td>');
	print('<td><b>货物</b></td>');
	print('<td><b>规格</b></td>');
	print('<td><b>净重</b></td>');
	print('<td><b>金额</b></td>');
	print('<td><b>司磅员</b></td>');
	print('<td><b>第二次过磅时间</b></td>');
	print('</tr>');
	//////////////////////////////////////////////////////////////////
	// 货物类型表
	$type_sql  = "SELECT * FROM type;";
	$type_result=mysql_query($type_sql); // 执行SQL语句

	$HeJi_JingZhong = 0; // 合计净重
	$HeJi_JinE = 0; // 合计金额
	while($type_row = mysql_fetch_array($type_result)) // 循环货物类型表
	{
		if(strcmp($HuoWu,'')==0 && strcmp($GuiGe,'')==0) // 如果货物和规格为空，则循环所有货物
		{
			$HuoWu2 = $type_row['type_HuoWu'];
			$GuiGe2 = $type_row['type_GuiGe'];
		}
		else // 否则，只显示指定货物下的所有规格
		{
			// 如果货物和规格都不为空
			if(strcmp($HuoWu,'')!=0 && strcmp($GuiGe,'')!=0)
			{
				if(strcmp($HuoWu,$type_row['type_HuoWu'])==0 && strcmp($GuiGe,$type_row['type_GuiGe'])==0)
				{
					$HuoWu2 = $HuoWu;
					$GuiGe2 = $GuiGe;
				}
				else
				{
					continue;
				}
			}
			
			// 如果货物为空，规格不为空
			if(strcmp($HuoWu,'')==0 && strcmp($GuiGe,'')!=0)
			{
				// 不处理，都跳过
				continue;
			}
			
			// 如果货物不为空，规格为空
			if(strcmp($HuoWu,'')!=0 && strcmp($GuiGe,'')==0)
			{
				if(strcmp($HuoWu,$type_row['type_HuoWu'])==0)
				{
					$HuoWu2 = $HuoWu;
					$GuiGe2 = $type_row['type_GuiGe'];
				}
				else
				{
					continue;
				}
			}
		} // if end
		
		
		// 单据表
		$bill_sql = "SELECT * FROM bill WHERE ";
		$bill_sql .= "bill_GuoBang2 >= '".$Start."' and "; // 开始时间
		$bill_sql .= "bill_GuoBang2 <= '".$End."' and "; // 结束时间
		if(strcmp($CheHao,'')!=0)$bill_sql .= "bill_CheHao='".$CheHao."' and "; // 车号
		if(strcmp($CheXing,'')!=0)$bill_sql .= "bill_CheXing='".$CheXing."' and "; // 车型
		if(strcmp($DanWei,'')!=0)$bill_sql .= "bill_DanWei='".$DanWei."' and "; // 单位
		if(strcmp($HuoWu2,'')!=0)$bill_sql .= "bill_HuoWu='".$HuoWu2."' and "; // 货物
		if(strcmp($GuiGe2,'')!=0)$bill_sql .= "bill_GuiGe='".$GuiGe2."' and "; // 规格
		if(strcmp($Type,'')!=0)$bill_sql .= "bill_Type='".$Type."' and "; // 支付类型
		if(strcmp($SiBangYuan,'')!=0)$bill_sql .= "bill_SiBangYuan='".$SiBangYuan."' and "; // 司磅员
//		$bill_sql .= "bill_JinE<>0"; // 金额不等于0
		$bill_sql .= "bill_ZhuangTai>=1"; // 完成第二次过磅的单
		$bill_sql .= " ORDER BY bill_HuoWu DESC "; // 按货物进行排序
		$bill_sql .= ";";
	
//		print($bill_sql.'<br />');

		$bill_result = mysql_query($bill_sql); // 执行SQL语句
		$id=1;
		$XiaoJi_JingZhong = 0; // 小计净重
		$XiaoJi_JinE = 0; // 小计金额
		while($bill_row = mysql_fetch_array($bill_result)) // 循环每条记录
		{
			// 这里显示表的内容
			print('<tr align="center">');
			
			print('<td>');
			print($id); // 0、序号
			print('</td>');
			
			print('<td>');
			print($bill_row['bill_DanHao']); // 1、单号
			print('</td>');
			
			print('<td>');
			print($bill_row['bill_CheHao']); // 2、车号
			print('</td>');
			
			print('<td>');
			print($bill_row['bill_CheXing']); // 3、车型
			print('</td>');
			
			print('<td>');
			print($bill_row['bill_DanWei']); // 4、单位
			print('</td>');
			
			print('<td>');
			print($bill_row['bill_HuoWu']); // 5、货物
			print('</td>');
			
			print('<td>');
			print($bill_row['bill_GuiGe']); // 6、规格
			print('</td>');
			
			print('<td>');
			print($bill_row['bill_JingZhong']); // 7、净重
			print('</td>');
			
			print('<td>');
			print($bill_row['bill_JinE']); // 8、金额
			print('</td>');
			
			print('<td>');
			print($bill_row['bill_SiBangYuan']); // 9、司磅员
			print('</td>');
			
			print('<td>');
			print($bill_row['bill_GuoBang2']); // 10、第二次过磅时间
			print('</td>');
			
			print('</tr>');
			
			$id+=1;
			$XiaoJi_JingZhong += $bill_row['bill_JingZhong']; // 小计净重
			$XiaoJi_JinE += $bill_row['bill_JinE']; // 小计金额
			$HeJi_JingZhong += $bill_row['bill_JingZhong']; // 合计净重
			$HeJi_JinE += $bill_row['bill_JinE']; // 合计金额
		} // bill
		// 输出小计
		if(strcmp($XiaoJi_JinE,'0')!=0)
		{
			print('<tr>');
			print('<td colspan="7" align="right">小计：</td>');
			print('<td align="center">'.$XiaoJi_JingZhong.'</td>');
			print('<td align="center">'.$XiaoJi_JinE.'</td>');
			print('<td>&nbsp;</td>');
			print('<td>&nbsp;</td>');
			print('</tr>');
		
			print('<tr><td colspan="11">&nbsp;</td></tr>');
		}
	} // type
	print('<tr>');
	print('<td colspan="7" align="right">合计：</td>');
	print('<td align="center">'.$HeJi_JingZhong.'</td>');
	print('<td align="center">'.$HeJi_JinE.'</td>');
	print('<td>&nbsp;</td>');
	print('<td>&nbsp;</td>');
	print('</tr>');
	
	//////////////////////////////////////////////////////////////////
	// 这里输出 HTML
	print('</table>');
	print('</body>');
	print('</html>');
	//////////////////////////////////////////////////////////////////
?>