<?php
//	include 'session.inc';
	include 'conn.php';
	
	$User = $_POST['user'];
	$Start = $_POST['start'];
	$End = $_POST['end'];
	
	/** Error reporting */
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('PRC');

	if (PHP_SAPI == 'cli')
		die('This example should only be run from a Web Browser');
	
	require_once dirname(__FILE__) . '/excel/Classes/PHPExcel.php'; // 引入EXCEL类
	$objPHPExcel = new PHPExcel(); // 创建EXCEL对象
	$objPHPExcel->getProperties()->setCreator("wangdali") // 创建者
							 ->setLastModifiedBy("wangdali") // 最后修改者
							 ->setTitle("Stone Report") // 标题
							 ->setSubject("Shift report") // 子标题
							 ->setDescription("Sales ledger") // 描述
							 ->setKeywords("report") // 关键字
							 ->setCategory("report"); // 类别

	$sql  = "SELECT * FROM bill WHERE ";
	$sql .= "bill_SiBangYuan='".$User."' and "; // 用户名
//	$sql .= "DATE_FORMAT(bill_GuoBang2,'%Y-%m-%d')='2014-06-08'";
//	$sql .= "bill_GuoBang2 >= '2014-06-08 00:00:00' and bill_GuoBang2 <= '2014-06-08 23:00:00'";
	$sql .= "bill_GuoBang2 >= '".$Start."' and bill_GuoBang2 <= '".$End."'";
	$sql .= " and bill_JinE<>0"; // 金额不等于0
	$sql .= ";";
//	print($sql);
	$result=mysql_query($sql); // 执行SQL语句

/*	
	print('<html>');
	print('<head>');
//	print('<title>交接班</title>');
	print('<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />');
	print('</head>');
	print('<body>');
	print('<h1 align="center">交接班报表</h2>');
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
	print('<b>单号</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>单位</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>车号</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>车型</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>货物</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>规格</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>重量</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>金额</b>');
	print('</td>');
	print('<td align="center">');
	print('<b>司磅员</b>');
	print('</td>');
	print('</tr>');
*/
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8); // 设置A列的宽度
	
	$objPHPExcel->getActiveSheet()->mergeCells('A1:J1');
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', '交接班报表');
	
	$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
	$objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
	$objPHPExcel->getActiveSheet()->mergeCells('E2:F2');
	$objPHPExcel->getActiveSheet()->mergeCells('G2:H2');
	$objPHPExcel->getActiveSheet()->mergeCells('I2:J2');
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', '开始时间：')
	->setCellValue('C2', $Start)
	->setCellValue('E2', '结束时间：')
	->setCellValue('G2', $End)
	->setCellValue('I2', '单位(元)');
	
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A3', '序号')
	->setCellValue('B3', '单号')
	->setCellValue('C3', '单位')
	->setCellValue('D3', '车号')
	->setCellValue('E3', '车型')
	->setCellValue('F3', '货物')
	->setCellValue('G3', '规格')
	->setCellValue('H3', '重量')
	->setCellValue('I3', '金额')
	->setCellValue('J3', '司磅员');
	
	$id = 1;
	$excel_pos = 4;
	$HeJi = 0;
	while($row = mysql_fetch_array($result)) // 循环每条记录
	{
/*
		// 序号 单位 车号 车型 单号 货物 规格 重量 金额 司磅员
		print('<tr>');
		print('<td>');
		print('&nbsp;'.$id); // 序号
		print('</td>');
		print('<td>');
		print('&nbsp;'.$row['bill_DanHao']); // 单号 
		print('</td>');
		print('<td>');
		print('&nbsp;'.$row['bill_DanWei']); // 单位
		print('</td>');
		print('<td>');
		print('&nbsp;'.$row['bill_CheHao']); // 车号
		print('</td>');
		print('<td>');
		print('&nbsp;'.$row['bill_CheXing']); // 车型
		print('</td>');
		print('<td>');
		print('&nbsp;'.$row['bill_HuoWu']); // 货物 
		print('</td>');
		print('<td>');
		print('&nbsp;'.$row['bill_GuiGe']); // 规格
		print('</td>');
		print('<td>');
		print('&nbsp;'.$row['bill_JingZhong']); // 重量（净重） 
		print('</td>');
		print('<td>');
		print('&nbsp;'.$row['bill_JinE']); // 金额 
		print('</td>');
		print('<td>');
		print('&nbsp;'.$row['bill_SiBangYuan']); // 司磅员
		print('</td>');
		print('</tr>');
*/
		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$excel_pos, $id)
		->setCellValue('B'.$excel_pos, $row['bill_DanHao'])
		->setCellValue('C'.$excel_pos, $row['bill_DanWei'])
		->setCellValue('D'.$excel_pos, $row['bill_CheHao'])
		->setCellValue('E'.$excel_pos, $row['bill_CheXing'])
		->setCellValue('F'.$excel_pos, $row['bill_HuoWu'])
		->setCellValue('G'.$excel_pos, $row['bill_GuiGe'])
		->setCellValue('H'.$excel_pos, $row['bill_JingZhong'])
		->setCellValue('I'.$excel_pos, $row['bill_JinE'])
		->setCellValue('J'.$excel_pos, $row['bill_SiBangYuan']);
		
		$excel_pos +=1;
		$id +=1;
		$HeJi += $row['bill_JinE'];
	}
/*	
	print('<tr>');
	print('<td colspan="8" align="right">');
	print('<b>合计：</b>');
	print('</td>');
	print('<td>');
	print($HeJi);
	print('</td>');
	print('<td>');
	print('&nbsp;');
	print('</td>');
	print('</tr>');
	print('</table>');
	
	print('<table align="center" width="100%" border="0">');
	print('<tr>');
	print('<td width="25%">');
	print('审核人：');
	print('</td>');
	print('<td width="25%">');
	print('出纳：');
	print('</td>');
	print('<td width="25%">');
	print('组长：');
	print('</td>');
	print('<td width="25%">');
	print('收款人：');
	print('</td>');
	print('</tr>');
	print('</table>');
	
	print('</body>');
	print('</html>');
*/
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('H'.$excel_pos, '合计：')
		->setCellValue('I'.$excel_pos, $HeJi);

	$excel_pos +=1;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('B'.$excel_pos, '审核人：')
		->setCellValue('D'.$excel_pos, '出纳：')
		->setCellValue('F'.$excel_pos, '组长：')
		->setCellValue('H'.$excel_pos, '收款人：');
		
	$objPHPExcel->getActiveSheet()->setTitle('交接班报表'); // 修改报表标题
	$objPHPExcel->setActiveSheetIndex(0);
	
	// Redirect output to a client’s web browser (Excel5)
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Type: application/vnd.ms-excel;charset=utf-8');
	header('Content-Disposition: attachment;filename="Report.xls"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');

	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');

?>