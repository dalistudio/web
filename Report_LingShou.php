<?php
//	include 'session.inc';
	include 'conn.php';
	
	$User = $_POST['user'];
	$Start = $_POST['start'];
	$End = $_POST['end'];
	
	$sql  = "SELECT * FROM bill WHERE ";
	$sql .= "bill_SiBangYuan='".$User."' and "; // 用户名
//	$sql .= "DATE_FORMAT(bill_GuoBang2,'%Y-%m-%d')='2014-06-08'";
//	$sql .= "bill_GuoBang2 >= '2014-06-08 00:00:00' and bill_GuoBang2 <= '2014-06-08 23:00:00'";
	$sql .= "bill_GuoBang2 >= '".$Start."' and bill_GuoBang2 <= '".$End."'";
	
//	print($sql);
	$result=mysql_query($sql); // 执行SQL语句
	
	print('<html>');
	print('<head>');
//	print('<title>交接班</title>');
	print('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />');
	print('</head>');
	print('<body>');
	print('<h1 align="center">日统计表（零售）</h1>');
	print('<div>');
	print('<span style="float:left">开始时间：'.$Start.'&emsp;&emsp;&emsp;&emsp;结束时间：'.$End.'</span>');
	print('<span style="float:right"><b>(单位：元)&emsp;</b></span>');
	print('</div>');
	
	print('<table align="center" width="100%" border="1" cellspacing="0" cellpadding="0">');
	print('<tr>');
	print('<td align="center">');
	print('<b>序号</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>货物</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>规格</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>车型</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>车数</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>数量(吨)</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>数量(立方)</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>单价</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>金额</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>累计金额</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>累计吨数</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>累计立方</b>');
	print('</td>');
	print('</tr>');
	$id = 1;
	$HeJi = 0;
	while($row = mysql_fetch_array($result)) // 循环每条记录
	{
		// 序号 单位 车号 车型 单号 货物 规格 重量 金额 司磅员
		print('<tr>');
		print('<td align="center">');
		print('&nbsp;'.$id); // 序号
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 货物
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 规格
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 车型
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 车数
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 数量(吨)
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 数量(立方)
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 单价(元)
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 金额
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 累计金额
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 累计吨数
		print('</td>');
		print('<td align="center">');
		print('&nbsp;'); // 累计立方
		print('</td>');
		print('</tr>');
		
		$id +=1;
		$HeJi += $row['bill_JinE'];
	}
	
	print('<tr>');
	print('<td colspan="4" align="right">');
	print('合计：');
	print('</td>');
	print('<td align="center">');
	print('&nbsp;'); // 车数
	print('</td>');
	print('<td align="center">');
	print('&nbsp;'); // 数量(吨)
	print('</td>');
	print('<td align="center">');
	print('&nbsp;'); // 数量(立方)
	print('</td>');
	print('<td align="center">');
	print('&nbsp;'); // 单价(元)
	print('</td>');
	print('<td align="center">');
	print('&nbsp;'); // 金额
	print('</td>');
	print('<td align="center">');
	print('&nbsp;'); // 累计金额
	print('</td>');
	print('<td align="center">');
	print('&nbsp;'); // 累计吨数
	print('</td>');
	print('<td align="center">');
	print('&nbsp;'); // 累计立方
	print('</td>');
	print('</tr>');
	print('</table>');
	
	print('<table align="center" width="100%" border="0">');
	print('<tr>');
	print('<td width="33%">');
	print('审核人：');
	print('</td>');
	print('<td width="33%">');
	print('复核人：');
	print('</td>');
	print('<td width="33%">');
	print('制表人：');
	print('</td>');
	print('</tr>');
	print('<tr>');
	print('<td colspan="3">');
	print('1、本表一式四份，报送总经理、副总经理、财务各一份，制表人自留一份。');
	print('</td>');
	print('</tr>');
	print('<tr>');
	print('<td colspan="3">');
	print('2、本表按品名、规格不同分类统计。');
	print('</td>');
	print('</tr>');
	print('</table>');
	
	print('</body>');
	print('</html>');
?>