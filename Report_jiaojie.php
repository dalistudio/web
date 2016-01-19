<?php
//	include 'session.inc';
	include 'conn.php';
	
	$User = $_POST['user'];
	$Start = $_POST['start'];
	$End = $_POST['end'];
	
	// 编码转换
	$User = iconv('GB2312', 'UTF-8', $User); // 用户名
	
	// 错误报告 
	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	
	date_default_timezone_set('PRC'); // 中国+8时区

	if (PHP_SAPI == 'cli') // 判断如果是PHP客户端
		die('这个代码只能在Web浏览器中运行。');
	
	require_once dirname(__FILE__) . '/excel/Classes/PHPExcel.php'; // 引入EXCEL类
	$objPHPExcel = new PHPExcel(); // 创建EXCEL对象
	$objPHPExcel->getProperties()->setCreator("wangdali") // 创建者
							 ->setLastModifiedBy("wangdali") // 最后修改者
							 ->setTitle("Stone Report") // 标题
							 ->setSubject("Shift report") // 子标题
							 ->setDescription("Sales ledger") // 描述
							 ->setKeywords("report") // 关键字
							 ->setCategory("report"); // 类别

//***********************画出单元格边框*****************************  
    $styleArray = array(  
        'borders' => array(  
            'outline' => array(  
                'style' => PHPExcel_Style_Border::BORDER_THIN,//细边框  
                //'color' => array('argb' => 'FFFF0000'),  
            ),  
        ),  
    );  
	
	$styleArrayBold = array(  
        'borders' => array(  
            'outline' => array(  
                'style' => PHPExcel_Style_Border::BORDER_THICK,//边框是粗的 
                //'color' => array('argb' => 'FFFF0000'),  
            ),  
        ),  
    );  
//这里就是画出从单元格A5到N5的边框，看单元格最右边在哪哪个格就把这个N改为那个字母替代 
//    $objWorksheet->getStyle('A5:N'.$n)->applyFromArray($styleArray); 
//***********************画出单元格边框结束*****************************   

	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8); // 设置A列的宽度
	
	$objPHPExcel->getActiveSheet()->mergeCells('A1:K1'); // 合并字段
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', '交接班报表');
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('宋体' ); // 字体
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20); // 大小
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true); // 粗体
	$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //水平方向上中间居中
	$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray($styleArray); 
	
	$objPHPExcel->getActiveSheet()->mergeCells('A2:B2');
	$objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
	$objPHPExcel->getActiveSheet()->mergeCells('E2:F2');
	$objPHPExcel->getActiveSheet()->mergeCells('G2:H2');
	$objPHPExcel->getActiveSheet()->mergeCells('I2:J2');
	$objPHPExcel->getActiveSheet()->mergeCells('K2:K2');
	$objPHPExcel->getActiveSheet()->getStyle('A2:B2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('C2:D2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('E2:F2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('G2:H2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('I2:J2')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('K2:K2')->applyFromArray($styleArray);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A2', '开始时间：')
	->setCellValue('C2', $Start)
	->setCellValue('G2', '结束时间：')
	->setCellValue('I2', $End)
	->setCellValue('K2', '单位(元)');
	
	$objPHPExcel->getActiveSheet()->mergeCells('K3:K3');
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
	->setCellValue('J3', '司磅员')
	->setCellValue('K3', '备注');
	$objPHPExcel->getActiveSheet()->getStyle('A3:A3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('B3:B3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('C3:C3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('D3:D3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('E3:E3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('F3:F3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('G3:G3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('H3:H3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('I3:I3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('J3:J3')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('K3:K3')->applyFromArray($styleArray);
	
//////////////////////////////////////
// 查数据库，循环显示	
	
	$excel_pos = 4; // 行号
	$HeJi_ZhongLiang = 0; // 合计重量
	$HeJi_JinE = 0; // 合计金额
	
	$type_sql  = "SELECT * FROM type;";
	$type_result=mysql_query($type_sql); // 执行SQL语句
	while($type_row = mysql_fetch_array($type_result)) // 循环货物类型表
	{
		$id = 1; // 序号，每一类货物都重新编号
		$XiaoJi_ZhongLiang = 0; // 小计重量
		$XiaoJi_JinE = 0; // 小计金额
		$bill_sql  = "SELECT * FROM bill WHERE ";
		$bill_sql .= "bill_SiBangYuan='".$User."' and "; // 用户名
		$bill_sql .= "bill_HuoWu='".$type_row['type_HuoWu']."' and "; // 货物
		$bill_sql .= "bill_GuiGe='".$type_row['type_GuiGe']."' and "; // 规格
		$bill_sql .= "bill_GuoBang2 >= '".$Start."' and bill_GuoBang2 <= '".$End."'";
		$bill_sql .= " and bill_JinE<>0"; // 金额不等于0
		$bill_sql .= ";";
		$bill_result=mysql_query($bill_sql); // 执行SQL语句
		while($bill_row = mysql_fetch_array($bill_result)) // 循环单据表
		{
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$excel_pos, $id)
			->setCellValue('B'.$excel_pos, $bill_row['bill_DanHao'])
			->setCellValue('C'.$excel_pos, $bill_row['bill_DanWei'])
			->setCellValue('D'.$excel_pos, $bill_row['bill_CheHao'])
			->setCellValue('E'.$excel_pos, $bill_row['bill_CheXing'])
			->setCellValue('F'.$excel_pos, $type_row['type_HuoWu'])
			->setCellValue('G'.$excel_pos, $type_row['type_GuiGe'])
			->setCellValue('H'.$excel_pos, $bill_row['bill_JingZhong'])
			->setCellValue('I'.$excel_pos, $bill_row['bill_JinE'])
			->setCellValue('J'.$excel_pos, $bill_row['bill_SiBangYuan'])
			->setCellValue('K'.$excel_pos, $bill_row['bill_BeiZhu']);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$excel_pos.':A'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('B'.$excel_pos.':B'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('C'.$excel_pos.':C'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('D'.$excel_pos.':D'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('E'.$excel_pos.':E'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('F'.$excel_pos.':F'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('G'.$excel_pos.':G'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$excel_pos.':H'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$excel_pos.':I'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$excel_pos.':J'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('K'.$excel_pos.':K'.$excel_pos)->applyFromArray($styleArray);
		
			$excel_pos +=1; // 计算行号
			$id +=1; // 计算序号
			$XiaoJi_ZhongLiang += $bill_row['bill_JingZhong']; // 计算小计重量
			$XiaoJi_JinE += $bill_row['bill_JinE']; // 计算小计金额
			$HeJi_ZhongLiang += $bill_row['bill_JingZhong']; // 计算合计重量
			$HeJi_JinE += $bill_row['bill_JinE']; // 计算合计金额
		}
		if(strcmp($XiaoJi_JinE,'0')!=0)
		{
//			$objPHPExcel->getActiveSheet()->mergeCells('A'.$excel_pos.':G'.$excel_pos);
			$objPHPExcel->getActiveSheet()->mergeCells('J'.$excel_pos.':K'.$excel_pos);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$excel_pos.':G'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('J'.$excel_pos.':K'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('G'.$excel_pos, '小计：')
			->setCellValue('H'.$excel_pos, $XiaoJi_ZhongLiang)
			->setCellValue('I'.$excel_pos, $XiaoJi_JinE);
			$objPHPExcel->getActiveSheet()->getStyle('A'.$excel_pos.':G'.$excel_pos)->applyFromArray($styleArray);
			$objPHPExcel->getActiveSheet()->getStyle('H'.$excel_pos.':H'.$excel_pos)->applyFromArray($styleArrayBold);
			$objPHPExcel->getActiveSheet()->getStyle('I'.$excel_pos.':I'.$excel_pos)->applyFromArray($styleArrayBold);

			$excel_pos +=1; // 计算行号
			$objPHPExcel->getActiveSheet()->mergeCells('A'.$excel_pos.':K'.$excel_pos);
			$excel_pos +=1; // 计算行号
		}
		
	}
//////////////////////////////////////	

	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('G'.$excel_pos, '合计：')
		->setCellValue('H'.$excel_pos, $HeJi_ZhongLiang)
		->setCellValue('I'.$excel_pos, $HeJi_JinE);
	$objPHPExcel->getActiveSheet()->getStyle('A'.$excel_pos.':G'.$excel_pos)->applyFromArray($styleArrayBold);
	$objPHPExcel->getActiveSheet()->getStyle('H'.$excel_pos.':H'.$excel_pos)->applyFromArray($styleArrayBold);
	$objPHPExcel->getActiveSheet()->getStyle('I'.$excel_pos.':I'.$excel_pos)->applyFromArray($styleArrayBold);
	$objPHPExcel->getActiveSheet()->getStyle('J'.$excel_pos.':K'.$excel_pos)->applyFromArray($styleArrayBold);

	$excel_pos +=2;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$excel_pos, '审核人：')
		->setCellValue('D'.$excel_pos, '出纳：')
		->setCellValue('G'.$excel_pos, '组长：')
		->setCellValue('I'.$excel_pos, '收款人：');
	$excel_pos +=1;
	$objPHPExcel->getActiveSheet()->getStyle('A1:K'.$excel_pos)->applyFromArray($styleArray); // 外框
		
	$objPHPExcel->getActiveSheet()->setTitle('交接班报表'); // 修改报表标题
	$objPHPExcel->setActiveSheetIndex(0);
	
	// 重定向输出到客户的Web浏览器 (Excel5)
	header('Content-Type: application/vnd.ms-excel'); // 设置文件类型
	header('Content-Type: application/vnd.ms-excel;charset=utf-8'); // 设置文件编码
	header('Content-Disposition: attachment;filename="Report.xls"'); // 以附件方式下载，及设置默认文件名
	header('Cache-Control: max-age=0');
	// 如果你使用IE9，则可能需要：
	header('Cache-Control: max-age=1');

	// 如果你使用 IE 的 SSL，则可能需要：
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // 最后修改日期
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');

?>